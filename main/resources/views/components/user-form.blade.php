
@if ($errors->any())
    @foreach ($errors->all() as $error)
        <div>
            <span class="badge bg-danger">
                {{$error}}                
            </span> 
        </div>
    @endforeach
@endif
<form action="{{ $action_url }}" method="POST">
    @csrf
    @if( isset($type) && $type == 'PUT')
        @method('PUT')
    @endif
    <div class="form-group">
        <label for="inputName">Name</label>
        <input name="name" type="name" class="form-control" 
            id="inputName" aria-describedby="nameHelp" placeholder="Enter name" value="{{ isset($data) ? $data['name'] : '' }}">
        <small id="nameHelp" class="form-text text-muted"></small>
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Email address</label>
        <input name="email" type="email" class="form-control" 
            id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" value="{{ isset($data) ? $data['email'] : '' }}">
        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
    </div>
    <div class="form-group">
        <label for="inputRole">Role</label>
        <select class="form-control" name="role_id" id="inputRole">
            @foreach ($roles as $role)
                <option value="{{ $role->id }}" @if( isset($data) && count($data->roles) && $data->roles()->first()->id == $role->id ) selected @endif >
                    {{ $role->name }}
                </option>
            @endforeach
        </select>
    </div>

    
    <button type="submit" class="btn btn-primary my-3">{{ $submit_text ?? 'Submit' }}</button>
</form>