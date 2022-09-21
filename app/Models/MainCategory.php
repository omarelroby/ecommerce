<?php

namespace App\Models;

use App\Observers\mainCategoryObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SubCategory;

class MainCategory extends Model
{
    use HasFactory;
    protected $table='main_categories';
    protected $fillable =
        [
            'translation_lang',
            'translation_of',
            'name',
            'slug',
            'photo',
            'active',
            'created_at',
            'updated_at',
        ];
    public static function boot(){
        parent::boot();
        MainCategory::observe(mainCategoryObserver::class);
    }
    public function scobeActive($query)
    {
        return $query->where('active',1);
    }
    public function scobeSelection($query)
    {
        return $query->select('id','translation_lang','name','slug','photo','active','translation_of');
    }
    public function getPhotoAttribute($val){
        return ($val!==null)? asset('assets/'.$val) :  "";
    }
    public function getActive(){
      return  $this->active ==1 ? 'مفعل':'غير مفعل';
    }
    public function categories(){
        return $this->hasMany(self::class,'translation_of');
    }
    public function vendors(){
        return $this->hasMany('App\Models\Vendor','category_id');
    }
    public function subCategories(){
        return $this->hasMany(SubCategory::class,'category_id','id');
    }


}
