@extends('layouts.admin')

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
                            <span class="caption-subject bold uppercase">{{isset($record) ? 'Edit' : 'Add'}} Category</span>
                        </div>
                        <div class="tools"> </div>
                    </div>
                    <div class="portlet-body">
                        <div class="row mt-20">
                            <div class="col-md-12 col-sm-6 col-xs-12">
                                
                                <div class="form-group form-md-line-input has-info">
                                        {{Form::select('parent_id', $parentCategoryList, isset($record->parent_id) ? $record->parent_id : '', ['class' => 'form-control', 
                                            'placeholder' => '-'])}}
                                        <label for="form_control_1">Parent Category</label>
                                        <span class="help-block"><small class="text-danger">{{ $errors->first('parent_id') }}</small></span>
                                </div>

                                <div class="form-group form-md-line-input form-group {{ $errors->has('category_name') ? ' has-error' : '' }}">
                                    <input type="text" class="form-control" id="form_control_1" name="category_name" 
                                           value="{{isset($record->category_name) ? $record->category_name : old('category_name')}}" placeholder="Enter category name">
                                    <label for="form_control_1">Category</label>
                                    <span class="help-block"><small class="text-danger">{{ $errors->first('category_name') }}</small></span>
                                </div>

                                <div class="form-group form-md-line-input {{ $errors->has('description') ? ' has-error' : '' }}">
                                    <textarea class="form-control" rows="10" name="description" placeholder="Enter description">{{ isset($record->description) ? $record->description : old('description')}}</textarea>
                                    <label for="form_control_1">Description</label>
                                    <span class="help-block"><small class="text-danger">{{ $errors->first('description') }}</small></span>
                                </div>

                                <div class="form-group">
                                    <div class="pull-right mt-40">
                                        <button type="submit" class="btn blue">Submit</button>
                                        <button type="button" class="btn default" onClick="location.href = '/admin/faq-categories'">Cancel</button>
                                    </div>
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