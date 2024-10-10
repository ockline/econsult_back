<?php

namespace App\Repositories\OperationRepositories;

use App\Models\Location\LocationType;
use Exception;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Validator;


class LocationRepository extends  BaseRepository
{
    // use  FileHandler, AttachmentHandler, DefaultTrait;


    const MODEL = LocationType::class;


    protected $location;
    protected $region;

    public function __construct(LocationType $location)
    {
        $this->location = $location;

    }

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id)
    {
        $locations = $this->location->where("id", $id)->first();

        if (!is_null($locations)) {
            return $locations;
        }
    // throw new GeneralException(trans('exceptions.operation.data_not_found'));
    }

    public function getLocation()
    {
        $locations = $this->location->get();
        // $locations = location::table('locations')->select('*');
        // selectRaw(" * , CASE WHEN status = 0 THEN 'Iniactive' ELSE 'Active' END AS Status")->
        return $locations;
    }


}
