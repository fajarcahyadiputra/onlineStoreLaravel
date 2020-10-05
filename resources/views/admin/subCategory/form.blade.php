@if(isset($category))

<form id="formEditCategory" method="POST">
	@csrf
	<div class="modal-body">
		<div class="form-group">
			<label for="categoryName">Category Name</label>
			<input required="" class="form-control" type="text" name="categoryName" value="{{$category->name}}">
			<input required="" hidden="" type="text" name="id" value="{{$category->id}}">
			<div class="messageName text-danger"></div>
		</div>
		<div class="form-group">
			<label for="slug">Slug</label>
			<input required="" class="form-control" type="text" name="slug" value="{{$category->slug}}">
			<div class="messageSlug text-danger"></div>
		</div>
		<div class="form-group">
			<label for="parent_id">Parent Id</label>
			<select class="form-control" name="parent_id" id="parent_id">
				<option  value="" disabled="" hidden="" selected="">Pilih Parent ID</option>
				@foreach($parentCategory as $pc)
				<option <?php echo ($pc->id === $category->parent_id)?'selected':'' ?> value="{{$pc->id}}">{{$pc->name}}</option>
				@endforeach
			</select>
		</div>
	</div>
	<div class="modal-footer">
		<button  type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-primary">Edit</button>
	</div>
</form>

@else

<form id="formAddCategory" method="POST">
	@csrf
	<div class="modal-body">
		<div class="form-group">
			<label for="categoryName">Category Name</label>
			<input required="" class="form-control" type="text" name="categoryName">
			<div class="messageName text-danger"></div>
		</div>
		<div class="form-group">
			<label for="slug">Slug</label>
			<input required="" class="form-control" type="text" name="slug">
			<div class="messageSlug text-danger"></div>
		</div>
		<div class="form-group">
			<label for="parent_id">Parent Id</label>
			<select class="form-control" name="parent_id" id="parent_id">
				<option  value="" disabled="" hidden="" selected="">Pilih Parent ID</option>
				@foreach($categoryAdd as $ct)
				<option value="{{$ct->id}}">{{$ct->name}}</option>
				@endforeach
			</select>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-primary">Save</button>
	</div>
</form>

@endif

