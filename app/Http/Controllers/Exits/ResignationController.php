<?php

namespace App\Http\Controllers\Exits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Repositories\Exits\ResignationRepository;

class ResignationController extends Controller
{
    protected $resignation;

    public function __construct(ResignationRepository $resignation)
    {
        $this->resignation = $resignation;
    }

    /**
     * Display a listing of resignations.
     */
    public function index()
    {
        return $this->resignation->getAllResignations();
    }

    /**
     * Store a newly created resignation.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required|exists:employees,id',
            'employee_name' => 'required|string|max:255',
            'department_name' => 'required|string|max:255',
            'job_title' => 'required|string|max:255',
            'postal_address' => 'required|string',
            'phone_number' => 'required|string|max:20',
            'remark' => 'required|string',
            'resignation_date' => 'required|date',
            'resignation_notice_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'resignation_form_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'resignation_letter_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        return $this->resignation->createResignation($request);
    }

    /**
     * Display the specified resignation.
     */
    public function show($id)
    {
        return $this->resignation->getResignationById($id);
    }

    /**
     * Update the specified resignation.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'employee_name' => 'required|string|max:255',
            'department_name' => 'required|string|max:255',
            'job_title' => 'required|string|max:255',
            'postal_address' => 'required|string',
            'phone_number' => 'required|string|max:20',
            'remark' => 'required|string',
            'resignation_date' => 'required|date',
            'resignation_notice_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'resignation_form_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'resignation_letter_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        return $this->resignation->updateResignation($request, $id);
    }

    /**
     * Submit resignation for review.
     */
    public function submit(Request $request, $id)
    {
        return $this->resignation->submitResignation($request, $id);
    }

    /**
     * Create resignation acceptance.
     */
    public function createAcceptance(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'acceptance_date' => 'required|date',
            'employee_name' => 'required|string|max:255',
            'job_title' => 'required|string|max:255',
            'postal_address' => 'required|string',
            'letter_dated' => 'required|date',
            'service_of' => 'required|string|max:255',
            'effective_from' => 'required|date',
            'started_work' => 'required|date',
            'hr_name' => 'required|string|max:255',
            'hr_designation' => 'required|string|max:255',
            'hr_signature_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'employee_signature_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        return $this->resignation->createAcceptance($request, $id);
    }

    /**
     * Remove the specified resignation.
     */
    public function destroy($id)
    {
        try {
            $resignation = \App\Models\Exits\Resignation::findOrFail($id);
            $resignation->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Resignation deleted successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Sorry! Operation failed'
            ], 500);
        }
    }
}
