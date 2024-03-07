<?php

namespace App\Repositories\OperationRepositories;

use Exception;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\Location\PostCode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Sysdef\DependentType;
use App\Repositories\BaseREpository;
use Illuminate\Support\Facades\Validator;


class DependantTypeRepository  extends  BaseRepository
{
    // use  FileHandler, AttachmentHandler, DefaultTrait;


    const MODEL = DependentType::class;


    protected $relation;


    public function __construct(DependentType $relation)
    {
        $this->relation = $relation;

    }

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */


 public function getDatatable()
{
//   $wards = collect();

return  DB::table('dependent_types')->select('id','name')->get();


}


}
