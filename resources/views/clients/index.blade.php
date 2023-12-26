@extends('layouts.app')

@section('content')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="">
                Create client
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Clients list</div>

        <div class="card-body">
            {{-- @if (session('status'))
                <div class="alert alert-danger" role="alert">
                    {{ session('status') }}

                    <h1>Kosom EL cc</h1>
                </div>
            @endif --}}

            <table class="table table-responsive-sm table-striped">
                <thead>
                <tr>
                    <th>Company</th>
                    <th>Phone Number</th>
                    <th>Address</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($clients as $client)
                    <tr>
                        <td>{{ $client->name }}</td>
                        <td>{{ $client->phone_number }}</td>
                        <td>{{ $client->address }}</td>
                        <td>
                            <a class="btn btn-xs btn-info" href="{{route('clients.edit', $client) }}">
                                Edit
                            </a>
                            @can('delete' , $client)
                                <form action="{{route('clients.destroy' , $client)}}" method="POST" onsubmit="return confirm('Are your sure?');" style="display: inline-block;">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                </form>
                            @endcan
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            
        </div>
    </div>

@endsection
