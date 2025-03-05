@extends("base")
@section("content")
<div class="content-body">
    <div class="container">
        <div class="page-titles">
            <h5 class="dashboard_bar">Class Schedule - <a href="{{ route('class.schedule.create') }}">Create New</a></h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">
                        Home </a>
                </li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Class Schedule</a></li>
            </ul>
        </div>
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card dz-card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="display table" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>SL No</th>
                                        <th>Batch</th>
                                        <th>Faculty</th>
                                        <th>Syllabus</th>
                                        <th>Date</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Status</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($schedules as $key => $schedule)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $schedule?->batch?->name }}</td>
                                        <td>{{ $schedule?->faculty?->name }}</td>
                                        <td>{{ $schedule?->syllabus?->name }}</td>
                                        <td>{{ $schedule?->date->format('d.M.Y') }}</td>
                                        <td>{{ $schedule?->from_time->format('h:i a') }}</td>
                                        <td>{{ $schedule?->to_time->format('h:i a') }}</td>
                                        <td>{!! $schedule->status() !!}</td>
                                        <td><span class="badge badge-lg light badge-warning"><a href="{{ route('class.schedule.edit', encrypt($schedule->id)) }}" class="text-warning">Edit</a></span></td>
                                        <td><span class="badge badge-lg light badge-danger"><a href="{{ route('class.schedule.delete', encrypt($schedule->id)) }}" class="text-danger dlt">Delete</a></span></td>
                                    </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection