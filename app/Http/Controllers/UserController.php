<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    protected $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        validator(request()->all(), [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ])->validate();

        if (auth()->attempt(request()->only(['email', 'password']))) {
            return response()->json([
                'status' => 200,
                'message' => 'Successfully login',
            ]);
        }

        return response()->json([
            'status' => 500,
            'message' => "Invalid Email",
        ]);
    }
    public function login()
    {
        log::info(request()->all());

        validator(request()->all(), [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ])->validate();


        if (auth()->attempt(request()->only(['email', 'password']))) {
            return response()->json([
                'status' => 200,
                'message' => 'Successfully login',
            ]);
        }

        return response()->json([
            'status' => 500,
            'message' => "Invalid Email",
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //  Log::info('hellow ndani');
        //    log::info($request->all());
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:191',
            'middlename' => 'required|max:191',
            'lastname' => 'required|max:191',
            'phone' => 'required|max:14|min:10',
            'dob' => 'required|max:191',
            'email' => 'email|max:191',
            'password' => 'required|max:50|min:8',
            'department_id' => 'required|max:191',
            'employer_id' => 'required|max:191',
            'designation_id' => 'required|max:191',
            'confirm_password' => 'required|max:50|min:8',

        ]);

        if ($validator->fails()) {
            $messages = [
                    'firstname' => 'The Firstname is required.',
                    'middlename' => 'The Middle name is required',
                    'lastname' => 'The last name is required',
                    'dob' => 'The Date of birth is required ',
                    'phone' => 'The Phone number is required',
                    'email' => 'The Email address is required and should be unique',
                    'password' => 'The password must not less than 8
this should include Capital letter, small, character and number ',
                    'confirm_password' => 'The Confirm password must be the same, not less than 8
     this should include Capital letter, small, character and number ',
                    'department_id' => 'The department name is required ',
                    'employer_id' => 'The employer name is required ',
                    'designation_id' => 'The Designation is required',
            ];
            $return =  [
                'validator_err' =>  $messages,
               ];
        } else {

         $data =   $this->user->addUsers($request);
         $status = $data->getStatusCode();
 // Get HTTP status code
        $responseContent = $data->getContent(); // Get response content as a string

        // If you need to work with the response content as JSON
          $return = json_decode($responseContent, true);

            }

        return response()->json($return);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $user = User::find($id);

        if ($user) {
            return response()->json([
                'status' => 200,
                'user' => $user,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "No data found",
            ]);
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);

        // if($user){
        //     $user = $this->user->updateUser($request, $id);

        //     return response()->json([

        //     ]);
        //  }

        if ($user) {
            $user->name = $request->input('firstname') . " " . $request->input('lastname');
            $user->firstname = $request->input('firstname');
            $user->middlename = $request->input('middlename');
            $user->lastname = $request->input('lastname');
            $user->phone = $request->input('phone');
            $user->dob = $request->input('dob');
            //    $user->password = $request->input('password');
            $user->email = $request->input('email');
            //    $user->repeat_password = $request->input('repeat_password');
            $user->designation = $request->input('designation');
            $user->department_id = $request->input('department_id');
            $user->fax_number = $request->input('fax_number');
            //    $user->photo  = $request->input('photo');
            $user->update();

            return response()->json([
                'status' => '200',
                "message" => "Update Successfully",
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Internal server error',

            ]);
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if ($user) {
            return response()->json([
                "status" => 200,
                "user" => $user->delete(),
            ]);
        } else {
            return response()->json([
                "status" => 404,
                "user" => "Action Failed",
            ]);
        }
    }
    public function admin()
    {
        // Log::info('tumefika');
        return 123;
    }
    public function getUsers()
    {

        $users = $this->user;
        if ($users) {
            //log::info('unyama');
            $users = $this->user->getAllUser();
            // log::info($users);
            return response()->json([
                'status' => 200,
                'users' => $users,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "No data found",

            ]);
        }
    }
}
