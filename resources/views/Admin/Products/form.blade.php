@extends('layouts.admin')

@push('styles')
<style>
    
    input[type="file"] {
    display: block;
    }
    .imageThumb {
    max-height: 75px;
    border: 2px solid;
    padding: 1px;
    cursor: pointer;
    }
    .pip {
    display: inline-block;
    margin: 10px 10px 0 0;
    }
    .remove {
    display: block;
    background: #444;
    border: 1px solid black;
    color: white;
    text-align: center;
    cursor: pointer;
    }
    .remove:hover {
    background: white;
    color: black;
    }
</style>

@endpush

@section('content')
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <!-- END PAGE HEADER-->
        <div class="clearfix"></div>
        <div class="row">
            @include('Admin/partials/message')
        </div>
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet light ">
                     {{ Form::open(['method' => 'POST', 'files' => true]) }}
                    <div class="portlet-title fs-16">
                        <div class="caption font-dark">
                            <i class=icon-grid font-dark"></i>
                            <span class="caption-subject bold uppercase">{{isset($record) ? 'Edit' : 'Add'}} Product</span>
                        </div>
                        <div class="tools"> </div>
                    </div>
                    <div class="portlet-body">
                        <div class="row mt-20">
                            <div class="col-md-12 col-sm-6 col-xs-12">
                                <div class="form-group form-md-line-input has-info">
                                        {{Form::select('category_id', $allCategories, isset($record->category_id) ? $record->category_id : '', ['class' => 'form-control', 
                                            'placeholder' => 'Select Category'])}}
                                        <label for="form_control_1">Category</label>
                                        <span class="help-block"><small class="text-danger">{{ $errors->first('category_id') }}</small></span>
                                </div>

                                <div class="form-group form-md-line-input has-info">
                                        {{Form::select('brand_id', $allBrands, isset($record->brand_id) ? $record->brand_id : '', ['class' => 'form-control', 
                                            'placeholder' => 'Select Brand'])}}
                                        <label for="form_control_1">Brand</label>
                                        <span class="help-block"><small class="text-danger">{{ $errors->first('brand_id') }}</small></span>
                                </div>

                                <div class="form-group form-md-line-input form-group {{ $errors->has('product_name') ? ' has-error' : '' }}">
                                    <input type="text" class="form-control" id="form_control_1" name="product_name" 
                                           value="{{isset($record->product_name) ? $record->product_name : old('brand_name')}}" placeholder="Enter product name">
                                    <label for="form_control_1">Product Name</label>
                                    <span class="help-block"><small class="text-danger">{{ $errors->first('product_name') }}</small></span>
                                </div>

                                <div class="form-group form-md-line-input form-group {{ $errors->has('price') ? ' has-error' : '' }}">
                                    <input type="number" class="form-control" id="form_control_1" name="price" 
                                           value="{{isset($record->price) ? $record->price : old('price')}}" placeholder="Enter product price">
                                    <label for="form_control_1">Product Price</label>
                                    <span class="help-block"><small class="text-danger">{{ $errors->first('price') }}</small></span>
                                </div>

                                <div class="form-group form-md-line-input {{ $errors->has('description') ? ' has-error' : '' }}">
                                        <textarea class="form-control" rows="10" name="description" placeholder="Enter description">{{ isset($record->description) ? $record->description : old('description')}}</textarea>
                                        <label for="form_control_1">Description</label>
                                        <span class="help-block"><small class="text-danger">{{ $errors->first('description') }}</small></span>
                                </div>

                                <div class="form-group form-md-line-input has-info">
                                    <input type="text" class="form-control" readonly  name="xs" style="width: 3% ;float:left;margin-left:4%"
                                    value="{{isset($record->xs) ? $record->xs : 'xs'}}" placeholder="Enter quantity">
                                    <label for="form_control_1">Quantity</label>
                                    <input type="number" class="form-control"  name="xs_quantity" style="width: 11% ;float:left;margin-left:4%"
                                    value="{{isset($record->ProductSpecification[0]->xs_quantity) ? $record->ProductSpecification[0]->xs_quantity : old('xs_quantity')}}" placeholder="Enter quantity">
                                    
                                </div>
                                
                                <div class="form-group form-md-line-input has-info">
                                    <input type="text" class="form-control" readonly  name="s" style="width: 3% ;float:left;margin-left:4%"
                                    value="{{isset($record->s) ? $record->s : 's'}}" placeholder="Enter quantity">
                                    <input type="number" class="form-control"  name="s_quantity" style="width: 11% ;float:left;margin-left:4%"
                                    value="{{isset($record->ProductSpecification[0]->s_quantity) ? $record->ProductSpecification[0]->s_quantity : old('s_quantity')}}" placeholder="Enter quantity">
                                    
                                </div>

                                <div class="form-group form-md-line-input has-info">
                                    <input type="text" class="form-control" readonly  name="m" style="width: 3% ;float:left;margin-left:4%"
                                    value="{{isset($record->m) ? $record->xs : 'm'}}" placeholder="Enter quantity">
                                    <input type="number" class="form-control"  name="m_quantity" style="width: 11% ;float:left;margin-left:4%"
                                    value="{{isset($record->ProductSpecification[0]->m_quantity) ? $record->ProductSpecification[0]->m_quantity : old('m_quantity')}}" placeholder="Enter quantity">
                                    
                                </div>

                                <div class="form-group form-md-line-input has-info">
                                    <input type="text" class="form-control" readonly  name="l" style="width: 3% ;float:left;margin-left:4%"
                                    value="{{isset($record->l) ? $record->l : 'l'}}" placeholder="Enter quantity">
                                    <input type="number" class="form-control"  name="l_quantity" style="width: 11% ;float:left;margin-left:4%"
                                    value="{{isset($record->ProductSpecification[0]->l_quantity) ? $record->ProductSpecification[0]->l_quantity : old('xs_quantity')}}" placeholder="Enter quantity">
                                    
                                </div>

                                <div class="form-group form-md-line-input has-info">
                                    <input type="text" class="form-control" readonly  name="xl" style="width: 3% ;float:left;margin-left:4%"
                                    value="{{isset($record->xl) ? $record->x : 'xl'}}" placeholder="Enter quantity">
                                    <input type="number" class="form-control"  name="xl_quantity" style="width: 11% ;float:left;margin-left:4%"
                                    value="{{isset($record->ProductSpecification[0]->xl_quantity) ? $record->ProductSpecification[0]->xl_quantity : old('xl_quantity')}}" placeholder="Enter quantity">
                                    
                                </div>

                                <div class="form-group form-md-line-input has-info">
                                    <input type="text" class="form-control" readonly  name="xxl" style="width: 3% ;float:left;margin-left:4%"
                                    value="{{isset($record->xxl) ? $record->xxl : 'xxl'}}" placeholder="Enter quantity">
                                    <input type="number" class="form-control"  name="xxl_quantity" style="width: 11% ;float:left;margin-left:4%"
                                    value="{{isset($record->ProductSpecification[0]->xxl_quantity) ? $record->ProductSpecification[0]->xxl_quantity : old('xxl_quantity')}}" placeholder="Enter quantity">
                                    
                                </div>

                                <div class="field" align="left">
                                    <span>
                                        <h3>Upload your images</h3>
                                        <input type="file" id="files" name="images[]" multiple />
                                    </span>
                                </div>


                                <div class="form-group form-md-checkboxes">
                                    <div class="md-checkbox-list">
                                        <div class="md-checkbox">
                                            {{Form::checkbox('is_active', 1, isset($record->is_active) ? $record->is_active : true, ['class' => 'BoolActive', 'id' => 'checkbox1'])}}
                                            <input type="checkbox" id="checkbox1" class="md-check">
                                            <label for="checkbox1">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span> Active </label>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="pull-right mt-40">
                                        <button type="submit" class="btn blue">Submit</button>
                                        <button type="button" class="btn default" onClick="location.href = '/admin/brands'">Cancel</button>
                                    </div>
                                </div>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
    </div>
    <!-- END CONTENT BODY -->
</div>
@endsection
@push('view-scripts')
<script type="text/javascript">
    $(document).ready(function() {
  if (window.File && window.FileList && window.FileReader) {
    $("#files").on("change", function(e) {
      var files = e.target.files,
        filesLength = files.length;
      for (var i = 0; i < filesLength; i++) {
        var f = files[i]
        var fileReader = new FileReader();
        fileReader.onload = (function(e) {
          var file = e.target;
          $("<span class=\"pip\">" +
            "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
            "<br/><span class=\"remove\">Remove image</span>" +
            "</span>").insertAfter("#files");
          $(".remove").click(function(){
            $(this).parent(".pip").remove();
          });
          
          // Old code here
          /*$("<img></img>", {
            class: "imageThumb",
            src: e.target.result,
            title: file.name + " | Click to remove"
          }).insertAfter("#files").click(function(){$(this).remove();});*/
          
        });
        fileReader.readAsDataURL(f);
      }
    });
  } else {
    alert("Your browser doesn't support to File API")
  }
});



</script>

@endpush