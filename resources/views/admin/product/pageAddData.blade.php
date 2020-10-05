@extends('admin.layout')
@section('title','Dashboard')

@section('content')

<div class="row">
	<div class="col-sm-12">
		<div class="card">
			<div class="card-header">
				<h3>Page To Add Product</h3>
			</div>
			<div class="card-body">
				<form id="formAddProduct" name="formAddProduct">
					@csrf
					<div class="form-group">
						<label for="sku">SKU</label>
						<input required="" type="text" name="sku" readonly="" class="form-control" id="sku" value="{{$sku}}">
					</div>
					<div class="form-group">
						<label for="name">Name</label>
						<input   type="text" name="name" class="form-control" id="name">
					</div>
					<div class="form-group">
						<label for="price">Price</label>
						<input required type="number" name="price" class="form-control" id="price">
					</div>
					<div class="form-group">
						<label for="category">Category</label>
						<select multiple="multiple" required name="categories[]" class="form-control" id="categories">
							@foreach($categories as $ct)
								<option value="{{$ct->id}}">{{$ct->name}}</>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label for="shortDescription">Short Description</label>
						<textarea name="shortDescription" name="description" id="shortDescription" rows="2" class="form-control"></textarea>
					</div>
					<div class="form-group">
						<label for="description">Description</label>
						<textarea name="description" name="description" id="description" rows="4" class="form-control"></textarea>
					</div>
					<div class="form-group">
						<label for="weight">Weight</label>
						<input required type="number" step="0.1" name="weight" class="form-control" id="weight">
					</div>
					<div class="form-group">
						<label for="length">Length</label>
						<input  type="number" step="0.1" name="length" class="form-control" id="length">
					</div>
					<div class="form-group">
						<label for="width">Width</label>
						<input  type="number" step="0.1" name="width" class="form-control" id="width">
					</div>
					<div class="form-group">
						<label for="height">Height</label>
						<input  type="number" step="0.1" name="height" class="form-control" id="height">
					</div>
					<div class="form-group">
						<label id="statues">Statues</label>
						<select name="statues" class="form-control" id="statues">
							<option value="" disabled="" selected="" hidden="">Select Statues</option>
							@foreach($statues as $index => $st)
								<option value="{{$index}}">{{$st}}</option>
							@endforeach
						</select>
					</div>
					<button style="width: 100px"  type="submit" class="btn btn-success">Add</button>
					<a style="width: 100px" href="{{URL::to('product')}}"  class="btn btn-warning">Back</a>
				</form>
			</div>
		</div>
	</div>
</div>																																								
@endsection

@section('script')
<script>
	$(document).ready(function(){
		$(document).ready(function() {
			$('#categories').select2({
				width: '100%',
				theme: 'bootstrap4',
				placeholder: 'Pilih Categories'
			});
		});
		//ajax for add data product
		$('#formAddProduct').on('submit', function(e){
			e.preventDefault();
			const data = new  FormData(document.forms['formAddProduct']);
			
			$.ajax({
				url: "{{route('product.addData')}}",
				type: 'POST',
				dataType: 'JSON',
				data: data,
				contentType: false,
				processData: false,
				async: true,
				cache: false,
				success: function(result){
					if(result.insert === true){
						Swal.fire(
						'Success',
						'Success Insert Data To Database',
						'success'
						).then(()=>{
							document.location.href = "{{URL::to('product')}}";
						})
						
					}else{
						Swal.fire(
						'Faild To Add',
						'There Are Somthing Wrong',
						'error'
						)
					}
				},
				error: function(result){
					Swal.fire(
						'Faild To Add',
						'There Are Somthing Wrong With Your Input',
						'warning'
						)
		}
			})
		
		})
	})
</script>
@endsection



