@extends("base")
@section("content")
<!--**********************************
            Content body start
        ***********************************-->
<div class="content-body crm-main style-1">
    <div class="container">
        <div class="row">
            <div class="col text-end text-info">Welcome {{ Auth::user()->name }}, You are currently logged in <span class="text-primary">{{ Session::get('bname') }}</span> Branch!</div>
        </div>
    </div>
</div>
<!--**********************************
            Content body end
        ***********************************-->
@if(!Session::has('branch'))
<div class="modal fade" id="branchSelector" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            {{ html()->form('POST', route('user.branch.update'))->open() }}
            <div class="modal-header">
                <h5 class="modal-title">Select Branch</h5>
                <!--<button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>-->
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        {{ html()->select($name = 'branch', $value = $branches, NULL)->class('form-control')->placeholder('Select Branch')->required() }}
                        @error('branch')
                        <small class="text-danger">{{ $errors->first('branch') }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                {{ html()->a(route('logout'), 'Cancel') }}
                {{ html()->submit("Update Branch")->class("btn btn-submit btn-outline-primary") }}
            </div>
            {{ html()->form()->close() }}
        </div>
    </div>
</div>
@endif
@endsection