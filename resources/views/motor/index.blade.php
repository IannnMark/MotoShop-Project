@extends('layouts.master')
@section('content')
<style>
  .push-top {
    margin-top: 50px;
  }
</style>
<div class="push-top">
  @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}  
    </div><br />
  @endif
 
  <table class="table">
    <thead>
        <tr class="table-warning">
          <td>ID</td>
          <td>Brand</td>
          <td>Model</td>
          <td>Owner</td>
          <td>Photo</td>
          <td class="text-center">Action</td>
        </tr>
    </thead>
    <tbody>
        @foreach($motors as $motors)
        <tr>
            <td>{{$motors->id}}</td>
            <td>{{$motors->brand}}</td>
            <td>{{$motors->model}}</td>
            <td>{{$pets->customer->fname}}</td>
            <td><img src="{{ asset('img_path/'.$motors->motor_img)}}" width = "80px" height="80px"></td>
            <td class="text-center">


            <a href="{{ route('motors.edit', $motors->id)}}" class = "btn btn-primary btn-sm">Edit</a>
            <form method="post" action="{{ route('motors.destroy', $motors->id) }}">
              @csrf
              <input type="hidden" name="_method" value="DELETE" />
              <button type="submit" class="btn btn-danger btn-sm">Delete</button>
            </td>
        </tr>
        @endforeach
    </tbody>
  </table>
<div>
@endsection