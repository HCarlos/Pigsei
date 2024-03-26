<?php

namespace App\Traits;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Imagene extends Model{
    use SoftDeletes;
    use ImageneTrait;

    protected $guard_name = 'web';
    protected $table = 'imagenes';
    protected $disk = "denuncia";

    protected $fillable = [
        'id', 'fecha','root','image','image_thumb','titulo','descripcion','momento','denuncia__id','user__id','parent__id'
    ];
    protected $hidden = ['deleted_at','created_at','updated_at'];

    public function user(){
        return $this->hasOne(User::class,'id','user__id');
    }

    public function users(){
        return $this->belongsToMany(User::class,'imagene_user','imagene_id','user_id');
    }

//    public function denuncia(){
//        return $this->hasOne(Denuncia::class,'id','denuncia__id');
//    }
//
//    public function denuncias(){
//        return $this->belongsToMany(Denuncia::class,'denuncia_imagene','imagene_id','denuncia_id');
//    }

    public function child(){
        return $this->hasOne(Imagene::class,'id','parent__id');
    }

    public function childs(){
        return $this->belongsToMany(Imagene::class,'imagene_parent','imagene_id','imagen_parent_id');
    }



}
