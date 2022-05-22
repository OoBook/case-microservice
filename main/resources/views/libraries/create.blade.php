@extends('layout', [
    'title' => ''
])


@section('content')
    <div class="table-wrapper">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-8"><h2> <b>Library Store</b></h2></div>
                <div class="col-sm-4">
                    {{-- <button type="button" class="btn btn-info add-new"><i class="fa fa-plus"></i> Add New</button> --}}
                </div>
            </div>
        </div>

        @include('components.library-form', [
            'action_url' => route('libraries.store'),
            'submit_text' => 'CREATE',
        ])

    </div>
@endsection