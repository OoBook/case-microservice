@extends('layout', [
    'title' => ''
])


@section('content')
    <div class="table-wrapper">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-8"><h2> <b>User Details</b></h2></div>
                <div class="col-sm-4">
                    <button type="button" class="btn btn-info add-new"><i class="fa fa-plus"></i> Add New</button>
                </div>
            </div>
        </div>

        @include('components.user-form', [
            'action_url' => route('users.update', ['user' => $user->id]),
            'type' => 'PUT',
            'submit_text' => 'UPDATE',
            'data' => $user,
            'roles' => $roles,
        ])

        
        @php
            $ids = $user->libraries->pluck('id')->toArray();
        @endphp
        <div class="card shadow border-0 mb-5">
            <div class="card-body p-5">
                <h2 class="h4 mb-1">Choose from Libraries</h2>
                <p class="small text-muted font-italic mb-4"></p>
                    <form action="{{ route('users.libraries.sync', ['user' => $user->id]) }}" method="POST">
                        @csrf
                        @foreach ($libraries as $library)
                            <div class="form-check">
                                <input name="libraries[{{$library->id}}]" class="form-check-input" type="checkbox" value="true" id="flexCheck{{$library->id}}"
                                    @if(  in_array($library->id,$ids) ) checked @endif
                                     >
                                <label class="form-check-label" for="flexCheck{{$library->id}}">
                                    {{$library->name }} | {{ $library->city->value}}
                                </label>
                            </div>
                        @endforeach
                        <button type="submit" class="btn btn-primary my-3">Update</button>
                    </form>

            </div>
        </div>

    </div>
@endsection

