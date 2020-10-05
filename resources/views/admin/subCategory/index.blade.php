@extends('admin.layout')
@section('title','Category')

@section('content')

<div class="content">
	<div class="row">
		<div class="col-sm-12">
			<div class="card card-default">
				<div class="card-header card-header-border-bottom">
					<div style="display: flex; justify-content: space-between;">
						<h3>Categories</h3>
						<button data-toggle="modal"  data-target="#modalUpdateAdd" class="btn btn-primary">Tambah Data</button>
					</div>
				</div>
				<div class="card-body">
					<table class="table table-hover table-striped table-bordered" id="tableCategory">
						<thead>
							<tr>
								<th>Name</th>
								<th>Slug</th>
								<th>Parent Category</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

@stop

<!-- Modal -->
<div class="modal fade" id="modalUpdateAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			@include('admin.subCategory.form',['categoryAdd' => $categoryAdd])
			
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalUpdate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="roomFormCategory">
				
			</div>
		</div>
	</div>
</div>

@section('script')

<script>
	$(document).ready(function(){
		var tableCategory = $('#tableCategory').DataTable({
			processing: true,
			serverSide: true,
			"autoWidth": false,
			"responsive": true,
			async: true,
			ajax:"{{ route('category.tableSubCategory') }}",
			columns: [

			{ data: 'name', name: 'name' },
			{ data: 'slug', name: 'slug' },
			{ data: 'parentCategory', name: 'parentCategory' },
			{ data: 'action', name: 'action',orderable: false, searchable: false },
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
		});
	})

	//ajax for add data category
	$(document).on('submit', '#formAddCategory' ,function(e){
		e.preventDefault();
		const data = $('#formAddCategory').serialize();
		
		$.ajax({
			url: "{{route('category.addDataSubCategory')}}",
			type: 'POST',
			data: data,
			dataType: 'json',
			success: function(result){
				$('#tableCategory').DataTable().ajax.reload();
				if(result.add == true){
					Swal.fire(
						'Success Add Data',
						'Data Success add To Database',
						'success'
						)
					$('#modalUpdateAdd').modal('hide');
					$('#formAddCategory').trigger('reset');
				}else if(result.add === 'nameSlugUse'){
					$('#modalUpdateAdd #formAddCategory .messageName').html('Category Name Already Taken');
					$('#modalUpdateAdd #formAddCategory .messageSlug').html('Slug Already Taken');
					$('#modalUpdateAdd #formAddCategory .messageSlug').show();
					$('#modalUpdateAdd #formAddCategory .messageName').show();
				}else if(result.add === 'nameUse'){
					$('#modalUpdateAdd #formAddCategory .messageName').html('Category Name Already Taken');
					$('#modalUpdateAdd #formAddCategory .messageSlug').css('display','none');
					$('#modalUpdateAdd #formAddCategory .messageName').show();
				}else if(result.add === 'slugUse'){
					$('#modalUpdateAdd #formAddCategory .messageSlug').html('Slug Already Taken');
					$('#modalUpdateAdd #formAddCategory .messageName').css('display','none');
					$('#modalUpdateAdd #formAddCategory .messageSlug').show();
				}else{
					Swal.fire(
						'Oops!',
						'Something Wrong...',
						'error'
						)
				}
			}
		})
	})
	//end

	//ajax for edit category
	$(document).on('click','#btnRemoveCategory', function(e){
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
					url: "{{route('category.removeDataSubCategory')}}",
					data: {_token:'{{csrf_token()}}','id': id},
					type: "POST",
					dataType: 'json',
					success: function(result){
						$('#tableCategory').DataTable().ajax.reload();
						if(result.remove === true){
							Swal.fire(
								'Success Remove',
								'Data Success Removed From Database',
								'success'
								)
						}else{
							Swal.fire(
								'Faild Remove',
								'Data Faild Removed From Database',
								'error'
								)
						}
					}
				})

			}
		})
	})
	//end

	//ajax to show data category
	$(document).on('click','#btnEditCategory', function(e){
		const id = $(this).data('id');
		$.ajax({
			url: "{{route('category.editSubCategory')}}",
			data: {
				'showData': true,
				_token: "{{csrf_token()}}",
				'id'  : id,
			},
			dataType: 'html',
			type: 'POST',
			success: function(result){
				$('.roomFormCategory').html(`${result}`);
				$('#modalUpdate').modal('show');
			}
		})
	})
	//end

	//ajax to edit data category
	$(document).on('submit','#formEditCategory', function(e){
		e.preventDefault();
		let data = $('#formEditCategory').serialize() + "&editDataCategory=true";
	
		$.ajax({
			url: "{{route('category.editSubCategory')}}",
			type: 'POST',
			data: data,
			dataType: 'json',
			success: function(result){
				$('#tableCategory').DataTable().ajax.reload();
				if(result.edit == true){
					Swal.fire(
						'Success Update Data',
						'Data Success Update To Database',
						'success'
						)
					$('#modalUpdate').modal('hide');
					$('#formAddCategory').trigger('reset');
				}else if(result.edit === 'nameSlugUse'){
					$('#modalUpdate #formEditCategory .messageName').html('Category Name Already Taken');
					$('#modalUpdate #formEditCategory .messageSlug').html('Slug Already Taken');
					$('#modalUpdate #formEditCategory .messageSlug').show();
					$('#modalUpdate #formEditCategory .messageName').show();
				}else if(result.edit === 'nameUse'){
					$('#modalUpdate #formEditCategory .messageName').html('Category Name Already Taken');
					$('#modalUpdate #formEditCategory .messageSlug').css('display','none');
					$('#modalUpdate #formEditCategory .messageName').show();
				}else if(result.edit === 'slugUse'){
					$('#modalUpdate #formEditCategory .messageSlug').html('Slug Already Taken');
					$('#modalUpdate #formEditCategory .messageName').css('display','none');
					$('#modalUpdate #formEditCategory .messageSlug').show();
				}else{
					Swal.fire(
						'Oops!',
						'Something Wrong...',
						'error'
						)
				}
			}
		})

	})
	//end
</script>

@endsection