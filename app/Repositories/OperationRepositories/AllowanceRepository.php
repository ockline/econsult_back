<?php

namespace App\Repositories\OperationRepositories;


use Exception;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\Sysdef\Allowance;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Validator;


class AllowanceRepository extends  BaseRepository
{
    // use  FileHandler, AttachmentHandler, DefaultTrait;


    const MODEL = Allowance::class;


    protected $allowance;


    public function __construct(Allowance $allowance)
    {
        $this->allowance = $allowance;

    }

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id)
    {
        $allowances = $this->allowance->where("id", $id)->first();

        if (!is_null($allowances)) {
            return $allowances;
        }
       // throw new GeneralException(trans('exceptions.operation.data_not_found'));
    }

    public function getDatatable()
    {
        $allowances = $this->allowance->get();
        // $allowances = allowance::table('allowances')->select('*');
        // selectRaw(" * , CASE WHEN status = 0 THEN 'Iniactive' ELSE 'Active' END AS Status")->
        return $allowances;
    }


}
