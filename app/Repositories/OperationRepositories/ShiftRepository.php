<?php

namespace App\Repositories\OperationRepositories;


use Exception;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\Sysdef\Shift;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Validator;


class ShiftRepository extends  BaseRepository
{
    // use  FileHandler, AttachmentHandler, DefaultTrait;


    const MODEL = Shift::class;


    protected $shift;
    protected $region;

    public function __construct(Shift $shift)
    {
        $this->shift = $shift;

    }

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id)
    {
        $shifts = $this->shift->where("id", $id)->first();

        if (!is_null($shifts)) {
            return $shifts;
        }
        // throw new GeneralException(trans('exceptions.operation.data_not_found'));
    }

    public function getDatatable()
    {
        $shifts = $this->shift->get();
        // $shifts = shift::table('shifts')->select('*');
        // selectRaw(" * , CASE WHEN status = 0 THEN 'Iniactive' ELSE 'Active' END AS Status")->
        return $shifts;
    }


}
