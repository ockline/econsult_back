<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\OperationRepositories\BankBranchRepository;

class BankBranchController extends Controller
{
 protected $branches;

    public function __construct(BankBranchRepository $branches)
    {
        $this->branches = $branches;
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
  public function bankBranch(){

    $branches = $this->branches->getDatatable();

    return response()->json(["status" => 200, "branches" => $branches]);
}
}
