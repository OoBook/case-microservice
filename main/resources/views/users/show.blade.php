@extends('layout', [
    'title' => ''
])


@section('content')
    <div class="table-wrapper">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-8"><h2> <b>User Details</b></h2></div>
                <div class="col-sm-4">
                    {{-- <button type="button" class="btn btn-info add-new"><i class="fa fa-plus"></i> Add New</button> --}}
                </div>
            </div>
        </div>

        <table>
            <tbody>
                @foreach ($user->toArray() as $key => $value)
                    <tr> 
                        <th>{{ $key }} </th>
                        <td>{{ $value }} </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="card shadow border-0 mb-5">
            <div class="card-body p-5">
                <h2 class="h4 mb-1">User Libraries</h2>
                <p class="small text-muted font-italic mb-4"></p>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">City</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($user->libraries as $i => $library)
                            <tr>
                                <th scope="row">{{ $i+1 }}</th>
                                <td> {{ $library->name }} </td>
                                <td> {{ $library->city->value }}</td>
                            </tr>
                        
                        @endforeach
        
        
                    </tbody>
                </table>
                <ul class="list-group">

                </ul>
            </div>
        </div>

    </div>
@endsection