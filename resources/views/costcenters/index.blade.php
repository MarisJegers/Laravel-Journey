@extends('layouts.app')
 
@section('content')
       
    <div class="py-12">
      <div class="container">
        <div class="row">
          <div class="col-md-9">
            <div class="card">
                <!-- ieraksta pievienošanas gadījuā, izleks paziņojums, ka tas veiksmīgi izdarīts -->
                @if(session('success'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                  <strong>{{ session('success') }}</strong> 
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                  <!-- kods izmaksu centru tabulas skatam lapas kreisajā pusē -->
                  <div class="card-header"> <h4>Izmaksu centru tabula</h4> 
                  
                  <!-- meklēšana -->
                    <form action="{{ route('costcenter.search') }}" method="GET">
                      <input type="text" name="search" required/>
                      <button type="submit" class="btn btn-outline-dark btn-sm" data-toggle="tooltip" 
                      data-placement="top" title="Tiks meklēti ieraksti starp izmaksu centru numuruiem un aprakstiem">Meklēt</button>
                    </form>
                    <!-- end meklēšana-->

                  </div>
                    <div class="card-body">
                      <!-- tabulas virsraksta rinda -->
                      <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">Nr</th>
                            <th scope="col">Izm.centra numurs</th>
                            <th scope="col">Apraksts</th>
                            <th scope="col">Pievienots</th>
                            <th scope="col">Darbības</th>
                          </tr>
                        </thead>
                        <!-- te cikls ielasīs datus no BD tabulas -->
                        <tbody>
                                @php($i = 0)
                                @foreach ($data as $key => $value)
                          <tr>
                              <td>{{ ++$i }}</td>
                              <td>{{ $value->cc_number }}</td>
                              <td>{{ $value->description }}</td>
                              <td>{{ $value->created_at->toDateString() }}</td>
                              <!-- Action pogas labajā malējā kolonā -->
                              <td> 
                              @can('isAdmin')
                              <a href="{{url('/costcenter/edit/'.$value->id)}}" {{--class="btn btn-secondary btn-sm"--}}><img src="{{url('/image/edit-25px.png')}}" alt="Labot"></a>
                              <a href="{{url('/costcenter/delete/'.$value->id)}}" onclick="return confirm('Vai tiešām dzēst?')" {{--class="btn btn-secondary btn-sm"--}} ><img src="{{url('/image/delete-25px.png')}}" alt="Dzēst"></a>
                              @endcan
                              </td> 
                          </tr> 
                                @endforeach
                        </tbody>
                      </table>
                      <br>

          {{ $data->links() }} <!--šis, lai strādātu paginate -->
  
                    </div>
            </div> 
          </div>
          <!-- datu pievienošanas forma lapas labajā pusē -->
          <div class="col-md-3">
            <div class="card">
              <div class="card-header"> <h4>Pievienot</h4> </div>
                <div class="card-body">
                  
                  <form action="{{route('store.costcenter')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="cc_number" class="form-label">Izmaksu centra numurs</label>
                        <input type="text" name="cc_number" class="form-control" id="cc_number" >
                        @error('cc_number')<!-- ja validācija dod kļūdu -->
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <label for="description" class="form-label">Skaidrojums</label>
                        <input type="text" name="description" class="form-control" id="description" >
                    </div>
                    @can('isAdmin')
                    <button type="submit" class="btn btn-primary">Saglabāt</button>
                    @endcan
                  </form>
              
                </div>
              </div>
            </div>
          </div>
          
          <!-- meklēšanas rezultāti -->
          
          <!-- end meklēšansa rezultāti -->
    </div>
      <!-- skripts uznirstošajam padoma vai skaidrojuma logam -->
    <script>
      $(function () {
        $('[data-toggle="tooltip"]').tooltip()
      })
    </script>
@endsection