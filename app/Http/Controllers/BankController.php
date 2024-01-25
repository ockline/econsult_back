<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\OperationRepositories\BankRepository;

class BankController extends Controller
{
      protected $bank;

    public function __construct(BankRepository $bank)
    {
        $this->bank = $bank;
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
 public function getBank(){

    $banks =   $this->bank->getDatatable();

   return response()->json(["status" => 200, "banks" => $banks]);
}
}
