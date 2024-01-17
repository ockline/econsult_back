<?php

namespace App\Repositories;


use Exception;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\Location\Region;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\BaseREpository;
use App\Repositories\DistrictRepository;
use Illuminate\Support\Facades\Validator;


class RegionRepository extends  BaseRepository
{
    // use  FileHandler, AttachmentHandler, DefaultTrait;


    const MODEL = Region::class;


    protected $region;


    public function __construct(Region $region)
    {
        $this->region = $region;
    }

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id)
    {
        $regions = $this->region->where("id", $id)->first();

        if (!is_null($regions)) {
            return $regions;
        }
        // throw new GeneralException(trans('exceptions.backend.claim.notification_report_not_found'));
    }

    public function getRegions()
    {
        $regions = DB::table('regions')->select('id','name','country_id','created_at','updated_at','office_zone_id')->get();
// Log::info($regions);
        return $regions;
    }





    public function userRegion()
    {
        $details =  DB::table('users as u')
            ->select('u.name as user', 'u.designation_id', 'u.phone', 'u.fax_number', 'u.email', 'd.name as region_name')
            ->join('regions as d', 'u.region_id', '=', 'd.id')
            ->orderBy('d.id', 'ASC')->get();
        return  $details;
    }
}
