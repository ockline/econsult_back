<?php

namespace App\Http\Controllers;

use App\Mail\NotificationEmail as NotificationEmailMailable;
use App\Models\NotificationEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    /**
     * Send notification email to one or multiple users
     * Accepts: recipient_ids (from user list), recipient_emails (manual), cc_emails, bcc_emails
     */
    public function send(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'recipient_ids' => 'nullable|array',
            'recipient_ids.*' => 'required|integer|exists:users,id',
            'recipient_emails' => 'nullable|array',
            'recipient_emails.*' => 'required|email',
            'cc_emails' => 'nullable|array',
            'cc_emails.*' => 'required|email',
            'bcc_emails' => 'nullable|array',
            'bcc_emails.*' => 'required|email',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $toEmails = [];
        $recipientsData = [];

        if (!empty($request->recipient_ids)) {
            $users = User::whereIn('id', $request->recipient_ids)
                ->whereNotNull('email')
                ->where('email', '!=', '')
                ->get();
            foreach ($users as $u) {
                $toEmails[] = $u->email;
                $recipientsData[] = ['email' => $u->email, 'recipient_id' => $u->id, 'name' => trim(($u->firstname ?? '') . ' ' . ($u->lastname ?? '')), 'user' => $u];
            }
        }

        $manualEmails = array_unique(array_map('strtolower', array_filter($request->recipient_emails ?? [])));
        foreach ($manualEmails as $em) {
            if (!in_array($em, $toEmails)) {
                $toEmails[] = $em;
                $recipientsData[] = ['email' => $em, 'recipient_id' => null, 'name' => '', 'user' => null];
            }
        }

        if (empty($toEmails)) {
            return response()->json([
                'message' => 'Please select at least one recipient or enter an email address.',
                'status' => 422,
            ], 422);
        }

        $ccEmails = array_unique(array_map('strtolower', array_filter($request->cc_emails ?? [])));
        $bccEmails = array_unique(array_map('strtolower', array_filter($request->bcc_emails ?? [])));

        $senderId = Auth::id();
        $failed = [];
        $sent = 0;

        try {
            $mail = Mail::to($toEmails);
            if (!empty($ccEmails)) {
                $mail->cc($ccEmails);
            }
            if (!empty($bccEmails)) {
                $mail->bcc($bccEmails);
            }
            $mail->send(new NotificationEmailMailable(
                $request->subject,
                $request->body,
                ''
            ));

            foreach ($recipientsData as $r) {
                NotificationEmail::create([
                    'sender_id' => $senderId,
                    'recipient_id' => $r['recipient_id'],
                    'recipient_email' => $r['email'],
                    'subject' => $request->subject,
                    'body' => $request->body,
                    'status' => 'delivered',
                    'sent_at' => now(),
                ]);
                $sent++;
            }
        } catch (\Exception $e) {
            foreach ($recipientsData as $r) {
                NotificationEmail::create([
                    'sender_id' => $senderId,
                    'recipient_id' => $r['recipient_id'],
                    'recipient_email' => $r['email'],
                    'subject' => $request->subject,
                    'body' => $request->body,
                    'status' => 'failed',
                    'error_message' => $e->getMessage(),
                ]);
                $failed[] = ['email' => $r['email'], 'error' => $e->getMessage()];
            }
            return response()->json([
                'message' => 'Failed to send email: ' . $e->getMessage(),
                'failed_count' => count($recipientsData),
                'failed' => $failed,
                'status' => 500,
            ], 500);
        }

        return response()->json([
            'message' => "Email sent to {$sent} recipient(s) successfully.",
            'sent_count' => $sent,
            'status' => 200,
        ], 200);
    }

    /**
     * List sent notification emails for current user
     */
    public function index(Request $request)
    {
        $emails = NotificationEmail::with(['recipient:id,firstname,lastname,email'])
            ->where('sender_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->limit(100)
            ->get()
            ->map(function ($e) {
                $rec = $e->recipient;
                $recipientName = $rec ? trim(($rec->firstname ?? '') . ' ' . ($rec->lastname ?? '')) : '—';
                return [
                    'id' => $e->id,
                    'recipient' => $recipientName ?: $e->recipient_email,
                    'recipient_email' => $e->recipient_email,
                    'subject' => $e->subject,
                    'status' => $e->status,
                    'sent_at' => $e->sent_at?->format('Y-m-d H:i'),
                ];
            });

        return response()->json(['emails' => $emails]);
    }

    /**
     * Get users list for recipient selection (auth required)
     */
    public function users(Request $request)
    {
        $users = User::select('id', 'firstname', 'middlename', 'lastname', 'email')
            ->whereNotNull('email')
            ->where('email', '!=', '')
            ->orderBy('firstname')
            ->get()
            ->map(function ($u) {
                return [
                    'id' => $u->id,
                    'value' => $u->id,
                    'label' => (trim(($u->firstname ?? '') . ' ' . ($u->middlename ?? '') . ' ' . ($u->lastname ?? '')) ?: 'User') . ' (' . ($u->email ?? '') . ')',
                    'email' => $u->email,
                ];
            });

        return response()->json(['users' => $users]);
    }
}
