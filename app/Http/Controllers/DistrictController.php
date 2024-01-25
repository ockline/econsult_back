<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sysdef\District;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Repositories\DistrictRepository;

class DistrictController extends Controller
{
    protected $district;

    public function __construct(DistrictRepository $district)
    {
        $this->district = $district;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {



    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // $unit = $this->unit($id);

    }
    /**
     * Remove the specified resource from storage.
     */

    public function  district()
    {
        // Log::info('anafikaaa mkali');
        $districts =    $this->district->getDistricts();
        // Log::info($districts);
        if ($districts) {
            // Log::info('111');
            return response()->json([
                'status' => 200,
                'districts' => $districts,
            ]);
        } else {
            // log::info('222');
            return response()->json([
                'status' => 500,
                'message' => "Internal server Error"
            ]);
        }
    }
    public function getDistrict()
    {
        $get_district =  $this->district->userDistrict();
        // Log::info($get_district);
        if ($get_district) {
            return response()->json([
                'status' => 200,
                'user_district' => $get_district,
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Internal server Error',
            ]);
        }
    }
}
