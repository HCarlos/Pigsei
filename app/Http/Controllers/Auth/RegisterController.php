<?php

namespace App\Http\Controllers\Auth;

use App\Class\FuncionesGeneralesClass;
use App\Http\Controllers\Controller;
use App\Models\User\Role;
use App\Models\User\User;
use App\Rules\IsCURPRule;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/registered';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'curp'       => ['required', 'string', 'unique:users', new IsCURPRule() ],
            'email'      => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'ap_paterno' => ['required', 'string'],
            'ap_materno' => ['required', 'string'],
            'nombre'     => ['required', 'string'],
            'username'   => ['required', 'string'],
            'password'   => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User\User
     */
    protected function create(array $data)
    {
//        return User::create([
//            'name' => $data['name'],
//            'email' => $data['email'],
//            'password' => Hash::make($data['password']),
//        ]);

        app()['cache']->forget('spatie.permission.cache');
        $F = new FuncionesGeneralesClass();
        $ip   = 'root_init';//$_SERVER['REMOTE_ADDR'];
        $host = 'root_init';//gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $idemp = config('atemun.empresa_id');

        $curp = strtoupper(trim( $data["curp"] ));

        $UN =  User::getUsernameNext('CIUINT');
        $Username = $curp; // $UN['username'];
        $Email =  $data["email"] == "" ? strtolower($Username) . '@example.com' : $data["email"];
        $user =  User::create([
            'username'     => $Username,
            'email'        => $Email ,
            'password'     => Hash::make($Username),
            'curp'         => $curp,
            'ap_paterno'   => strtoupper(trim( $data["ap_paterno"] )),
            'ap_materno'   => strtoupper(trim( $data["ap_materno"] )),
            'nombre'       => strtoupper(trim( $data["nombre"] )),
            'ubicacion_id' => 1,
        ]);
//        $role_invitado = Role::findByName('Invitado');
//        $user->roles()->attach($role_invitado);
        $role_ciudadano = Role::findByName('CIUDADANO');
        $user->roles()->attach($role_ciudadano);
        $role_ciudadano_internet = Role::findByName('CIUDADANO_INTERNET');
        $user->roles()->attach($role_ciudadano_internet);
        $user->ubicaciones()->attach(1);
        $user->admin = false;
        $user->empresa_id = $idemp;
        $user->ip = $ip;
        $user->host = $host;
        $user->email_verified_at = now();
        $user->save();
        $user->permissions()->attach(7);
        $user->user_adress()->create();
        $user->user_data_extend()->create();
        $F->validImage($user,'profile','profile/');

        return $user;

    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        //$this->guard()->login($user);

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 201)
            : $this->registrado($user);

    }

    protected function registrado($user)
    {
        return view ('auth.passwords.new_user',
            [
                'email'    => $user->email,
                'curp'     => $user->curp,
                'username' => $user->username,
            ]
        );

    }




}
