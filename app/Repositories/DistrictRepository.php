<?php

namespace App\Repositories;


use Exception;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\Location\District;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\BaseRepository;
use App\Repositories\RegionRepository;
use Illuminate\Support\Facades\Validator;


class DistrictRepository extends  BaseRepository
{
    // use  FileHandler, AttachmentHandler, DefaultTrait;


    const MODEL = District::class;


    protected $district;
    protected $region;

    public function __construct(District $district, RegionRepository $region)
    {
        $this->district = $district;
        $this->region = $region;
    }

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id)
    {
        $districts = $this->district->where("id", $id)->first();

        if (!is_null($districts)) {
            return $districts;
        }
        // throw new GeneralException(trans('exceptions.backend.claim.notification_report_not_found'));
    }

    public function getDistricts()
    {

        // $districts = $this->district->get();
        $districts = DB::table('districts')->select('*')->get();
        // selectRaw(" * , CASE WHEN status = 0 THEN 'Iniactive' ELSE 'Active' END AS Status")->
    //    Log::info($districts);
        return $districts;
    }

    public function userDistrict()
    {
        $details =  DB::table('users as u')
            ->select('u.name as user', 'u.designation_id', 'u.phone', 'u.fax_number', 'u.email', 'd.name as district_name')
            ->join('districts as d', 'u.district_id', '=', 'd.id')
            ->orderBy('d.id', 'ASC')->get();
        return  $details;
    }
}
