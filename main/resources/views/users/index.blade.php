@extends('layout', [
    'title' => ''
])


@section('content')
    <div class="table-wrapper">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-8"><h2> User <b>List</b></h2></div>
                
                <div class="col-md-4"></div>
                    <a href="{{ route('users.create') }}" class="btn btn-info add-new"><i class="fa fa-plus"></i> Add New</a>
                </div>

                <div class="col-sm-12">
                    <form method="GET" class="row" action="{{ route('users.index') }}">
                        <div class="col-md-3 mt-2">
                            <label>Name</label>
                            <input type="search" value="{{ request()->name }}" class="form-control rounded" name="name" 
                                placeholder="Name" aria-label="Search" aria-describedby="search-addon" />


                        </div>
                        <div class="col-md-3 mt-2">
                            <label>City</label>
                            <input type="search" value="{{ request()->city }}" class="form-control rounded" name="city" 
                              placeholder="City" aria-label="Search" aria-describedby="search-addon" />
                        </div>
                        <div class="col-md-3 mt-3">
                            <label for="">Order</label>
                            <select name="order-field" id="">
                                <option value="name">
                                    Name
                                </option>
                                <option value="city">
                                    City
                                </option>
                            </select>
                            <select name="name-order" id="">
                                <option value="asc">
                                    Ascending
                                </option>
                                <option value="desc">
                                    Descending
                                </option>
                            </select>
                        </div>


                        <div class="col-12">

                            <button type="submit" class="col-md-2 mt-2 mx-1 btn btn-outline-primary" value="any" name="action">Search</button>
    
                            <button type="submit" class="col-md-2 mt-2 mx-1 btn btn-outline-primary" value="match" name="action"> 
                                Tam Arama
                            </button>
                            <button type="submit" class="col-md-2 mt-2 mx-1 btn btn-outline-primary" value="pre-match" name="action"> 
                                Baştan Arama
                            </button>
                            <button type="submit" class="col-md-2 mt-2 mx-1 btn btn-outline-primary" value="post-match" name="action"> 
                                Sondan Arama
                            </button>
                        </div>
                        {{-- <div class="input-group">
                            <select name="city" id="">

                            </select>
                        </div> --}}
                    </form>
                </div>
            </div>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Role</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($users as $i => $user)
                    <tr>
                        <th scope="row">{{ $i+1 }}</th>
                        <td> {{ $user->normalized_name }} </td>
                        <td> {{ $user->email }}</td>
                        <td> {{ $user->roles()->first()->name }}</td>
                        <td>
                            <a  href="{{ route('users.index')}}"
                                class="add" title="" data-toggle="tooltip" data-original-title="Add">
                                <i class="material-icons">
                                    
                                </i>
                            </a>
                            @role('admin')
                                <a  href="{{ route('users.edit',['user' => $user->id])}}"
                                    class="edit" title="" data-toggle="tooltip" data-original-title="Edit">
                                    <i class="material-icons"></i>
                                </a>

                                <form method="POST" action="{{ route('users.destroy',['user' => $user->id])}}" style="display:contents;">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                            
                                        <button type="submit" class="btn text-danger" title="" data-toggle="tooltip" data-original-title="Delete">
                                            <i class="material-icons"></i>
                                        </button>
                                        {{-- <input type="submit" class="btn btn-danger delete-user" value="Delete user"> --}}
                                </form>
                            @endrole

                            <a  href="{{ route('users.addresses.index', ['user' => $user->id])}}"
                                class="" title="" data-toggle="tooltip" data-original-title="Address">
                                <i class="material-icons">receipt</i>
                            </a>

                        </td>
                    </tr>
                @endforeach


            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center">
        {!! $users->links() !!}
    </div>
@endsection

