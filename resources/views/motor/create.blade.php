@extends('layouts.master')
@section('content')
<style>
    .container {
      max-width: 450px;
    }
    .push-top {
      margin-top: 50px;
    }
</style>



<div class="card push-top">
  <div class="card-header">
   <h3> Add New Motor: </h3>
   {{-- <h5>Register to Acme Pet Clinic</h5> --}}
  </div>
  <div class="card-body">
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div><br />
    @endif
    
      <form method="post" action="{{ route('motors.store') }}" enctype ="multipart/form-data">
        @csrf
          <div class="form-group">
              @csrf
              <label for="brand"><i class="fas fa-motorcycle" aria-hidden="true"></i>Brand</label>
              <input type="text" class="form-control" name="brand" id="brand"/>
           </div>
    
          <div class="form-group">
              <label for="model"><i class="fas fa-motorcycle" aria-hidden="true"></i>Model</label>
              <input type="text" class="form-control" name="model" id="model"/>
          </div>

          <div class="form-group">
          <label for="image" class="control-label"><i class="fa-solid fa-photo-film"></i>Your Motor's Photo</label>
          <input type="file" class="form-control" id="motor_img" name="motor_img">
          @error('images')
          <div class="alert alert-danger">{{ $message }}</div>
          @enderror
   
  </div>
          <button type="submit" class="btn btn-block btn-danger">Save</button>
      </form>
  </div>

</div>
@endsection