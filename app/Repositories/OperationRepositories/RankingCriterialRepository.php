<?php

namespace App\Repositories\OperationRepositories;


use Exception;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\Sysdef\ranking;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\BaseREpository;
use App\Models\Sysdef\RankingCriterial;
use Illuminate\Support\Facades\Validator;


class RankingCriterialRepository extends  BaseRepository
{
    // use  FileHandler, AttachmentHandler, DefaultTrait;


    const MODEL = RankingCriterial::class;


    protected $ranking;


    public function __construct(RankingCriterial $ranking)
    {
        $this->ranking = $ranking;

    }

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id)
    {
        $rankings = $this->ranking->where("id", $id)->first();

        if (!is_null($rankings)) {
            return $rankings;
        }
       // throw new GeneralException(trans('exceptions.operation.data_not_found'));
    }

    public function getDatatable()
    {
        $rankings = $this->ranking->get();
        // $rankings = ranking::table('rankings')->select('*');
        // selectRaw(" * , CASE WHEN status = 0 THEN 'Iniactive' ELSE 'Active' END AS Status")->
        return $rankings;
    }


}
