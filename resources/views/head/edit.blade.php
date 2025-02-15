@extends("base")
@section("content")
<div class="content-body">
    <div class="container">
        <div class="page-titles">
            <h5 class="dashboard_bar">Head</h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">
                        Home </a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('head.register') }}">Head</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Update</a></li>
            </ul>
        </div>
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card dz-card">
                    <div class="card-body">
                        <div class="basic-form">
                            {{ html()->form('POST', route('head.update', encrypt($head->id)))->open() }}
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label req">Head Name</label>
                                    {{ html()->text('name', $head->name)->class("form-control")->placeholder("Head Name") }}
                                    @error('name')
                                    <small class="text-danger">{{ $errors->first('name') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label req">Category</label>
                                    {{ html()->select($name = 'category', $value = array('income' => 'Income', 'expense' => 'Expense'), $head->category)->class('form-control single-select')->placeholder('Select') }}
                                    @error('category')
                                    <small class="text-danger">{{ $errors->first('category') }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col text-end">
                                    <a onClick="window.history.back()" class="btn btn-light btn-warning btn-link">Cancel</a>
                                    {{ html()->submit("Update Head")->class("btn btn-submit btn-outline-primary") }}
                                </div>
                            </div>
                            {{ html()->form()->close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection