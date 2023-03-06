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
    Update Motor's Data
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
      <form method="post" action="{{ route('motors.update', $motors->id) }}" enctype ="multipart/form-data">

          <div class="form-group">
          @csrf 
              @method('PUT')
              <label for="brand"><i class="fa fa-paw" aria-hidden="true"></i>Brand</label>
              <input type="text" class="form-control" name="brand" value="{{ $motors->brand }}"/>
          </div>


          <div class="form-group">
            <label for="model"><i class="fa fa-paw" aria-hidden="true"></i>Model</label>
              <input type="text" class="form-control" name="model" value="{{ $motors->model }}"/>
          </div>


          <div class="form-group">
          <label for="image" class="control-label"><i class="fa-solid fa-photo-film"></i>Photo</label>
          <input type="file" class="form-control" id="id" name="motor_img" value="{{$motors->motor_img}}"/>
           @if($errors->has('motor_img'))
           <small>{{ $errors->first('motor_img') }}</small>
           @endif
          </div>

          <button type="submit" class="btn btn-block btn-danger">Update</button>
      </form>
  </div>
</div>
@endsection

