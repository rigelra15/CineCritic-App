@extends('layout.master')

@section('title')
Daftar Cast
@endsection

@section('content')
<div>
  <a href="/cast/create" class="btn btn-primary">Tambah</a>
    <table class="table">
        <thead class="thead-light">
          <tr>
            <th scope="col">#</th>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Age</th>
            <th scope="col">Bio</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
            @forelse ($cast as $key=>$value)
                <tr>
                    <td>{{$key + 1}}</th>
                    <td>{{$value->id}}</td>
                    <td>{{$value->name}}</td>
                    <td>{{$value->age}}</td>
                    <td>{{$value->bio}}</td>
                    <td>
                        <div class="btn-group" role="group" style="display: flex; justify-content: center; align-items: center; gap: 5px;">
                            <a href="/cast/{{$value->id}}" class="btn btn-info">Show</a>
                            <a href="/cast/{{$value->id}}/edit" class="btn btn-primary">Edit</a>
                            <form action="/cast/{{$value->id}}" method="POST" onsubmit="return confirm('are you sure delete data?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr colspan="3">
                    <td>No data</td>
                </tr>  
            @endforelse              
        </tbody>
    </table>
</div>
@endsection