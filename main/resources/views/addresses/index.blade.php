@extends('layout', [
    'title' => ''
])

@section('content')
    <div class="table-wrapper">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-8"><h2> <strong>{{$user->normalized_name}}</strong> Address <b>List</b></h2></div>
                
                <div class="col-md-4"></div>
                    <a href="{{ route('users.addresses.create', ['user' => $user->id]) }}" class="btn btn-info add-new"><i class="fa fa-plus"></i> Add New</a>
                </div>

            </div>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">City</th>
                <th scope="col">Address</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($addresses as $i => $address)
                    <tr>
                        <th scope="row">{{ $i+1 }}</th>
                        <td> {{ $address->city->value }} </td>
                        <td> {{ $address->address }}</td>
                        <td>
                            <a  href="{{ route('users.addresses.index', ['user'=> $user->id])}}"
                                class="add" title="" data-toggle="tooltip" data-original-title="Add">
                                <i class="material-icons">
                                    
                                </i>
                            </a>
                            <a  href="{{ route('users.addresses.edit',['user' => $user->id, 'address' => $address->id])}}"
                                class="edit" title="" data-toggle="tooltip" data-original-title="Edit">
                                <i class="material-icons"></i>
                            </a>

                            <form method="POST" action="{{ route('users.addresses.destroy',['user' => $user->id, 'address' => $address->id])}}" style="display:contents;">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                        
                                    <button type="submit" class="btn text-danger" title="" data-toggle="tooltip" data-original-title="Delete">
                                        <i class="material-icons"></i>
                                    </button>
                                    {{-- <input type="submit" class="btn btn-danger delete-user" value="Delete user"> --}}
                            </form>

                        </td>
                    </tr>
                @endforeach


            </tbody>
        </table>
    </div>

@endsection

