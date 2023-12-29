@extends('layouts.app')

@section('content')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('projects.create') }}">
                Create project
            </a>
        </div>
    </div>

    <div class="card-body">
        <div class="d-flex justify-content-end">
            <form action="{{ route('projects.index') }}" method="GET">
                <div class="form-group">
                    <label for="deleted" class="col-form-label">Show deleted:</label>
                        <select class="form-control" name="deleted" id="deleted" onchange="this.form.submit()">
                            <option value="false" {{ request('deleted') == 'false' ? 'selected' : '' }}>No</option>
                            <option value="true" {{ request('deleted') == 'true' ? 'selected' : '' }}>Yes</option>
                        </select>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-header">Projects list</div>

        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-danger" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <div class="d-flex justify-content-end">
                <form action="{{ route('projects.index') }}" method="GET">
                    <div class="form-group row">
                        <label for="status" class="col-form-label">Status:</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="status" id="status" onchange="this.form.submit()">
                                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>
                                    All
                                </option>
                                @foreach(App\Models\Project::STATUS as $status)
                                    <option
                                        value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
            </div>

            <table class="table table-responsive-sm table-striped">
                <thead>
                <tr>
                    <th>Title</th>
                    <th>Assigned to</th>
                    <th>Client</th>
                    <th>Deadline</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($projects as $project)
                    <tr>
                        <td><a href="{{ route('projects.show', $project) }}">{{ $project->title }}</a></td>
                        <td>@foreach ($project->users as $user )
                            {{$user->name}}
                        @endforeach</td>
                        <td>{{ $project->client->name }}</td>
                        <td>{{ $project->deadline }}</td>
                        <td>{{ $project->status }}</td>
                        <td>
                            <a class="btn btn-sm btn-info" href="{{ route('projects.edit', $project) }}">
                                Edit
                            </a>
                            @can('delete' , $project)
                                <form action="{{ route('projects.destroy', $project) }}" method="POST"
                                    onsubmit="return confirm('Are your sure?');" style="display: inline-block;">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-sm btn-danger" value="Delete">
                                </form>
                            @endcan
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{-- {{ $projects->withQueryString()->links() }} --}}
        </div>
    </div>

@endsection
