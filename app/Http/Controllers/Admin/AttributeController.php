<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeOption;
use yajra\DataTables\Datatables;
use Illuminate\Http\Request;
use DB;
use Symfony\Component\Console\Input\Input;

class AttributeController extends Controller
{
  
   public function __construct()
   {
      
   }
    public function index(Request $request)
    {   
        if($request->ajax()){
            if($request->input('datatable')){

                $attribute = Attribute::all();

                return Datatables::of($attribute)
                ->addColumn('action', function(Attribute $data){
                    return "
					<div class='text-center'>
                    <a href='".url('attribute/pageEditData/'.$data->id.'')."' class='btn btn-info btn-sm'><i class='fa fa-edit'></i></a>
                    <button data-check='0' type='button' data-id='".$data->id."' id='btnOptions' class='btn btn-success btn-sm ml-2'><i class='fas fa-clipboard-list'></i></button>
					<button  data-id='".$data->id."' id='btnRemoveAttribute' class='btn btn-danger btn-sm ml-2'><i class='fa fa-trash'></i></button>
					</div>
					";
                })
                ->rawColumns(['action'])
				->toJson();

            }
        }

        return view('admin.attribute.index');
    }

    public function pageCreate(Request $request)
    {
        if($request->ajax()){

            if($request->input('uniqueName')){
                $pesan = [];
                $attribute = Attribute::where('name', $request->input('name'))->get();
                if(count($attribute) > 0){
                    $pesan['check'] = true;
                }else{
                    $pesan['check'] = false;
                }
                return response()->json($pesan);
            }

        }

        $kode = Attribute::select(DB::raw("max(right(code, 6)) as kodeMax"))->limit(1);

        if($kode->count() > 0){
            foreach($kode->get() as $kd){
                $tmp = ((int) $kd->kodeMax) + 1;
                $code = 'AT'. sprintf('%06s', $tmp);
            }
        }else{
            $code = 'AT0000001';
        }

        $type           = Attribute::type();
        $booleanOptions = Attribute::booleanOptions();;
        $validation     = Attribute::validation();
        return view('admin.attribute.pageAdd')->with(compact('type','booleanOptions','validation','code'));
    }

    public function store(Request $request)
    {
        $pesan = [];
		$validator = $request->validate([
			'code' => 'required',
			'name' => 'required',
			'type' => 'required'
        ]);
        
        $params = $request->except('_token');
        $params['is_required'] = (bool) $params['is_required'];
        $params['is_unique'] = (bool) $params['is_unique'];
        $params['is_configurable'] = (bool) $params['is_configurable'];
        $params['is_filterable'] = (bool) $params['is_filterable'];
		
        $add = Attribute::create($params);

		if($add){
			$pesan['insert'] = true;
		}else{
			$pesan['insert'] = false;
		}

		return response()->json($pesan);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $attribute = Attribute::findOrFail($id);
        $type           = Attribute::type();
        $booleanOptions = Attribute::booleanOptions();;
        $validation     = Attribute::validation();

        return view('admin.attribute.pageEdit')->with(compact('attribute','type','booleanOptions','validation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $pesan = [];
		$validator = $request->validate([
			'code' => 'required',
			'name' => 'required',
			'type' => 'required'
        ]);
        
        $params = $request->except('_token');
        $params['is_required'] = (bool) $params['is_required'];
        $params['is_unique'] = (bool) $params['is_unique'];
        $params['is_configurable'] = (bool) $params['is_configurable'];
        $params['is_filterable'] = (bool) $params['is_filterable'];

        $attribute = Attribute::findOrFail($request->id);

		if($attribute->update($params)){
			$pesan['insert'] = true;
		}else{
			$pesan['insert'] = false;
		}

		return response()->json($pesan);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function remove(Request $request)
    {
        $delete = Attribute::findOrFail($request->input('id'));
        $pesan  = [];
        if($delete->delete()){
            $pesan['remove'] = true;
        }else{
            $pesan['remove'] = false;
        }

        return response()->json($pesan);
    }
    public function attributeOptions(Request $request)
    {
       if($request->ajax()){
        $attribute = AttributeOption::where('attribute_id',$request->input('id'))->get();
        if(count($attribute) > 0){
            $data = $attribute;
        }else{
            $data = null;
        }
        return response()->json(['data' => $data, 'attribute_id' => $request->input('id')]);
       }
    }
    public function addOptions(Request $request)
    {
        if($request->ajax()){
            $params = $request->except('_token');
            $pesan  = [];
            if(AttributeOption::create($params)){
                $pesan['insert'] = true;
                $data = AttributeOption::where('attribute_id', $request->attribute_id)->get();
                $pesan['data']   = $data;
            }else{
                $pesan['insert'] = false;
                $pesan['data']   = [];
            }

            return response()->json($pesan);
        }
    }
    public function removeOptions(Request $request)
    {
        $delete = AttributeOption::findOrFail($request->input('id'));
        $pesan  = [];
        if($delete->delete()){
            $pesan['remove'] = true;
            $data = AttributeOption::all();
            $pesan['data']   = $data;
        }else{
            $pesan['remove'] = false;
            $pesan['data']   = [];
        }
        return response()->json($pesan);
    }
    public function editOptions(Request $request)
    {
        if($request->ajax()){
           if($_SERVER['REQUEST_METHOD'] === 'POST'){

            if($request->updated){
                $params = $request->except('_token','id');
                $attrOption = AttributeOption::findOrFail($request->id);
                if($attrOption->update($params)){
                    $pesan['edit'] = true;
                    $data = AttributeOption::all();
                    $pesan['data']   = $data;
                }else{
                    $pesan['edit'] = false;
                    $pesan['data'] = [];
                }

                return response()->json($pesan);
            }

            $attrOption = AttributeOption::findOrFail($request->id);
            return response()->json($attrOption);
           }
        }
    }
}
