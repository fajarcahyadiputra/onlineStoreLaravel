<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use yajra\DataTables\Datatables;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Kategory;
use App\Models\ProductCategories;
use App\Models\ProductImage;
use DB;
use Illuminate\Auth\Events\Validated;

class ProductController extends Controller
{
	public function __construct()
	{
		$this->statues = Product::statues();
	}
	public function index(Request $request)
	{
		if(request()->ajax()){
			if(request()->input('dataTable')){

				$product = Product::all();

				return Datatables::of($product)
				->editColumn('statues', function(Product $product){

					switch($product->status){
						case 0: $status = 'draf';
						break;
						case 1: $status = 'active';
						break;
						case 2: $status = 'In Active';
						break;
					}

					return $status;
				})
				->addColumn('img', function(Product $product){
					return "<button  data-id='".$product->id."' id='btnProductImg' class='btn btn-primary btn-sm ml-2'><i class='fas fa-images'></i></button>";
				})
				->addColumn('action', function(Product $data){
					return "
					<div class='text-center'>
					<a href='".url('product/pageEditData/'.$data->id.'')."' class='btn btn-info btn-sm'><i class='fa fa-edit'></i></a>
					<button  data-id='".$data->id."' id='btnRemoveProduct' class='btn btn-danger btn-sm ml-2'><i class='fa fa-trash'></i></button>
					</div>
					";
				})
				->editColumn('price', function(Product $product){
					return number_format($product->price,0,',','.');
				})
				->rawColumns(['action','statues','price','img'])
				->toJson();
			}

			//detail images
			if($request->input('detailImg')){
				$data = [];
				$images = ProductImage::where('product_id', $request->input('id'))->get();
				if(count($images) === 0){
					$data['data'] = null;
					$data['productId'] = $request->input('id');
				}else{
					$data['data'] = $images;
				}

				return response()->json($data);
			}
		}
		$product = Product::all();
		return view('admin.product.index', compact('product'));
	}
	public function halAddData()
	{
		$kode = Product::select(DB::raw('MAX(RIGHT(sku, 6)) as kodeMAx'));
		// dd($kode->count());
		if ($kode->count() > 0) {
			foreach ($kode->get() as $k) {
				$tmp = ((int) $k->kodeMAx) + 1;
				$sku  =  'AK'.sprintf("%06s", $tmp);
			}
		}else{
			$sku = 'AK000001';
		}
		$statues = $this->statues;
		$categories = Kategory::all();

		return view('admin.product.pageAddData',compact('statues','categories','sku'));
	}
	public function store(Request $request)
	{
		$pesan = [];
		$validator = $request->validate([
			'sku' => 'required',
			'name' => 'required',
			'price' => 'required',
			'categories' => 'required',
			'height' => 'required',
			'statues' => 'required'
		]);
		
		$product = new Product();
		$product->sku = $request->sku;
		$product->user_id = Auth()->user()->id;
		$product->name = $request->name;
		$product->slug = \Str::slug($request->name);
		$product->price = $request->price;
		$product->weight = $request->weight;
		$product->length = $request->length;
		$product->width = $request->width;
		$product->height = $request->height;
		$product->short_description = $request->shortDescription;
		$product->description = $request->description;
		$product->status = $request->statues;
		$product->save();

		if($product){
			foreach($request->categories as $category_id){
				ProductCategories::insert([
					'product_id' => $product->id,
					'category_id' => $category_id,
					'created_at'  => date('Y-m-d h:i:m'),
					'updated_at'  => date('Y-m-d h:i:m'),
				]);
			}
			$pesan['insert'] = true;
		}else{
			$pesan['insert'] = false;
		}

		return response()->json($pesan);
		
	}
	public function halEditData($id)
	{
		$statues = $this->statues;
		$categories = Kategory::all();
		$product = Product::where('id', $id)->first();
		$productCategorie = ProductCategories::where('product_id', $id)->get();
		return view('admin.product.pageEditData',compact('statues','categories','product','productCategorie'));
	}
	public function update(Request $request)
	{
					
		$pesan = [];
		$checkCategories = ProductCategories::where('product_id', $request->id)->get();

		$validator = $request->validate([
			'name' => 'required',
			'price' => 'required',
			'categories' => 'required',
			'height' => 'required',
			'statues' => 'required'
		]);

		if(count($request->categories) === count($checkCategories)){

			$product = Product::where('id', $request->id)->update([
				'user_id' => Auth()->user()->id,
				'name'  => $request->name,
				'slug' => \Str::slug($request->name),
				'price' => $request->price,
				'height' => $request->height,
				'short_description' => $request->shortDescription,
				'description' => $request->description,
				'status' => $request->statues,
			]);

			if($product){
				foreach($request->categories as $category_id){
					ProductCategories::where('product_id', $request->id)->update([
						'category_id' => $category_id,
						'updated_at'  => date('Y-m-d h:i:m'),
					]);
				}
				$pesan['edit'] = true;
			}else{
				$pesan['edit'] = false;
			}

		}else{
		
		ProductCategories::where('product_id', $request->id)->delete();

		$product = Product::where('id', $request->id)->update([
			'user_id' => Auth()->user()->id,
			'name'  => $request->name,
			'slug' => \Str::slug($request->name),
			'price' => $request->price,
			'height' => $request->height,
			'short_description' => $request->shortDescription,
			'description' => $request->description,
			'status' => $request->statues,
		]);

		if($product){
			foreach($request->categories as $category_id){
				ProductCategories::insert([
					'product_id' => $request->id,
					'category_id' => $category_id,
					'created_at'  => date('Y-m-d h:i:m'),
					'updated_at'  => date('Y-m-d h:i:m'),
				]);
			}
			$pesan['edit'] = true;
		}else{
			$pesan['edit'] = false;
		}

		}

		return response()->json($pesan);	
	}
	public function delete(Request $request)
	{
		$pesan = [];
		$delete = Product::where('id', $request->input('id'))->delete();
		if($delete){
			$pesan['delete'] = true;
		}else{
			$pesan['delete'] = false;
		}

		return response()->json($pesan);	
	}
	public function addImg(Request $request)
	{
		$validate = $request->validate([
			'productImg' => 'mimes:jpg,png,jpeg',
		]);
		if($validate){
			$coba['dd'] = true;
		}else{
			$coba['dd'] = false;
		}
		// $imgName = time().'-'.$request->productImg->getClientOriginalName();
		// $folder  = 'images/products';
		return response()->json($request->productImg->getClientOriginalName());
	}
}
