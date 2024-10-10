<?php

namespace App\Repositories\OperationRepositories;


use Exception;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\Bank\BankBranch;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Validator;
use App\Repositories\OperationRepositories\BankRepository;


class BankBranchRepository extends  BaseRepository
{
    // use  FileHandler, AttachmentHandler, DefaultTrait;


    const MODEL = BankBranch::class;


    protected $branches;
    protected $bank;

    public function __construct(BankBranch $branches, BankRepository $bank )
    {
        $this->branches = $branches;
        $this->bank = $bank;
    }

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id)
    {
        $branches = $this->branches->where("id", $id)->first();

        if (!is_null($branches)) {
            return $branches;
        }
        // throw new GeneralException(trans('exceptions.operation.data_not_found'));
    }

    public function getDatatable()
    {
        $branches = $this->branches->get();
        // $branches = branches::table('branches')->select('*');
        // selectRaw(" * , CASE WHEN status = 0 THEN 'Iniactive' ELSE 'Active' END AS Status")->
        return $branches;
    }


}
