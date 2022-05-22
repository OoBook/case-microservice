@extends('layout', [
    'title' => ''
])


@section('content')
    <div class="table-wrapper">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-8"><h2> Library <b>List</b></h2></div>
                
                <div class="col-md-4"></div>
                    <a href="{{ route('libraries.create') }}" class="btn btn-info add-new"><i class="fa fa-plus"></i> Add New</a>
                </div>

            </div>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">City</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($libraries as $i => $library)
                    <tr>
                        <th scope="row">{{ $i+1 }}</th>
                        <td> {{ $library->name }}</td>
                        <td> {{ $library->city->value }} </td>
                        <td>
                            <a  href="{{ route('libraries.index')}}"
                                class="add" title="" data-toggle="tooltip" data-original-title="Add">
                                <i class="material-icons">
                                    
                                </i>
                            </a>
                            @role('admin')
                                <a  href="{{ route('libraries.edit',['library' => $library->id])}}"
                                    class="edit" title="" data-toggle="tooltip" data-original-title="Edit">
                                    <i class="material-icons"></i>
                                </a>

                                <form method="POST" action="{{ route('libraries.destroy',['library' => $library->id])}}" style="display:contents;">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                            
                                        <button type="submit" class="btn text-danger" title="" data-toggle="tooltip" data-original-title="Delete">
                                            <i class="material-icons"></i>
                                        </button>
                                        {{-- <input type="submit" class="btn btn-danger delete-library" value="Delete library"> --}}
                                </form>
                            @endrole

                        </td>
                    </tr>
                @endforeach


            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center">
        {!! $libraries->links() !!}
    </div>
@endsection

