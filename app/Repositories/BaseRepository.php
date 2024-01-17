<?php

namespace App\Repositories;

use App\Exceptions\GeneralException;
use App\Services\Finance\FinYear;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

/**
 * Class BaseRepository.
 */
class BaseRepository
{

    public $start_summary_period;

    public $end_summary_period;

    public function __construct()
    {
        //$this->start_summary_period = $this->getStartSummaryPeriod();
        //$this->end_summary_period = $this->getEndSummaryPeriod();
    }

    public function regexFormatColumn(array $input)
    {
        $keyword = [];
        $sql = "";
        if (count($input)) {
            switch (DB::getDriverName()) {
                case 'pgsql':
                    foreach ($input as $key => $value) {
                        $sql .= " cast({$key} as text) ~* ? or";
                        $keyword[] = $value;
                    }
                    break;
                default:
                    foreach ($input as $key => $value) {
                        $value = strtolower($value);
                        $sql .= " LOWER({$key}) REGEXP  ? or";
                        $keyword[] = $value;
                    }
            }
            $sql = substr($sql, 0, -2);
            $sql = "( {$sql} )";
        }
        return ['sql' => $sql, 'keyword' => $keyword];
    }

    public function dbValidator($query, $input)
    {
        $count = 0;
        $statement = "";
        foreach ($input as $key => $value) {
            switch (DB::getDriverName()) {
                case 'pgsql':
                    $statement = "{$key} ~* '^?$'";
                    break;
                default:
                    $statement = "{$key} = '?'";
            }
            $count = $query->whereRaw($statement, [$value])->count();

            if ($count) {
                if (request()->ajax()) {
                    //return new JsonResponse([$key => trans("exceptions.general.exists")], 422);
                    //return response(422)->json([$key => trans("exceptions.general.exists")]);
                }
                return redirect()->back()
                    ->withInput([$key => $value])
                    ->withErrors([$key => trans("exceptions.general.exists")]);
            }
        }
        return true;
    }

    public function targetVariancePercentage($actual, $target)
    {
        $target = ($target) ? $target : 0;
        $actual = ($actual) ? $actual : 0;
        $diff = $target - $actual;
        $variance = $target > 0 ?  ($diff / $target) : 0;
        $variance_percentage = $variance * 100;
        return $variance_percentage;
    }

    public function getPercent($actual, $total)
    {
        $total = ($total) ? $total : 0;
        $actual = ($actual) ? $actual : 0;
        $percent = ($actual / $total) * 100;
        return $percent;
    }

    /**
     * Check if phone number is unique
     * @param $phone_formatted
     * @param $phone_column_name
     * @param $action_type i.e. 1 = when create , 2 when edit
     * @param null $object_id => primary key of the model
     * @throws GeneralException
     */
    // public function checkIfPhoneIsUnique($phone_formatted,$phone_column_name, $action_type,$object_id = null)
    // {
    //     $return = 0;
    //     if ($action_type == 1){
    //         /*on insert*/
    //         $return = $this->query()->where($phone_column_name, $phone_formatted)->count();
    //     }else{
    //         /*on edit*/
    //         $return = $this->query()->where('id','<>', $object_id)->where($phone_column_name, $phone_formatted)->count();
    //     }
    //     /*Check outcome */
    //     if ($return == 0)
    //     {
    //         //is unique
    //     }else{
    //         /*Phone is taken: throw exception*/
    //         // throw new GeneralException('Phone number already exists! Please check');
    //     }
    // }


    /*General query to update using DB builder*/
    public function generalDbBuilderUpdateQuery($table_name, array $where_input, array $update_input){

        DB::table($table_name)->where($where_input)->update($update_input);
    }



    /*Create using mass assign by filtering keys which are in table*/
    public function createMassAssign($table, array $input)
    {

        $input_common = $this->getCommonInputForMassAssign($table, $input);

        // return $this->query()->create($input_common);
    }

//    Create mass assign using DB builder
    public function createMassAssignDbBuilder($table, array $input)
    {

        $input_common = $this->getCommonInputForMassAssign($table, $input);

        return   DB::table($table)->insertGetId($input_common);
    }

    // /*update mass assign by filtering keys exists ib the table*/
    // public function updateMassAssign($table,$resource_id, array $input)
    // {
    //     $resource = $this->find($resource_id);
    //     $input_common = $this->getCommonInputForMassAssign($table, $input);
    //     return   $resource->update($input_common);
    // }

    /*update mass assign by filtering keys exists ib the table by where input*/
    public function updateMassAssignByWhere($table,array $where_input, array $input)
    {
        $input_common = $this->getCommonInputForMassAssign($table, $input);
        return  DB::table($table)->where($where_input)->update($input_common);
    }


    /*Get Input with all keys exists in the table columns*/
    public function getCommonInputForMassAssign($table, array $input)
    {
        $columns = DB::getSchemaBuilder()->getColumnListing($table);

        $input_keys = array_keys($input);

        $keys_common = (array_intersect($columns, $input_keys));

        /*STart get values*/
        $values = [];
        foreach($keys_common as $key)
        {
            array_push($values, $input[$key]);
        }
        $array_combine = array_combine($keys_common, $values);
        return $array_combine;
    }
}
