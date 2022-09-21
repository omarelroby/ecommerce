<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MainCategoryRequest;
use App\Models\Language;
use App\Models\MainCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MainCategoriesController extends Controller
{
    public function index()
    {
        $default_lang = get_default_language();
        $categories = MainCategory::where('translation_lang', $default_lang)->select()->get();
        return view('admin.maincategories.index', compact('categories'));
    }

    public function create()
    {

        $language = Language::all();
        return view('admin.maincategories.create', compact('language'));
    }

    public function store(MainCategoryRequest $request)
    {
        try {


            $main_categories = collect($request->category); //to insert array of category in collection.
//        return  $main_categories;
            $filter1 = $main_categories->filter(function ($value, $key) //to filter default lang from collection.
            {
                return $value['abbr'] == get_default_language();   //or 'en' or 'ar'

            });
//        return $filter1;

            $default_category = array_values($filter1->all())  [0]; //will select all default lang categories
//          return  $default_category;
            $filePath = "";
            if ($request->has('photo')) {
                $filePath = uploadImage('maincategories', $request->photo);
            }
            DB::beginTransaction();

            $default_category_id = MainCategory::insertGetId([
                'translation_lang' => $default_category['abbr'],
                'translation_of' => 0,
                'name' => $default_category['name'],
                'slug' => $default_category['name'],
                'photo' => $filePath,

            ]);


            $filter2 = $main_categories->filter(function ($value, $key) {  //احضار اللغات الآخرى غير الdefault
                return $value['abbr'] != get_default_language();

            });
            $others = array_values($filter2->all());
            foreach ($others as $other)
                MainCategory::insert([
                    'translation_lang' => $other['abbr'],
                    'translation_of' => $default_category_id,
                    'name' => $other['name'],
                    'slug' => $other['name'],
                    'photo' => $filePath,
                ]);
            return redirect()->route('admin.mainCategories')->with(['success' => 'تم الحفظ بنجاح']);
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            return $ex;
            redirect()->back()->with(['error' => 'هناك خطأ ما']);

        }


    }

    public function edit($mainCat_id)
    {
        $mainCategory = MainCategory::with('categories')
            ->select()
            ->find($mainCat_id);
        if (!$mainCategory) {
            return redirect()->route('admin.mainCategories')->with(['error' => ' هناك خطأ ما']);
        }
        return view('admin.maincategories.edit', compact('mainCategory'));
    }

    public function update($id, MainCategoryRequest $request)
    {

        try {
            $mainCat = MainCategory::find($id);
            if (!$mainCat) {
                return redirect()->back()->with(['error' => 'ليست موجودة']);
            }
            //update data
            $category = array_values($request->category)[0];// لجلب بيانات الاراي 0 فقط دون باقي الاراي
            if (!$request->has('category.0.active'))  //هنا بقوله لو مش جاية معاك خليها بصفر
            {
                $request->request->add(['active' => 0]);
            }
            //save image
            $filePath=$mainCat->photo;
            if ($request->has('photo')) {
                $filePath = uploadImage('maincategories', $request->photo);
            }

            MainCategory::where('id', $id)->update([
                'name' => $category['name'],
                'active' => $request->active,
                'photo'=>$filePath,
            ]);
            return redirect()->route('admin.mainCategories')->with(['success' => 'تم تحديث بيانات القسم']);
        }
        catch (\Exception $ex){
            return  redirect()->route('admin.mainCategories')->with(['error'=>'هناك خطأ ما']);
        }
    }
    public function destroy($id){
        try {
            $maincategory=MainCategory::find($id);
            if(!$maincategory){
                return redirect()->route('admin.mainCategories')->with(['error'=>'هذا القسم غير موجود']);
            }
            $vendors=$maincategory->vendors();
            if(isset($vendors)&&$vendors->count()>0){
                return redirect()->route('admin.mainCategories')->with(['error'=>'لا يمكنك حذف هذا القسم']);
            }
            $image=Str::after($maincategory->photo,'assets/');
            $image=public_path('assets/'.$image);
            unlink($image); //delete from folder.

            $maincategory->categories()->delete();

            $maincategory->delete();
            return redirect()->route('admin.mainCategories')->with(['success'=>'تم حذف القسم بنجاح']);

        }
        catch (\Exception $ex){
            return  redirect()->route('admin.mainCategories')->with(['error'=>'هناك خطأ ما']);

        }
    }
    public function changeStatus($id){
        try {
            $maincategory=MainCategory::find($id);
            if(!$maincategory){
                return redirect()->route('admin.mainCategories')->with(['error'=>'هذا القسم غير موجود']);
            }
            $status=$maincategory->active==0?1:0;
            $maincategory->update(['active'=>$status]);
            return redirect()->route('admin.mainCategories')->with(['success'=>'تم تحديث التفعيل  بنجاح']);

        }
        catch (\Exception $ex)
        {
            return  redirect()->route('admin.mainCategories')->with(['error'=>'هناك خطأ ما']);

        }

    }
}
