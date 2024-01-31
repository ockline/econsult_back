<?php

namespace App\Repositories\OperationRepositories;


use Exception;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\Sysdef\JobTitle;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\BaseREpository;
use Illuminate\Support\Facades\Validator;



class JobTitleRepository extends  BaseRepository
{
    // use  FileHandler, AttachmentHandler, DefaultTrait;


    const MODEL = JobTitle::class;


    protected $job_title;


    public function __construct(JobTitle $job_title)
    {
        $this->job_title = $job_title;

    }

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id)
    {
        $job_titles = $this->job_title->where("id", $id)->first();

        if (!is_null($job_titles)) {
            return $job_titles;
        }
       // throw new GeneralException(trans('exceptions.operation.data_not_found'));
    }

    public function getDatatable()
    {
        $job_title = $this->job_title->get();
        // $job_title = allowance::table('job_title')->select('*');
        // selectRaw(" * , CASE WHEN status = 0 THEN 'Iniactive' ELSE 'Active' END AS Status")->
        return $job_title;
    }


}
