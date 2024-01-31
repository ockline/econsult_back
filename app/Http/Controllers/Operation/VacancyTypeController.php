<?php

namespace App\Http\Controllers\Operation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\OperationRepositories\VacancyTypeRepository;

class VacancyTypeController extends Controller
{
 protected $vacancy_type;

    public function __construct(VacancyTypeRepository $vacancy_type)
    {
        $this->vacancy_type = $vacancy_type;
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
public function getVacancies(){

       $vacancies =  $this->vacancy_type->getDatatable();

      return response()->json(["status" => 200, "vacancies" => $vacancies]);
}
}
