<?php

namespace App\Repositories\OperationRepositories;


use Exception;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\Sysdef\Package;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Validator;


class PackageRepository extends  BaseRepository
{
    // use  FileHandler, AttachmentHandler, DefaultTrait;


    const MODEL = Package::class;


    protected $package;


    public function __construct(Package $package)
    {
        $this->package = $package;

    }

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id)
    {
        $packages = $this->package->where("id", $id)->first();

        if (!is_null($packages)) {
            return $packages;
        }
       // throw new GeneralException(trans('exceptions.operation.data_not_found'));
    }

    public function getDatatable()
    {
        $packages = $this->package->get();
        // $packages = package::table('packages')->select('*');
        // selectRaw(" * , CASE WHEN status = 0 THEN 'Iniactive' ELSE 'Active' END AS Status")->
        return $packages;
    }


}
