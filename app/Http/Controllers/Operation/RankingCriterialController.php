<?php

namespace App\Http\Controllers\Operation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\OperationRepositories\RankingCriterialRepository;

class RankingCriterialController extends Controller
{
 protected $ranking;

    public function __construct(RankingCriterialRepository $ranking)
    {
        $this->ranking = $ranking;
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
public function getRanking(){

       $rankings =  $this->ranking->getDatatable();

      return response()->json(["status" => 200, "rankings" => $rankings]);
}
}
