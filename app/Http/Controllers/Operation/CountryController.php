<?php

namespace App\Http\Controllers\Operation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\OperationRepositories\CountryRepository;

class CountryController extends Controller
{
   protected $country;

     public function __construct(CountryRepository $country)
     {
        $this->country = $country;
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
  public function getCountry(){

   $countries = $this->country->getDatatable();
 return response()->json(["status" => 200, "countries" => $countries]);
}
}
