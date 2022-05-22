
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
        <label for="exampleInputName1">Name</label>
        <input name="name" type="text-area" class="form-control" 
            id="exampleInputName1" aria-describedby="nameHelp" placeholder="Enter name" value="{{ isset($data) ? $data['name'] : '' }}">
        <small id="nameHelp" class="form-text text-muted">We'll never share your name with anyone else.</small>
    </div>
    <div class="form-group">
        <label for="inputCity">City</label>
        {{-- @foreach (\App\Enum\NameCityEnum::cases() as $city)
            @dd($city->name)
        @endforeach --}}
        <select name="city" id="" class="form-control">
            @foreach (\App\Enum\AddressCityEnum::cases() as $city)
                <option value="{{ $city->value }}" @if( isset($data) && $data->city->value == $city->value ) selected @endif >
                    {{ $city->name }}
                </option>
            @endforeach
        </select>
        {{-- <input name="city" type="text" class="form-control" 
            id="inputCity" aria-describedby="cityHelp" placeholder="Enter city" value="{{ isset($data) ? $data['city'] : '' }}"> --}}
        <small id="cityHelp" class="form-text text-muted"></small>
    </div>
    <button type="submit" class="btn btn-primary my-3">{{ $submit_text ?? 'Submit' }}</button>
</form>