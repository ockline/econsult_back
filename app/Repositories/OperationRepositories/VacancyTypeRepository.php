<?php

namespace App\Repositories\OperationRepositories;


use Exception;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\BaseREpository;
use Illuminate\Support\Facades\Validator;
use App\Models\Hiring\JobApplication\TypeVacancy;


class VacancyTypeRepository extends  BaseRepository
{
    // use  FileHandler, AttachmentHandler, DefaultTrait;


    const MODEL = TypeVacancy::class;


    protected $vacancy_type;


    public function __construct(TypeVacancy $vacancy_type)
    {
        $this->vacancy_type = $vacancy_type;

    }

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id)
    {
        $vacancy_types = $this->vacancy_type->where("id", $id)->first();

        if (!is_null($vacancy_types)) {
            return $vacancy_types;
        }
       // throw new GeneralException(trans('exceptions.operation.data_not_found'));
    }

    public function getDatatable()
    {
        $vacancy_type = $this->vacancy_type->get();
        // $vacancy_type = allowance::table('vacancy_type')->select('*');
        // selectRaw(" * , CASE WHEN status = 0 THEN 'Iniactive' ELSE 'Active' END AS Status")->
        return $vacancy_type;
    }


}
