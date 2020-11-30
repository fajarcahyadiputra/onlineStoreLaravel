<div class="row">
    <div class="col-md-6">
        <div class="form-group">
        <select data-indexvariant="{{$indexVariant}}" data-indexparent="{{$indexParent}}" name="detail[{{$indexParent}}][attribute][{{$indexVariant}}][attribute_id]" id="attribute_id" class="form-control">
                <option value="" selected disabled hidden>Select Varian</option>
                @foreach($attribute as $at)
                    <option value="{{$at->id}}">{{$at->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-6" style="display: flex;">
        <div class="form-group">
            <select name="detail[{{$indexParent}}][attribute][{{$indexVariant}}][attribute_option_id]" id="attribute_option_id{{$indexParent}}{{$indexVariant}}" class="form-control">
                <option value="" selected disabled hidden>Select Varian Name</option>
                
            </select>
        </div>
        <button type="button" data-indexparent="{{$indexParent}}" data-indexvariant="{{$indexVariant}}" id="btn-remove-variant" style="height: 37px; " class="btn btn-danger"><i class="fas fa-minus-square"></i></button>
    </div>
</div>