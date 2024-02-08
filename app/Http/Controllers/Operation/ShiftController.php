<?php

namespace App\Http\Controllers\Operation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\OperationRepositories\ShiftRepository;

class ShiftController extends Controller
{

 protected $shift;

    public function __construct(ShiftRepository $shift)
    {
        $this->shift = $shift;
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
    public function getShift(){
      $shifts =  $this->shift->getdatatable();

     return response()->json(["status" => 200, "shifts" => $shifts]);
    }
}
