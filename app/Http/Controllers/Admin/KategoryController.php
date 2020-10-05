<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use App\Models\Kategory;
use App\Models\ParentCategory;
//data table jajra
use yajra\DataTables\Datatables;

class KategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categoryAdd = ParentCategory::all();
        return view('admin.subCategory.index', compact('categoryAdd'));
    }
    public function tableSubCategory()
    {
       $data = Kategory::all();
       return Datatables::of($data)
    //    ->editColumn('production_id', function(Sewing $data){
    //     $no_po  = DB::table('mj_production')->select('no_po')->where('id', $data->production_id)->first();
    //     return $no_po->no_po;
    // })
    //    ->editColumn('pengawas', function(Sewing $data){
    //      $data_staff = [];
    //      $pengawas = DB::table('mj_sewing_detail')->select('pengawas')->where('sewing_id', $data->id)->get();
    //      foreach ($pengawas as $peng) {
    //         $awas = DB::table('users')->select('first_name','last_name')->where('id', $peng->pengawas)->first();
    //         $data_staff[] = ' '.$awas->first_name.' '.$awas->last_name.' ';
    //     }
    //     return $data_staff;
    // })
       ->editColumn('parentCategory', function(Kategory $data){
        
        return $data->parent->name;
    })
       ->addColumn('action',function($data){
        return "
        <div class='text-center'>
        <button type='button' data-id='".$data->id."' id='btnEditCategory' class='btn btn-info btn-sm'><i class='fa fa-edit'></i></button>
        <button  data-id='".$data->id."' id='btnRemoveCategory' class='btn btn-danger btn-sm ml-2'><i class='fa fa-trash'></i></button>
        </div>
        ";
    })
       ->rawColumns(['action','parentCategory'])
       ->toJson();
   }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeSubCategory(CategoryRequest $request)
    {
        $message  = [];

        $checkName = Kategory::where('name', $request->categoryName)->get();
        $checkSlug = Kategory::where('slug', $request->slug)->get();

        //check apakah data sudah ada di database
        if(count($checkName) > 0 and count($checkSlug) > 0 ){
            $message['add'] = 'nameSlugUse';
        }else if(count($checkSlug) > 0){
            $message['add'] = 'slugUse';
        }else if(count($checkName) > 0){
            $message['add'] = 'nameUse';
        }else{
           //jika tidak ada add data 
         $create = new Kategory();
         $create->name = $request->categoryName;
         $create->slug = $request->slug;
         $create->parent_id = $request->parent_id;
         $create->save();
         if($create){
            $message['add'] = true;
        }else{
            $message['add'] = false;
        }
        
    }

    return response()->json($message);
}

public function deleteSubCategory()
{
    $remove = Kategory::where('id', request()->id)->delete();
    $message = [];
    if($remove){
        $message['remove'] = true;
    }else{
        $message['remove'] = false;
    }

    return response()->json($message);
}
public function editDataSubCategory()
{
    if(request()->ajax()){
        if(request()->showData){
            $category = Kategory::where('id', request()->id)->first();
            $parentCategory = ParentCategory::all();
            return view('admin.subCategory.form',compact('category','parentCategory'));
        }
        if(request()->editDataCategory){

            $checkEdit = Kategory::where('id', request()->id)->first();

            if($checkEdit->name === request()->categoryName and $checkEdit->slug === request()->slug){

              $edit    = Kategory::where('id', request()->id)->update([
                'name' => request()->categoryName,
                'slug' => request()->slug,
                'parent_id' => request()->parent_id,
            ]);
              if($edit){
                $message['edit'] = true;
            }else{
                $message['edit'] = false;
            }

        }else if($checkEdit->name === request()->categoryName){

         $checkSlug = Kategory::where('slug', request()->slug)->get();

         if(count($checkSlug) > 0){
            $message['edit'] = 'slugUse';
        }else{
           $edit    = Kategory::where('id', request()->id)->update([
            'name' => request()->categoryName,
            'slug' => request()->slug,
            'parent_id' => request()->parent_id,
        ]);
           if($edit){
            $message['edit'] = true;
        }else{
            $message['edit'] = false;
        }
    }
}else if($checkEdit->slug === request()->slug){

   $checkName = Kategory::where('name', request()->categoryName)->get();

   if(count($checkName) > 0){
    $message['edit'] = 'nameUse';
}else{
 $edit    = Kategory::where('id', request()->id)->update([
    'name' => request()->categoryName,
    'slug' => request()->slug,
    'parent_id' => request()->parent_id,
]);
 if($edit){
    $message['edit'] = true;
}else{
    $message['edit'] = false;
}
}
}else{
    $message['edit'] = 'nameSlugUse';
}
return response()->json($message);

}
}
}
}




// $checkName = Kategory::where('name', request()->categoryName)->get();
// $checkSlug = Kategory::where('slug', request()->slug)->get();

//         //check apakah data sudah ada di database
// if(count($checkName) > 0 and count($checkSlug) > 0 ){
//     $message['edit'] = 'nameSlugUse';
// }else if(count($checkSlug) > 0){
//     $message['edit'] = 'slugUse';
// }else if(count($checkName) > 0){
//     $message['edit'] = 'nameUse';
// }else{
//            //jika tidak ada add data 

//     $edit    = Kategory::where('id', request()->id)->update([
//         'name' => request()->categoryName,
//         'slug' => request()->slug,
//     ]);
//     if($edit){
//         $message['edit'] = true;
//     }else{
//         $message['edit'] = false;
//     }
// }

// return response()->json($message);