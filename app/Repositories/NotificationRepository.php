<?php

namespace App\Repositories;


use Exception;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\Sysdef\Role;
use App\Models\Location\Region;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\BaseREpository;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;


class NotificationRepository extends  BaseRepository
{
    // use  FileHandler, AttachmentHandler, DefaultTrait;


    // const MODEL = Role::class;


    // protected $roles;


    // public function __construct(Role $roles)
    // {
    //     $this->roles = $roles;
    // }


public function getUserRoles()
{
      $users = DB::table('role_user as ru')
    ->select(
        'ru.user_id',
        DB::raw("CONCAT(u.firstname, ' ', u.lastname) as user_name"),
        'u.active as status',
        DB::raw("STRING_AGG(r.name, ', ') as role_names")
    )
    ->leftJoin('users as u', 'ru.user_id', '=', 'u.id')
    ->leftJoin('roles as r', 'ru.role_id', '=', 'r.id')
    ->groupBy('ru.user_id', 'u.firstname', 'u.lastname', 'u.active')
->whereNull('ru.deleted_at')
    ->get();


return $users;
}
/**
*@method to send sms notification
 */
public function  smsNotification()
{
    $token = 'bXdhbnplbHU6bXdha2lob25nbzEyMzQ1';
    $response = Http::withoutVerifying()
                    ->withHeaders([
                        "Accept" => "application/json",
                        "Content-Type" => "application/json",
                        'Authorization' => 'Basic ' . $token,
                    ])->post("https://messaging-service.co.tz/api/sms/v1/text/single", [
'from' => 'JUMUIKO',
'to' => ['255762700692', '255738013481'],
'text' => 'Greetings! Your have successfully ',
]);
logger($response->body());
}

/**
*@method to send general sms notification
 */
public function  smsGeneralNotification()
{
    $token = 'bXdhbnplbHU6bXdha2lob25nbzEyMzQ1';
    $response = Http::withoutVerifying()
                    ->withHeaders([
                        "Accept" => "application/json",
                        "Content-Type" => "application/json",
                        'Authorization' => 'Basic ' . $token,
                    ])->post("https://messaging-service.co.tz/api/sms/v1/text/single", [
'from' => 'JUMUIKO',
'to' => ['255762700692','255738013481'],
'text' => 'Greetings! Your have successfully ',
]);
logger($response->body());
}


}
