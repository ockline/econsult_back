<?php

namespace App\Http\Controllers\Operation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Operation\Registration\EducationHistory;
use App\Repositories\OperationRepositories\WardRepository;

class EducationController extends Controller
{
//    protected $education;

//      public function __construct(EducationRepository $education)
//      {
//         $this->education = $education;
//      }

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
  public function getEducationLevel(){

   $educations =  EducationHistory::select('*')->get();
// $this->education->getDatatable();
 return response()->json(["status" => 200, "educations" => $educations]);
}
}
