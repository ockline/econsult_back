<?php

namespace App\Http\Controllers\Operation;

use Illuminate\Http\Request;
use App\Models\Sysdef\Region;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\RegionRepository;
use Illuminate\Support\Facades\Validator;

class RegionController extends Controller
{
    protected $region;

    public function __construct(RegionRepository $region)
    {
        $this->region = $region;
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

    public function  region()
    {
        // Log::info('anafikaaa mkali');
        $regions =    $this->region->getRegions();
        // Log::info($regions);
        if ($regions) {
            // Log::info('111');
            return response()->json([
                'status' => 200,
                'regions' => $regions,
            ]);
        } else {
            // log::info('222');
            return response()->json([
                'status' => 500,
                'message' => "Internal server Error"
            ]);
        }
    }
    public function getRegion()
    {
        $get_region =  $this->region->userRegion();
        // Log::info($get_region);
        // Log::info($get_region);

        if ($get_region) {
            return response()->json([
                'status' => 200,
                'user_region' => $get_region,
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Internal server Error',
            ]);
        }
    }
}
