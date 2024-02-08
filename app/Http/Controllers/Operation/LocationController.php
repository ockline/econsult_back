<?php

namespace App\Http\Controllers\Operation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\OperationRepositories\LocationRepository;

class LocationController extends Controller
{
    protected $location;

    public function __construct(LocationRepository $location)
    {
        $this->location = $location;
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
   public function locationType(){
    $locations =  $this->location->getLocation();

 return response()->json(["status" => 200, "locations" => $locations]);
}
}
