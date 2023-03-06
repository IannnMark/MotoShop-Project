@extends('layouts.master')
@section('content')
<div class="row">
        <div class="col-md-8 col-md-offset-2">
        <h1><i class="fa fa-user-circle-o" aria-hidden="true">User Profile: {{Auth::user()->name}}</i></h1>
        
            @foreach($customers as $customers)
            <div class="container">
            <h3><img src="{{ asset('img_path/'.$customers->cust_img)}}" width = "120px" height="120px"></h3>
            <h3><b>First Name:</b>{{$customers->fname}}</h3>
            <h3><b>Last Name:</b>{{$customers->lname}}</h3>
            <h3><b>Phone:</b>{{$customers->phone}}</h3>
            <h3><b>Address:</b>{{$customers->address}}</h3>
            <h3><b>Town:</b>{{$customers->town}}</h3>
            <h3><b>City:</b>{{$customers->city}}</h3>


            
            <h2>Your Motors</h2>
            <table class="table">
            <thead>
                <tr class="table-warning">
                    <td>Motor ID</td>
                    <td>Brand</td>
                    <td>Model</td>
                    <td>Image</td>
                </tr>
            </thead>
            <tbody>
            @foreach($customers->motors as $motor)
            <tr>
                <td>{{$motor->id}}</td>
                <td>{{$motor->brand}}</td>
                <td>{{$motor->model}}</td>
                <td><img src="{{ asset('img_path/'.$motor->motor_img)}}" width = "60px" height="60px"></td>
            </tr>
            @endforeach
            </tbody>
            </table>
        @endforeach

        
          <div class="col col-md-6">
                <a href="{{ route('motors.create')}}" class = "btn btn-primary btn-sm">Enter My Motor's Information</a>
                </div>

         <div class="col col-md-6">
        <a href="{{ route('customers.edit', $customers->id)}}" class = "btn btn-primary btn-sm">Update My Information</a>
        </div>

</div>
</div>
            
@endsection