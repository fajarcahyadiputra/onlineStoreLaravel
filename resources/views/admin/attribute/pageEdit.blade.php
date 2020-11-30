@extends('admin.layout')
@section('title','Page Edit Attribute')

@section('content')

<div class="row">
	<div class="col-sm-12">
		<div class="card">
			<div class="card-header">
				<h3>Page To Edit Attribute</h3>
			</div>
			<div class="card-body">
				<form id="formAttribute" name="formAttribute">
					@csrf
					<div class="form-group">
						<label for="code">Code</label>
                    	<input required="" type="text" name="code" readonly="" class="form-control" id="code" value="{{$attribute->code}}">
                    	<input required="" type="text" name="id" hidden value="{{$attribute->id}}">
					</div>
					<div class="form-group">
						<label for="name">Name</label>
						<input min="3" readonly type="text" name="name" class="form-control" id="name" value="{{$attribute->name}}">
						<div class="messageName"></div>
					</div>
					<div class="form-group">
						<label for="type">Type</label>
						<input readonly type="text" name="type" class="form-control" value="{{$attribute->type}}">
                    </div>
                    <div class="form-group">
						<label for="isRequired">Is Required</label>
						<select required name="is_required" class="form-control" id="isRequired">
                            
							@foreach($booleanOptions as $index => $bool)
                            <option {{$attribute->is_required === $index?'selected':''}} value="{{$index}}">{{$bool}}</option>
                            @endforeach
						</select>
                    </div>
                    <div class="form-group">
						<label for="isUnique">Is Unique</label>
						<select required name="is_unique" class="form-control" id="isUnique">
                            
							@foreach($booleanOptions as $index => $bool)
                            <option {{$attribute->is_unique === $index?'selected':''}} value="{{$index}}">{{$bool}}</option>
                            @endforeach
						</select>
                    </div>
                    <div class="form-group">
						<label for="validation">Validation</label>
						<select required name="validation" class="form-control" id="validation">
                            
                            @foreach($validation as $index => $vl)
								<option {{$attribute->validation === $index?'selected':''}} value="{{$index}}">{{$vl}}</option>
							@endforeach
						</select>
                    </div>
                    <div class="alert alert-light" role="alert">
                        Configuration
                    </div>

                      <div class="form-group">
						<label for="configurable">Configurable</label>
						<select required name="is_configurable" class="form-control" id="configurable">
                            
                            @foreach($booleanOptions as $index => $bool)
								<option {{$attribute->is_configurable === $index?'selected':''}} value="{{$index}}">{{$bool}}</option>
							@endforeach
						</select>
                    </div>
                    <div class="form-group">
						<label for="filter">fillter</label>
						<select required name="is_filterable" class="form-control" id="filter">
                            
                            @foreach($booleanOptions as $index => $bool)
                            <option {{$attribute->is_filterable === $index?'selected':''}} value="{{$index}}">{{$bool}}</option>
                            @endforeach
						</select>
                    </div>
					<button  style="width: 100px" id="btnSubmit" type="submit" class="btn btn-success">Edit</button>
					<a style="width: 100px" href="{{URL::to('attribute')}}"  class="btn btn-warning">Back</a>
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
			$('#validation').select2({
				width: '100%',
				theme: 'bootstrap4',
				placeholder: 'Pilih Categories'
			});
		});
		//ajax for add data product
		$('#formAttribute').on('submit', function(e){
			e.preventDefault();
			const data = new  FormData(document.forms['formAttribute']);
			
			$.ajax({
				url: "{{route('attribute.editData')}}",
				type: 'POST',
				dataType: 'JSON',
				data: data,
				contentType: false,
				processData: false,
				async: true,
				cache: false,
				success: function(result){
					// console.log(result)
					if(result.insert === true){
						Swal.fire(
						'Success',
						'Success Insert Data To Database',
						'success'
						).then(()=>{
							document.location.href = "{{URL::to('attribute')}}";
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



