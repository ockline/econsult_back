<?php

namespace App\Repositories\OperationRepositories;

use App\Models\Location\PostCode;
use Exception;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Validator;


class WardRepository extends  BaseRepository
{
    // use  FileHandler, AttachmentHandler, DefaultTrait;


    const MODEL = PostCode::class;


    protected $ward;


    public function __construct(PostCode $ward)
    {
        $this->ward = $ward;

    }

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id)
    {
        $wards = $this->ward->where("id", $id)->first();

        if (!is_null($wards)) {
            return $wards;
        }
        // throw new GeneralException(trans('exceptions.operation.data_not_found'));
    }

 public function getDatatable()
{
//   $wards = collect();

  $wards =  DB::table('postcodes')->select('id','ward_name', 'district_id')->get();

    return $wards;

}


}
