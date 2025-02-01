@extends('layout.master')

@section('title')
Edit Data Cast {{$cast->id}}
@endsection

@section('content')
<form action="/cast/{{$cast->id}}" method="POST">
  @csrf
  @method('PUT')
  <div class="form-group">
    <label for="id">ID</label>
    <input type="text" class="form-control" name="id" id="id" value="{{$cast->id}}" readonly>
    <br>
    <label for="name">Nama</label>
    <input type="text" class="form-control" name="name" id="name" value="{{$cast->name}}">
    @error('name')
        <div class="alert alert-danger">
            {{ $message }}
        </div>
    @enderror
  </div>
  <div class="form-group">
    <label for="age">Umur</label>
    <input type="number" class="form-control" name="age" id="age" value="{{$cast->age}}">
    @error('age')
      <div class="alert alert-danger">
          {{ $message }}
      </div>
    @enderror
  </div>
  <div class="form-group">
    <label for="bio">Bio</label>
    <textarea class="form-control" name="bio" id="bio" rows="3">{{$cast->bio}}</textarea>
    @error('bio')
      <div class="alert alert-danger">
          {{ $message }}
      </div>
    @enderror
  </div>
  <button type="submit" class="btn btn-primary">Edit</button>
</form>
@endsection