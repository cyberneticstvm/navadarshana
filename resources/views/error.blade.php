@extends("base")
@section("content")
<div class="content-body">
    <div class="container">
        <div class="page-titles">
            <h5 class="dashboard_bar">Error</h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">
                        Home </a>
                </li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Error</a></li>
            </ul>
        </div>
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card dz-card">
                    <div class="card-body text-center">
                        <img src="{{ asset('/assets/images/sad-face.svg') }}" width="10%" />
                        <p class="text-danger text-center">{{ $exception->getMessage() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection