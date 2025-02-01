@extends('layout.master')

@section('title')
Show Cast {{$cast->id}}
@endsection

@section('content')
<div>
  <div class="form-group">
    <label for="id">ID</label>
    <input type="text" class="form-control" name="id" id="id" value="{{$cast->id}}" readonly>
  </div>
  <div class="form-group">
      <label for="name">Nama</label>
      <input type="text" class="form-control" name="name" id="name" value="{{$cast->name}}" readonly>
  </div>
  <div class="form-group">
      <label for="age">Umur</label>
      <input type="number" class="form-control" name="age" id="age" value="{{$cast->age}}" readonly>
  </div>
  <div class="form-group">
      <label for="bio">Bio</label>
      <textarea class="form-control" name="bio" id="bio" rows="3" readonly>{{$cast->bio}}</textarea>
  </div>
  <a href="/cast" class="btn btn-primary">Kembali ke Daftar Cast</a>
</div>
@endsection