<?php

namespace App\Http\Controllers\Operation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\OperationRepositories\JobTitleRepository;
use App\Repositories\OperationRepositories\VacancyTypeRepository;

class JobTitleController extends Controller
{
 protected $job_title;

    public function __construct(JobTitleRepository $job_title)
    {
        $this->job_title = $job_title;
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
public function getJobTitle(){

       $job_titles =  $this->job_title->getDatatable();

      return response()->json(["status" => 200, "job_titles" => $job_titles]);
}
}
