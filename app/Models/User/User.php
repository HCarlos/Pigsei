<?php

namespace App\Models\User;

use App\Traits\Imagene;
use App\Traits\UserAttributes;
use App\Traits\UserImport;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use App\Models\User\UserAdress;
use App\Models\User\UserDataExtend;

class User extends Authenticatable implements MustVerifyEmail{

    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    use UserImport, UserAttributes;

    protected $guard_name = 'web';
    protected $table = 'users';

    protected $fillable = [
        'id',
        'username', 'email', 'password',
        'nombre','ap_paterno','ap_materno',
        'admin','alumno','delegado',
        'curp','emails','celulares','telefonos',
        'fecha_nacimiento','genero', 'lugar_nacimiento',
        'root','filename','filename_png','filename_thumb',
        'empresa_id','status_user','ip','host','searchtext',
        'logged','logged_at','logout_at', 'user_mig_id','email_verified_at',
        'creadopor_id','created_at','modipor_id','updated_at',
        'ubicacion_id','imagen_id','session_id',
        'uuid',
    ];

    protected $hidden = ['password', 'remember_token','deleted_at'];
    protected $casts = ['admin'=>'boolean','alumno'=>'boolean','delegado'=>'boolean','email_verified_at' => 'datetime',];
    protected $dates = ['fecha_nacimiento' => 'datetime:d-m-Y'];
//    protected $dateFormat = [''];
    public function scopeSearch($query, $search){
        if (!$search || $search == "" || $search == null) return $query;
        return $query->whereRaw("searchtext @@ to_tsquery('spanish', ?)", [$search])
            ->orderByRaw("ts_rank(searchtext, to_tsquery('spanish', ?)) DESC", [$search]);
    }

//->orderByRaw("ap_paterno, ap_materno, nombre, curp, username ASC");



    //->orHas('user_adress', function ($q) use ($search) {     return $q->whereRaw("UPPER(calle) like ?", "%{$search}%")
//->orWhereRaw("UPPER(colonia) like ?", "%{$search}%")
//    ->orWhereRaw("UPPER(localidad) like ?", "%{$search}%");
//})


    public function scopeFilterBy($query, $filters){
        return null; //(new UserFilter())->applyTo($query, $filters);
    }

    public function permisos() {
        return $this->belongsToMany(Permission::class);
    }

    public function permissions(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }

    public function roles(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

//    public function dependencias(){
//        return $this->belongsToMany(Dependencia::class);
//    }
//
    public function Imagen(){
        return $this->hasOne(Imagene::class,'id','imagene_id');
    }

    public function imagenes(){
        return $this->belongsToMany(Imagene::class,'imagene_user','imagene_id','user_id');
    }

//    public function Denuncia(){
//        return $this->hasOne(Denuncia::class,'id','denuncia_id');
//    }
//
//    public function denuncias(){
//        return $this->belongsToMany(Denuncia::class,'denuncia_user','denuncia_id','user_id');
//    }

    public function user_adress(){
        return $this->hasOne(UserAdress::class);
    }

    public function user_data_extend(){
        return $this->hasOne(UserDataExtend::class);
    }

//    public function respuestas(){
//        return $this->belongsToMany(Respuesta::class);
//    }
//
//    public function Ubicacion(){
//        return $this->belongsTo(Ubicacion::class,'ubicacion_id','id');
//    }
//
//    public function ubicaciones(){
//        return $this->belongsToMany(Ubicacion::class);
//    }

    public function isAdmin(){
        return $this->admin;
    }

    public function isDelegado(){
        return $this->delegado;
    }

    public function isRole($role): bool{
        return $this->hasRole($role);
    }

    public function IsEmptyPhoto(){
        return $this->filename == '';
    }

    public function IsFemale(){
        return $this->genero == 0;
    }

    public function scopeMyID(){
        return $this->id;
    }

    public function scopeRole(){
        return $this->roles()->first();
    }

//    public function MobileDevices(){
//        return $this->hasMany(UserMobile::class,'user_id','id');
//    }
//
//    public function MobileDeviceMessages(){
//        return $this->hasMany(UserMobileMessage::class,'user_id','id');
//    }
//
//    public function MobileDeviceMessageRequests(){
//        return $this->hasMany(UserMobileMessageRequest::class,'user_id','id');
//    }

//    public function sendPasswordResetNotification($token){
//        $this->notify(new MyResetPassword($token));
//    }
//
//    public function sendEmailVerificationNotification(){
//        $this->notify(new SendEmailAPIVerificationNotification());
//    }





}
