
<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label for="weight">Weight</label>
            <input  type="number" step="0.1" name="detail[{{$indexDetail}}][weight]" class="form-control" id="weight">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="length">Length</label>
            <input  type="number" step="0.1" name="detail[{{$indexDetail}}][length]" class="form-control" id="length">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="width">Width</label>
            <input  type="number" step="0.1" name="detail[{{$indexDetail}}][width]" class="form-control" id="width">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="price">Price</label>
            <input required type="number" name="detail[{{$indexDetail}}][price]" class="form-control" id="price">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label for="height">Height</label>
            <input  type="number" step="0.1" name="detail[{{$indexDetail}}][height]" class="form-control" id="height">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="stok">Stok</label>
            <input required type="number" name="detail[{{$indexDetail}}][stok]" class="form-control" id="stok">
        </div>
    </div>
    <div class="col-md-6">

    <div class="variantForm{{$indexDetail}}">
            
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="attribute_id">Attribute</label>
                    <select data-indexvariant="1" data-indexparent="{{$indexDetail}}" name="detail[{{$indexDetail}}][attribute][1][attribute_id]" id="attribute_id" class="form-control">
                        <option value="" selected disabled hidden>Select Varian</option>
                        @foreach($attribute as $at)
                            <option value="{{$at->id}}">{{$at->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6" style="display: flex; align-items: center">
                <div class="form-group">
                    <label for="attribute_option_id">Attribute Name</label>
                    <select name="detail[{{$indexDetail}}][attribute][1][attribute_option_id]" id="attribute_option_id{{$indexDetail}}1" class="form-control">
                        <option value="" selected disabled hidden>Select Varian Name</option>
                        
                    </select>
                </div>
                <button type="button" data-parentindex="{{$indexDetail}}" id="btnAddVariantProduct" style="height: 40px; margin-top: 14px" class="btn btn-primary"><i class="fas fa-plus"></i></button>
            </div>
        </div>

    </div>
        
    </div>
</div>


