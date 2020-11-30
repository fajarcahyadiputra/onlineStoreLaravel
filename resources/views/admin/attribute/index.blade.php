@extends('admin.layout')
@section('title','Atribute')

@section('content')

<div class="content">
	<div class="row">
		<div class="col-sm-12">
			<div class="card card-default">
				<div class="card-header card-header-border-bottom">
					<div style="display: flex; justify-content: space-between;">
						<h3>Attribute</h3>
						<a href="{{route('attribute.pageAdd')}}"  class="btn btn-primary">Tambah Data</a>
					</div>
				</div>
				<div class="card-body">
					<table class="table table-hover table-striped table-bordered" id="tableAttribute">
						<thead>
							<tr class="text-center">
								<th>Code</th>
								<th>Name</th>
								<th>Type</th>
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


<!-- Modal options-->
<div class="modal fade" id="modalAttributeOptions" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" style="display: flex">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body table-attributeOptions">
				<table class="table table-hover table-bordered">
					<thead>
						<tr class="text-center">
							<th>Name</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody id="body-table-attributeOptions">
						
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<!-- Modal add attroption-->
<div class="modal fade" id="modalAddAttributeOptions" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Add Attribute Options</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="formAddAttributeOptions" method="post" >
				
			</form>
		</div>
	</div>
</div>

<!-- Modal Edit attroption-->
<div class="modal fade" id="modalEditAttributeOptions" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Edit Attribute Options</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="formEditAttributeOptions" method="post" >
				
			</form>
		</div>
	</div>
</div>

@section('script')

