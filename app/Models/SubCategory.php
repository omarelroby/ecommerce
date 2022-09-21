<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MainCategory;

class SubCategory extends Model
{
    use HasFactory;
    protected $table='sub_category';
    protected $fillable =
        [
            'translation_lang',
            'translation_of',
            'parent_id',
            'name',
            'slug',
            'photo',
            'active',
            'created_at',
            'updated_at',
        ];
    public function scobeActive($query)
    {
        return $query->where('active',1);
    }
    public function scobeSelection($query)
    {
        return $query->select('id','parent_id','translation_lang','name','slug','photo','active','translation_of');
    }
    public function getPhotoAttribute($val){
        return ($val!==null)? asset('assets/'.$val) :  "";
    }
    public function mainCategory(){
        return $this->belongsTo(MainCategory::class,'category_id','id');
    }
}
