<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Traits\RestControllerTrait;
use DB;

class UserController extends Controller
{
    use RestControllerTrait;

    const MODEL = 'App\User';

    /**
     * Validation Rules for the Usuario Database.
     *
     * @var array
     */
    protected $validationRules = [];

    /**
     * Validation Rules for User Database on a patch request.
     *
     * @var array
     */
    protected $validationPatchRules = [];

    /**
     * Manage index request
     * @param Request $request
     * @return type
     */
    public function index(Request $request)
    {
        $totalData = User::all()->count();
        $data = User::limit($request->input('limit'))
                    ->offset($request->input('offset'))
                    ->get();
        
        return $this->listResponse($data, $totalData);
    }

    /** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function login()
    { 
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            $user = Auth::user(); 
            $success['token'] = $user->createToken('MyApp')->accessToken;
            $success['user'] = Auth::user();

            return $this->listResponse($success);
        } else { 
            return $this->unauthorizedErrorResponse('Erro ao logar');
        }
    }
    
    /** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function register(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password'
        ]);
        
        if ($validator->fails()) {
            return $this->unauthorizedErrorResponse($validator->errors());         
        }
        
        $input = $request->all();
        $input['password'] = bcrypt($input['password']); 
        $user = User::create($input);
        $success['token'] = $user->createToken('MyApp')->accessToken; 
        $success['name'] = $user->name;
        $success['id'] = $user->id;
        return $this->listResponse($success);
    }

    /** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function update(Request $request, $id)
    {
        if (!$data = User::find($id)) {
            return $this->notFoundResponse();
        }
        $v = \Validator::make($request->all(), $this->validationPatchRules);
        try {
            if($v->fails()) {
                throw new \Exception("ValidationException");
            }
            $request['password'] = bcrypt($request['password']); 
            $data->fill($request->all());
            $data->save();
            return $this->showResponse($data);
        } catch(\Exception $ex) {
            $data = ['form_validations' => $v->errors(), 'exception' => $ex->getMessage()];
            return $this->clientErrorResponse($data);
        }
    }
}