<script>
	$(document).ready(function(){

		$('#tableAttribute').DataTable({
		serverside: true,
		processing: true,
		autoWidth : false,
		responsive: true,
		async: true,
		ajax: {
			url: "{{route('attribute.index')}}",
			data: {
				'datatable': true
			},
			method: 'GET'
		},
		columns: [
			{data: 'code', name: 'code'},
			{data: 'name', name: 'name'},
			{data: 'type', name: 'type'},
			{data: 'action', name: 'action', orderable: false}
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

	//ajax to remove attribute
	$(document).on('click','#btnRemoveAttribute', function(){
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
			url: "{{route('attribute.remove')}}",
			data:{
				id: id
			},
			dataType: 'JSON',
			method: 'GET',
			success: function(result){
			if(result.remove === true){
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
				$('#tableAttribute').DataTable().ajax.reload();
			}
		})
		}
	})
})
//ajax to get option
$(document).on('click', '#btnOptions', function(){
	const id = $(this).data('id');
	const check = $(this).data('check');
	$('#modalAttributeOptions').modal('hide');
	$('#formAddAttributeOptions').html(``)
	$.ajax({
		url: "{{route('attribute.options')}}",
		data: {
			id: id
		},
		dataType: 'JSON',
		method  : "GET",
		success: function(result){
			$("#body-table-attributeOptions").html(``)
			if(result.data === null){
			$('#formAddAttributeOptions').html(`
						@csrf
						<div class="modal-body add-img">
							<div class="form-group">
								<label for="">Name Of Options Attribute</label>
								<input required type="text" name="name" class="form-control">
								<input required type="text" name="attribute_id" hidden value="${result.attribute_id}">
							</div>
						</div>
						<div class="modal-footer">
							<button class="btn btn-success" type="submit">Save</button>
						</div>`)
			$('#modalAddAttributeOptions').modal('show');
			}else{
			
			if(check === 1){
				$('#formAddAttributeOptions').html(`
						@csrf
						<div class="modal-body add-img">
							<div class="form-group">
								<label for="">Name Of Options Attribute</label>
								<input required type="text" name="name" class="form-control">
								<input required type="text" name="attribute_id" hidden value="${result.attribute_id}">
							</div>
						</div>
						<div class="modal-footer">
							<button class="btn btn-success" type="submit">Save</button>
						</div>`)
			$('#modalAddAttributeOptions').modal('show');
			}else{
			result.data.map(res=>{
					$('#body-table-attributeOptions').append(
						`<tr class="text-center">
							<td>${res.name}</td>
							<td class='text-center'>
								<button data-check='1' data-id='${res.id}' id='btnRemoveAttributeOptions' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></button>
								<button data-check='1' data-id='${res.attribute_id}' id='btnOptions' class='btn btn-success btn-sm'><i class='fas fa-plus'></i></button>
								<button data-check='1' data-id="${res.id}" id="btnEditAttributeOptions" class="btn btn-primary btn-sm" ><i class="fa fa-edit"></i></button>
							</td>
						</tr>`
					);
			})
			$('#modalAttributeOptions').modal('show');
			}
			
			}
		}
	})
})

	//ajax to add attribute options
	$(document).on('submit','#formAddAttributeOptions', function(e){
		e.preventDefault();
		const data = $('#formAddAttributeOptions').serialize();

		$.ajax({
			url: "{{route('attribute.addOptions')}}",
			method: 'POST',
			data: data,
			dataType: 'JSON',
			success: function(result){
		if(result.insert === true){
			Swal.fire(
			'Success',
			'Success Insert Data To Database',
			'success'
			).then(()=>{

			$('#body-table-attributeOptions').html(``)
			result.data.map(res=>{
			$('#body-table-attributeOptions').append(
				`<tr class="text-center">
					<td>${res.name}</td>
					<td class='text-center'>
						<button  data-id='${res.id}' id='btnRemoveAttributeOptions' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></button>
						<button data-check='1' data-id='${res.attribute_id}' id='btnOptions' class='btn btn-success btn-sm'><i class='fas fa-plus'></i></button>
						<button  data-id="${res.id}" id="btnEditAttributeOptions" class="btn btn-primary btn-sm" ><i class="fa fa-edit"></i></button>
					</td>
				</tr>`
			);
		})
		$('#modalAddAttributeOptions').modal('hide');
		$('#modalAttributeOptions').modal('show');
		})
		}else{
				Swal.fire(
				'Opsss..',
				'Fail Insert Data To Database',
				'error'
				).then(()=>{

					$('#formAddAttributeOptions').html(`
						@csrf
						<div class="modal-body add-img">
							<div class="form-group">
								<label for="">Name Of Options Attribute</label>
								<input required type="text" name="name" class="form-control">
								<input required type="text" name="attribute_id" hidden value="${result.attribute_id}">
							</div>
						</div>
						<div class="modal-footer">
							<button class="btn btn-success" type="submit">Save</button>
						</div>`)
					$('#modalAddAttributeOptions').modal('show');

				})
			}
			}
		})
	})
	//ajax fot remove attribute options
	$(document).on('click','#btnRemoveAttributeOptions', function(){
		const id = $(this).data('id');
		$.ajax({
			url: "{{route('attribute.removeOptions')}}",
			data: {id:id},
			method: 'GET',
			dataType: 'JSON',
			success: function(result){
				if(result.remove === false){
					Swal.fire(
					'Fail..!',
					`Fail To delete Image`,
					'error'
					)
				}else{
					$("#body-table-attributeOptions").html(``)
					result.data.map(res=>{
					$('#body-table-attributeOptions').append(
						`<tr class="text-center">
							<td>${res.name}</td>
							<td class='text-center'>
								<button  data-id='${res.id}' id='btnRemoveAttributeOptions' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></button>
								<button data-check='1' data-id='${res.attribute_id}' id='btnOptions' class='btn btn-success btn-sm'><i class='fas fa-plus'></i></button>
								<button  data-id="${res.id}" id="btnEditAttributeOptions" class="btn btn-primary btn-sm" ><i class="fa fa-edit"></i></button>
							</td>
						</tr>`
					);
				})
				}
			}
		})
	})
	//ajax to edit attr options
	$(document).on('click', '#btnEditAttributeOptions',function(){
		const id = $(this).data('id');
		$.ajax({
			url: "{{route('attribute.editOptions')}}",
			data:{
				_token: "{{csrf_token()}}",
				id:id
			},
			dataType: "JSON",
			method: "POST",
			success: function(result){
				$('#modalAttributeOptions').modal(`hide`)
				$('#formEditAttributeOptions').html(`
						@csrf
						<div class="modal-body Edit-img">
							<div class="form-group">
								<label for="">Name Of Options Attribute</label>
								<input required type="text" name="name" class="form-control" value="${result.name}">
								<input required type="text" name="id" hidden value="${result.id}">
							</div>
						</div>
						<div class="modal-footer">
							<button class="btn btn-success" type="submit">Edit</button>
						</div>`)
					$('#modalEditAttributeOptions').modal('show');
			}
		})
	})
	//ajax to edit data attr options
	$(document).on('submit','#formEditAttributeOptions', function(e){
		e.preventDefault()
		const data = $(this).serialize()+'&updated=true';
		$.ajax({
			url: "{{route('attribute.editOptions')}}",
			data:data,
			dataType: "JSON",
			method: "POST",
			success: function(result){
				$('#body-table-attributeOptions').html(``)
				if(result.edit === true){
					Swal.fire(
					'Success',
					'Success Edit Data From Database',
					'success'
					).then(()=>{
					result.data.map(res=>{
					$('#body-table-attributeOptions').append(
						`<tr class="text-center">
							<td>${res.name}</td>
							<td class='text-center'>
								<button  data-id='${res.id}' id='btnRemoveAttributeOptions' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></button>
								<button data-check='1' data-id='${res.attribute_id}' id='btnOptions' class='btn btn-success btn-sm'><i class='fas fa-plus'></i></button>
								<button  data-id="${res.id}" id="btnEditAttributeOptions" class="btn btn-primary btn-sm" ><i class="fa fa-edit"></i></button>
							</td>
						</tr>`
					);
					$('#modalEditAttributeOptions').modal('hide');
					$('#modalAttributeOptions').modal('show')
				})
			})
			}else{
				Swal.fire(
				'Success',
				'Fail Edit Data From Database',
				'success'
				).then(()=>{
					result.data.map(res=>{
					$('#body-table-attributeOptions').append(
						`<tr class="text-center">
							<td>${res.name}</td>
							<td class='text-center'>
								<button  data-id='${res.id}' id='btnRemoveAttributeOptions' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></button>
								<button data-check='1' data-id='${res.attribute_id}' id='btnOptions' class='btn btn-success btn-sm'><i class='fas fa-plus'></i></button>
								<button  data-id="${res.id}" id="btnEditAttributeOptions" class="btn btn-primary btn-sm" ><i class="fa fa-edit"></i></button>
							</td>
						</tr>`
					);
					$('#modalEditAttributeOptions').modal('hide');
					$('#modalAttributeOptions').modal('show')
				})
			})
			}
			}
		})
	})

	})
</script>

@endsection