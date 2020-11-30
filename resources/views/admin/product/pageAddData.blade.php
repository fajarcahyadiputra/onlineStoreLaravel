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
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="sku">SKU</label>
								<input required="" type="text" name="sku" readonly="" class="form-control" id="sku" value="{{$sku}}">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="name">Name</label>
								<input   type="text" name="name" class="form-control" id="name">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label id="statues">Statues</label>
								<select name="statues" class="form-control" id="statues">
									<option value="" disabled="" selected="" hidden="">Select Statues</option>
									@foreach($statues as $index => $st)
										<option value="{{$index}}">{{$st}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="category">Category</label>
								<select multiple="multiple" required name="categories[]" class="form-control" id="categories">
									@foreach($categories as $ct)
										<option value="{{$ct->id}}">{{$ct->name}}</>
									@endforeach
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="shortDescription">Short Description</label>
								<textarea name="shortDescription" name="description" id="shortDescription" rows="3" class="form-control"></textarea>
							</div>
						</div>
						<div class="col-6">
							<div class="form-group">
								<label for="description">Description</label>
								<textarea name="description" name="description" id="description" rows="3" class="form-control"></textarea>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">

						</div>
						<div class="col-md-6" style="display: flex; justify-content: flex-end">
							<button type="button" id="AddproductVarian" class="btn btn-primary"><i class="fas fa-plus mr-2"></i>Add Detail</button>
						</div>
					</div>
					<div class="detailForm">
						@include('admin.product.partial.formAdd',['data' => $attribute,'indexDetail' => 1])
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
	//ajax to get attribute option
	$(document).on('change','#attribute_id', function(){
		const attribute_id = $(this).val();
		let indexParent = $(this).data('indexparent');
		let indexVariant = $(this).data('indexvariant');
		alert(indexVariant)
		$.ajax({
			url: "{{route('product.halAddData')}}",
			data:{
				getAttributeOption: true,
				attribute_id 	  : attribute_id
			},
			dataType: 'JSON',
			method: 'GET',
			success: function(result){
				$(`#attribute_option_id${indexParent}${indexVariant}`).html(``)
				$(`#attribute_option_id${indexParent}${indexVariant}`).append(`<option value="" selected disabled hidden>Select Attribute Option</option>`)
				result.map((data=>{
					$(`#attribute_option_id${indexParent}${indexVariant}`).append(`<option value="${data.id}">${data.name}</option>`)
				}))
			}
		})
	})

	//ajx for add form varian
	var indexDetailAdd = 1;
	$(document).on('click','#AddproductVarian', function(){
		indexDetailAdd++
		$.ajax({
			url: "{{route('product.halAddData')}}",
			data:{
				addFormDetail: true,
				indexVarianAdd: indexDetailAdd
			},
			dataType: 'HTML',
			type: 'GET',
			success: function(result){
				$('.detailForm').append(`
				<div class="penampungFormDetail${indexDetailAdd}">
				<hr>
				<div class="row">
					<div class="col-md-6">
					</div>
					<div class="col-md-6" style="display: flex; justify-content: flex-end">
						<button  type="button" data-indexvarianremove="${indexDetailAdd}" id="removeProductVarian" class="btn btn-danger"><i class="fas fa-minus-square mr-2"></i>Remove Detail</button>
					</div>
				</div>`+result+'</div>');

			}
		})
	})

	//ajax to remove form varian
	$(document).on('click','#removeProductVarian', function(){
		let indexvarianremove = $(this).data('indexvarianremove')
		
		$.ajax({
			url: "{{route('product.halAddData')}}",
			data:{
				removeFormVarian: true,
				indexvarianremove: indexvarianremove
			},
			dataType: 'JSON',
			type: 'GET',
			success: function(result){
				$('.penampungFormDetail'+result).remove()
			}
		})
	})

	//ajax to add variant product form
	var indexVariant = 1;
	$(document).on('click','#btnAddVariantProduct', function(){
		const indexParent = $(this).data('parentindex');
		indexVariant++
		
		$.ajax({
			url: "{{route('product.halAddData')}}",
			data:{
				addFormVariant: true,
				indexParent  : indexParent,
				indexVariant: indexVariant
			},
			dataType: 'HTML',
			type: 'GET',
			success: function(result){
				// console.log(result)
				$(`.variantForm${indexParent}`).append(`
				<div class="penampungFormVariant${indexParent}${indexVariant}">
				`+result+'</div>');
			}
		})
	})

	$(document).on('click','#btn-remove-variant', function(){
		const indexParent = $(this).data('indexparent');
		const indexVariant = $(this).data('indexvariant');
		$(`.penampungFormVariant${indexParent}${indexVariant}`).remove();
	})

	})
</script>
@endsection



