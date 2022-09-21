<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\VendorRequest;
use App\Models\MainCategory;
use App\Models\Vendor;
use App\Notifications\VendorCreated;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class vendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::select('id', 'name', 'mobile','active', 'logo', 'category_id')->paginate(PAGINATION_COUNT);
        return view('admin.vendors.index', compact('vendors'));

    }

    public function create()
    {
        $categories = MainCategory::where('translation_of', 0)->get();
        return view('admin.vendors.create', compact('categories'));
    }

    public function store(VendorRequest $request)
    {

        try {
            if (!$request->has('active'))  //هنا بقوله لو مش جاية معاك خليها بصفر
            {
                $request->request->add(['active' => 0]);
            } else
                $request->request->add(['active' => 1]);

            $filePath = "";
            if ($request->has('logo')) {
                $filePath = uploadImage('vendors', $request->logo);
            }

            $vendor = Vendor::create([
                'name' => $request->name,
                'mobile' => $request->mobile,
                'email' => $request->email,
                'active' => $request->active,
                'address' => $request->address,
                'category_id' => $request->category_id,
                'password' => $request->password,
                'logo' => $filePath,
            ]);
//            Notification::send($vendor, new VendorCreated($vendor));
            return redirect()->route('admin.vendors')->with(['success' => 'تم الحفظ بنجاح']);

        } catch (\Exception $ex) {
            return $ex;
             redirect()->route('admin.vendors')->with(['error' => 'هناك خطأ ما في البيانات']);
        }
    }

    public function edit($id)
    {
        try {
            $vendor = Vendor::select()->find($id);
            if (!$vendor) {
                return redirect()->route('admin.vendors')->with(['error' => ' هناك خطأ  في البيانات غير موجود']);
            }
            $categories = MainCategory::where('translation_of', 0)->get();
            return view('admin.vendors.edit', compact('vendor', 'categories'));
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    public function update($id, VendorRequest $request)
    {
        try {
            $vendor = Vendor::select()->find($id);
            if (!$vendor) {
                return redirect()->route('admin.vendors')->with(['error' => ' هناك خطأ  في البيانات غير موجود']);
            }
            $filePath = "";
            if ($request->has('logo')) {
                $filePath = uploadImage('vendors', $request->logo);
            }
            $data = $request->except(['id', '_token', 'photo', 'password']);
            if ($request->has('password')) {
                $data['password'] = $request->password;
            }
            $vendor->update($data);
            $vendor->save();
            return redirect()->route('admin.vendors')->with(['success' => 'تم تحديث البيانات بنجاح']);

        } catch (\Exception $ex) {

        }
    }

    public function destroy($id)
    {
        try {
            $vendor = Vendor::find($id);
            if (!$vendor) {
                return redirect()->route('admin.vendors')->with(['error' => 'هذا القسم غير موجود']);
            }
            $image = Str::after($vendor->logo, 'assets/');
            $image = public_path('assets/' . $image);
            unlink($image); //delete from folder.

            $vendor->delete();
            return redirect()->route('admin.vendors')->with(['success' => 'تم حذف التاجر بنجاح']);

        } catch (\Exception $ex) {
            return $ex;
            redirect()->route('admin.vendors')->with(['error' => 'هناك خطأ ما']);

        }
    }
    public function changeStatus($id){

        try {

            $vendor = Vendor::find($id);
            if (!$vendor) {
                return redirect()->route('admin.vendors')->with(['errors' => 'هذا التاجر غير موجود']);
            }
            $status = $vendor->active == 0 ? 1 : 0;
            $vendor->update(['active' => $status]);
            return redirect()->route('admin.vendors')->with(['success'=>'تم تحديث التفعيلات بنجاح']);
        }
        catch (\Exception $ex){
            redirect()->route('admin.vendors')->with(['error' => 'هناك خطأ ما']);

        }

    }
}
