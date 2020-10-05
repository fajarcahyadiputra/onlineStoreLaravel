@extends('admin.layout')
@section('title','Product')

@section('content')

<div class="content">
	<div class="row">
		<div class="col-sm-12">
			<dic class="card">
				<div class="card-header card-header-border-bottom" style="display: flex; justify-content: space-between;">
					<h3>Data Product</h3>

				<a href="{{route('product.halAddData')}}" class="btn btn-primary">Tambah Data</a>
				</div>
				<div class="card-body">
					<table class="table table-hover table-bordered table-striped" id="tableProduct">
						<thead>
							<tr>
								<th>SKU</th>
								<th>Name</th>
								<th>Img</th>
								<th>Price</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
					</table>
				</div>
			</dic>
		</div>
	</div>
</div>

@endsection



<!-- Modal Images-->
<div class="modal fade" id="modalDetailImg" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Prouct Images</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body table-img">
				
			</div>
		</div>
	</div>
</div>

<!-- Modal add image-->
<div class="modal fade" id="modalAddImg" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Add Images</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="formAddImg" name="formAddImg" method="post" enctype="multipart/form-data">
			
			</form>
		</div>
	</div>
</div>

@section('script')

<script>
	$(document).ready(function(){

		//datatable
		$('#tableProduct').DataTable({
			serverside: true,
			processing: true,
			"autoWidth": false,
			"responsive": true,
			async: true,
			ajax: {
				data: {'dataTable': true},
				url : "{{route('product.index')}}",
				method: 'GET',
			},
			columns: [
			{data: 'sku', name: 'sku'},
			{data: 'name', name: 'name'},
			{data: 'img', name: 'img'},
			{data: 'price', name: 'price'},
			{data: 'statues', name: 'statues'},
			{data: 'action', name: 'action',orderable: false}
			],
			"columnDefs":[
			{
				targets:[0],
				orderable: false,
			}
			],
			select: {
				info: true
			},
			buttons: [] 
		})
		//end

		//ajax for delete data product
		$(document).on('click', '#btnRemoveProduct', function(){
			const id = $(this).data('id');

			Swal.fire({
			title: 'Are You Sure Wanna Remove It?',
			text: "Wanna Remove This Data!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, Do It!'
		}).then((result) => {
			if (result.value) {

			$.ajax({
				url: "{{route('product.delete')}}",
				type: "GET",
				dataType: 'json',
				data: {
					'id': id
				},
				success: function(result){
					console.log(result)
					if(result.delete === true){
						Swal.fire(
						'Success',
						'Success Delete Data from Database',
						'success'
						)
					}else{
						Swal.fire(
						'Opsss',
						'Fail delete Data From Database',
						'error'
						)
					}
				$('#tableProduct').DataTable().ajax.reload();
				}
			})
		}
	})
})

//ajax detail images
$(document).on('click','#btnProductImg', function(){
	const id = $(this).data('id');
	
	$.ajax({
		url: "{{route('product.index')}}",
		data: {
			'detailImg': true,
			'id' 	   : id
		},
		dataType: 'json',
		type: 'GET',
		success: function(result){
			if(result.data === null){
				$('#modalAddImg').modal('show');
				$('#formAddImg').html(`
							@csrf
							<div class="modal-body add-img">
								<div class="form-group">
									<label for="">Upload Img Here</label>
									<input required type="file" name="productImg" class="form-control">
									<input required type="text" name="productId" hidden value="${result.productId}">
								</div>
							</div>
							<div class="modal-footer">
								<button class="btn btn-success" type="submit">Save</button>
							</div>`)

			}else{
				$('#modalDetailImg').modal('show');
			}
		}
	})
})

//ajax to add img

$(document).on('submit','#formAddImg', function(e){
	e.preventDefault();
	const data = new FormData(document.forms['formAddImg']);
	$.ajax({
		url: "{{route('product.addImg')}}",
		type: '\post',
		dataType: 'json',
		data: data,
		contentType: false,
		processData: false,
		cache: false,
		async: true,
		success: function(result){
			console.log(result)
		}
	})
})


})
</script>

@endsection