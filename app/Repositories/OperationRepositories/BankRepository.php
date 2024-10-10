<?php

namespace App\Repositories\OperationRepositories;


use Exception;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\Bank\Bank;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Validator;


class BankRepository extends  BaseRepository
{
    // use  FileHandler, AttachmentHandler, DefaultTrait;


    const MODEL = Bank::class;


    protected $bank;


    public function __construct(Bank $bank)
    {
        $this->bank = $bank;

    }

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id)
    {
        $banks = $this->bank->where("id", $id)->first();

        if (!is_null($banks)) {
            return $banks;
        }
      // throw new GeneralException(trans('exceptions.operation.data_not_found'));
    }

    public function getDatatable()
    {
        $banks = $this->bank->get();
        // $banks = bank::table('banks')->select('*');
        // selectRaw(" * , CASE WHEN status = 0 THEN 'Iniactive' ELSE 'Active' END AS Status")->
        return $banks;
    }


}
