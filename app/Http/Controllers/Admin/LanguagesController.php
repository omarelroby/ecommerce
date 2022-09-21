<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LanguageRequest;
use App\Http\Requests\LoginRequest;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class LanguagesController extends Controller
{
    public  function index(){
        $lang=Language::select()->paginate(PAGINATION_COUNT);
        return view('admin.languages.index',compact('lang'));
    }
    public function create(){
        return view('admin.languages.create');
    }
    public  function store(LanguageRequest $request)
    {

        try {
            Language::create($request->except(['_token']));
            return redirect()->route('admin.languages')->with(['success'=>'تم حفظ اللغة بنجاح']);

        }
        catch (\Exception $ex){
            return $ex;
             redirect()->route('admin.languages')->with(['error'=>'هناك خطأ ما يرجة المحاولة فيما بعد']);


        }
    }
    public function edit($id){
        $language=Language::find($id);
        if(!$language){
            return redirect()->back()->with(['error'=>'هذه اللغة غير موجودة']);
        }
        return view('admin.languages.edit',compact('language'));
    }
    public function update($id,LanguageRequest $request){

           $lang = Language::find($id);
           if (!$lang)
           {
               return redirect()->route('admin.language.edit',$id)->with(['error' => 'هذه اللغة غير موجودة']);
           }

        if (!$request->has('active'))
            $request->request->add(['active' => 0]);
           $lang->update($request->except('_token'));
           return redirect()->route('admin.languages')->with(['success'=>'تم التحديث بنجاح']);
    }
    public function destroy($id)
    {
        try {
            $lang = Language::find($id);
            if (!$lang) {
                return redirect()->route('admin.language.edit', $id)->with(['error' => 'هذه اللغة غير موجودة']);
            }
            $lang->delete();
            return redirect()->route('admin.languages')->with(['success' => 'تم الحذف بنجاح']);
        }
        catch (\Exception $ex){
            return redirect()->route('admin.languages')->with(['error' => 'هناك خطا ما يرجي المحاوله فيما بعد']);

        }

    }
}

