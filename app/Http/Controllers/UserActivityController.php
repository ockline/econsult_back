<?php

namespace App\Http\Controllers;

use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserActivityController extends Controller
{
    /**
     * Store a new daily activity
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'activity_date' => 'required|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => [
                'nullable',
                'date_format:H:i',
                Rule::when($request->filled('start_time'), 'after_or_equal:start_time'),
            ],
            'title' => 'nullable|string|max:255',
            'description' => 'required|string',
            'rating' => 'nullable|integer|min:1|max:5',
            'status' => 'nullable|string|in:completed,in_progress,pending',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $activity = UserActivity::create([
            'user_id' => Auth::id(),
            'activity_date' => $request->activity_date,
            'start_time' => $request->start_time ? $request->start_time . ':00' : null,
            'end_time' => $request->end_time ? $request->end_time . ':00' : null,
            'title' => $request->title ? mb_strtoupper($request->title) : null,
            'description' => $request->description,
            'rating' => $request->rating,
            'status' => $request->status ?? 'completed',
        ]);

        return response()->json(['message' => 'Activity saved successfully', 'activity' => $activity], 201);
    }

    /**
     * List current user's activities (with optional date filter)
     */
    public function index(Request $request)
    {
        $query = UserActivity::where('user_id', Auth::id())
            ->orderBy('activity_date', 'desc')
            ->orderBy('created_at', 'desc');

        if ($request->has('date_from')) {
            $query->whereDate('activity_date', '>=', $request->date_from);
        }
        if ($request->has('date_to')) {
            $query->whereDate('activity_date', '<=', $request->date_to);
        }

        $activities = $query->limit(100)->get();
        return response()->json(['activities' => $activities]);
    }

    /**
     * Get current user's performance stats
     */
    public function performance(Request $request)
    {
        $userId = Auth::id();
        $daysBack = (int) ($request->get('days', 30));
        $from = now()->subDays($daysBack)->startOfDay();

        $activities = UserActivity::where('user_id', $userId)
            ->where('activity_date', '>=', $from)
            ->get();

        $totalActivities = $activities->count();
        $daysWithActivities = $activities->pluck('activity_date')->unique()->count();
        $avgRating = $activities->whereNotNull('rating')->avg('rating');

        // Performance score: weighted by consistency and volume
        // Base: 1 point per activity, bonus for daily consistency
        $baseScore = min($totalActivities * 2, 100);
        $consistencyBonus = min(($daysWithActivities / max($daysBack, 1)) * 30, 30);
        $ratingBonus = $avgRating ? (($avgRating - 1) / 4) * 20 : 0;
        $performanceScore = min(round($baseScore + $consistencyBonus + $ratingBonus), 100);

        $recentActivities = UserActivity::where('user_id', $userId)
            ->where('activity_date', '>=', $from)
            ->orderBy('activity_date', 'desc')
            ->limit(10)
            ->get(['activity_date', 'start_time', 'end_time', 'title', 'description', 'rating']);

        return response()->json([
            'total_activities' => $totalActivities,
            'days_with_activities' => $daysWithActivities,
            'average_rating' => round($avgRating ?? 0, 1),
            'performance_score' => $performanceScore,
            'period_days' => $daysBack,
            'recent_activities' => $recentActivities,
        ]);
    }

    /**
     * Get unconfirmed activities summary (for notification - scan at 15:00)
     */
    public function unconfirmedSummary(Request $request)
    {
        $userId = Auth::id();
        $today = now()->toDateString();

        $unconfirmed = UserActivity::where('user_id', $userId)
            ->whereDate('activity_date', $today)
            ->whereNull('confirmed_at')
            ->count();

        // Show reminder popup only after 15:00 (3 PM)
        $hour = (int) now()->format('H');
        $minute = (int) now()->format('i');
        $showReminder = ($hour > 15) || ($hour === 15 && $minute >= 0);

        return response()->json([
            'unconfirmed_count' => $unconfirmed,
            'show_reminder' => $showReminder,
            'redirect_url' => $request->get('base_url', '') . 'user/profile/setting?tab=daily_activities',
        ]);
    }

    /**
     * Confirm one or more activities
     */
    public function confirm(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids) || !is_array($ids)) {
            return response()->json(['message' => 'No activity IDs provided'], 422);
        }

        $updated = UserActivity::where('user_id', Auth::id())
            ->whereIn('id', $ids)
            ->update(['confirmed_at' => now()]);

        return response()->json([
            'message' => "{$updated} activities confirmed",
            'confirmed_count' => $updated,
        ]);
    }
}
