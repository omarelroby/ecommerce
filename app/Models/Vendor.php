<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;
    protected $table='vendors';
    protected $fillable =
        [
            'name',
            'mobile',
            'address',
            'email',
            'active',
            'category_id',
            'logo'
        ];
    protected $hidden=['category_id'];
    public function scobeActive($query){
        return $query->where('active',1);
    }
    public function getLogoAttribute($val){
        return (!$val==null)?asset('assets/'.$val):"";
    }
    public function scobeSelection($query){
        return $query->select('id','category_id','address','active','name','logo','mobile');
    }
    public function getActive()
    {
        return $this->active == 1 ? 'مفعل' : 'غير مفعل';
    }
    public function category(){
        return $this->belongsTo('App\Models\MainCategory','category_id');
    }
    public function setPasswordAttribute($password){
        if(!empty($password))
        {
            $this->attributes['password']=bcrypt($password);
        }

    }
}
