<?php

namespace App\Repositories\OperationRepositories;

use Exception;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\Location\Country;
use App\Models\Location\PostCode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\BaseREpository;
use Illuminate\Support\Facades\Validator;


class CountryRepository extends  BaseRepository
{
    // use  FileHandler, AttachmentHandler, DefaultTrait;


    const MODEL = Country::class;


    protected $country;


    public function __construct(Country $country)
    {
        $this->country = $country;

    }

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id)
    {
        $countries = $this->country->where("id", $id)->first();

        if (!is_null($countries)) {
            return $countries;
        }
        // throw new GeneralException(trans('exceptions.operation.data_not_found'));
    }

 public function getDatatable()
{
//   $countries = collect();

  $countries =  DB::table('countries')->select('id','description as name')->get();

    return $countries;

}


}
