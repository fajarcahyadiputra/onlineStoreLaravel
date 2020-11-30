@extends('admin.layout')
@section('title','Page Add Attribute')

@section('content')

<div class="row">
	<div class="col-sm-12">
		<div class="card">
			<div class="card-header">
				<h3>Page To Add Attribute</h3>
			</div>
			<div class="card-body">
				<form id="formAttribute" name="formAttribute">
					@csrf
					<div class="form-group">
						<label for="code">Code</label>
                    	<input required="" type="text" name="code" readonly="" class="form-control" id="code" value="{{$code}}">
					</div>
					<div class="form-group">
						<label for="name">Name</label>
						<input min="3" type="text" name="name" class="form-control" id="name">
						<div class="messageName"></div>
					</div>
					<div class="form-group">
						<label for="type">Type</label>
						<select required name="type" class="form-control" id="type">
                            <option value="" disabled hidden selected>Select Type</option>
							@foreach($type as $index => $tp)
								<option value="{{$index}}">{{$tp}}</option>
							@endforeach
						</select>
                    </div>
                    <div class="form-group">
						<label for="isRequired">Is Required</label>
						<select required name="is_required" class="form-control" id="isRequired">
                            <option value="" disabled hidden selected>Select Is Required</option>
							@foreach($booleanOptions as $index => $bool)
                            <option value="{{$index}}">{{$bool}}</option>
                            @endforeach
						</select>
                    </div>
                    <div class="form-group">
						<label for="isUnique">Is Unique</label>
						<select required name="is_unique" class="form-control" id="isUnique">
                            <option value="" disabled hidden selected>Select Is Unique</option>
							@foreach($booleanOptions as $index => $bool)
                            <option value="{{$index}}">{{$bool}}</option>
                            @endforeach
						</select>
                    </div>
                    <div class="form-group">
						<label for="validation">Validation</label>
						<select required name="validation" class="form-control" id="validation">
                            <option value="" disabled hidden selected>Select Validation</option>
                            @foreach($validation as $index => $vl)
								<option value="{{$index}}">{{$vl}}</option>
							@endforeach
						</select>
                    </div>
                    <div class="alert alert-light" role="alert">
                        Configuration
                    </div>

                      <div class="form-group">
						<label for="configurable">Configurable</label>
						<select required name="is_configurable" class="form-control" id="configurable">
                            <option value="" disabled hidden selected>Use To Configurable Product</option>
                            @foreach($booleanOptions as $index => $bool)
								<option value="{{$index}}">{{$bool}}</option>
							@endforeach
						</select>
                    </div>
                    <div class="form-group">
						<label for="filter">fillter</label>
						<select required name="is_filterable" class="form-control" id="filter">
                            <option value="" disabled hidden selected>Use To Fillter Product</option>
                            @foreach($booleanOptions as $index => $bool)
                            <option value="{{$index}}">{{$bool}}</option>
                            @endforeach
						</select>
                    </div>
					<button  style="width: 100px" id="btnSubmit" type="submit" class="btn btn-success">Add</button>
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
			$('#type').select2({
				width: '100%',
				theme: 'bootstrap4',
				placeholder: 'Pilih Categories'
			});
			$('#validation').select2({
				width: '100%',
				theme: 'bootstrap4',
				placeholder: 'Pilih Categories'
			});
		});
		//ajax validasi for unique name
		$(document).on('keyup','#name', function(){
			const name = $(this).val();

			$.ajax({
				url: "{{route('attribute.pageAdd')}}",
				type: 'GET',
				data:{
					uniqueName: true,
					name 	  : name
				},
				dataType: 'json',
				success:function(result){
					$('.messageName').html(``)
					$('#btnSubmit').removeAttr('disabled','disabled')
					if(result.check === true){
						$('.messageName').html(`<span class='text-danger'>Name Already Use</span>`)
						$('#btnSubmit').attr('disabled','disabled')
					}else{
						$('.messageName').html(``)
						$('#btnSubmit').removeAttr('disabled','disabled')
					}
				}
			})
		})
		//ajax for add data product
		$('#formAttribute').on('submit', function(e){
			e.preventDefault();
			const data = new  FormData(document.forms['formAttribute']);
			
			$.ajax({
				url: "{{route('attribute.addData')}}",
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



