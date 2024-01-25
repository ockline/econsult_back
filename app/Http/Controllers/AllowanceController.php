<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\OperationRepositories\AllowanceRepository;

class AllowanceController extends Controller
{
 protected $allowance;

    public function __construct(AllowanceRepository $allowance)
    {
        $this->allowance = $allowance;
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
public function getAllowance(){

       $allowances =  $this->allowance->getDatatable();

      return response()->json(["status" => 200, "allowances" => $allowances]);
}
}
