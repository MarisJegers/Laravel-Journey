@extends('layouts.app')
 
@section('content')
       
    <div class="py-12">
      <div class="container">
        <div class="row">
          
          <!-- datu pievienošanas forma lapas labajā pusē -->
          <div class="col-md-8">
            <div class="card">
              <div class="card-header"><h4>Labot darbinieka datus</h4></div>
                <div class="card-body">
                  
                  <form action="{{url('/employee/update/'.$data->id)}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Vārds uzvārds</label>
                        <input type="text" name="name" class="form-control" id="name"
                        value="{{ $data ->name }}" >
                        @error('name')<!-- ja validācija dod kļūdu -->
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <label for="email" class="form-label">E-pasta adrese</label>
                        <input type="email" name="email" class="form-control" id="email" 
                        value="{{$data->email}}">
                        <label for="phone" class="form-label">Telefona Nr.</label>
                        <input type="text" name="phone" class="form-control" id="phone" 
                        value="{{$data->phone}}">
                        <label for="position" class="form-label">Amats</label>
                        <input type="text" name="position" class="form-control" id="position" 
                        value="{{$data->position}}">
                    </div>
                    <button type="submit" class="btn btn-primary">Saglabāt</button>
                  </form>
              
                </div>
              </div>
            </div>
          </div>
    </div>
@endsection