<?php

namespace App\Http\Controllers\Operation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\OperationRepositories\DependantTypeRepository;
use App\Repositories\OperationRepositories\WardRepository;

class DependantTypeController extends Controller
{
   protected $relation;

     public function __construct(DependantTypeRepository $relation)
     {
        $this->relation = $relation;
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
  public function getRelationship(){

   $relationships = $this->relation->getDatatable();
 return response()->json(["status" => 200, "relationships" => $relationships]);
}
}
