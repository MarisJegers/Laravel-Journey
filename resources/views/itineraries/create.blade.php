@extends('layouts.app')
@section('title', 'Pievienot ceļazīmi')
@section('content')

<!-- ekspriments ar formas skata optimizēšanu -->

<!-- autentificētā lietotāja pēdējā ceļazīme -->
<div class="container-fluid">
<div class="row">
<div class="col">
            <table class="table table-sm table-hover table-responsive">
              <thead class="thead-light"><!-- tabulas virsraksta rinda -->
                <tr>
                  <th scope="col" id="para1">Nr</th>
                  <th scope="col">CZ Nr.</th>
                  <th scope="col">Lietotājs</th>
                  <th scope="col">Auto</th>
                  <th scope="col">Sākuma dat.</th>
                  <th scope="col">Beigu dat.</th>
                  <th scope="col">KM-sākumā</th>
                  <th scope="col">KM-beigās</th>
                  <th scope="col">KM-nobraukts</th>
                  <th scope="col">Degviela l</th>
                  <th scope="col">Vid.degv.pat.</th>
                  <th scope="col">KM-darba</th>
                  <th scope="col">KM-privāti</th>
                  <th scope="col">Pievienots</th>
                  <th scope="col">Darbības</th>
                </tr>
              </thead>
              <!-- te cikls ielasīs datus no DB tabulas -->
              <tbody>
                      @php($i = 0)
                      @foreach ($data as $value)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $value->ti_nr }}</td>
                    <td>{{ $value->user->name }}</td>
                    <td>{{ $value->car->reg_nr }}</td>
                    <td>{{ $value->date_start  }}</td>
                    <td>{{ $value->date_end    }}</td>
                    <td>{{ $value->odo_start   }}</td>
                    <td>{{ $value->odo_end	 }}</td>
                    <td>{{ $value->total_distance_km  }}</td>
                    <td>{{ $value->total_fuel_l }}</td>
                    <td>{{ $value->fuel_average       }}</td>
                    <td>{{ $value->distance_business }}</td>
                    <td>{{ $value->distance_private }}</td>
                    <td>{{ $value->created_at->toDateString() }}</td>
                    <!-- Action pogas labajā malējā kolonā -->
                    <td> 
                    <a href="{{url('/itinerary/edit/'.$value->id)}}" class="btn btn-secondary btn-sm">Labot</a>
                    <a href="{{url('/itinerary/delete/'.$value->id)}}" onclick="return confirm('Vai tiešām dzēst?')" class="btn btn-secondary btn-sm">Dzēst</a>
                    <a href="{{url('/itinerary/show/'.$value->id)}}" class="btn btn-secondary btn-sm">Braucieni</a>
                    </td> 
                </tr> 
                      @endforeach
              </tbody>
            </table>
</div>
</div> 
</div>         
<!-- end autentificētā lietotāja pēdējā ceļazīme-->
<!--<div class="container">-->
<!--<div class="row">-->

<!-- datu pievienošanas forma -->
<div class="container-fluid">
                    <div class="row">
                      <div class="col-md-10">
            <div class="card">
              <!-- ieraksta pievienošanas gadījuā, izleks paziņojums, ka tas veiksmīgi izdarīts -->
              @if(session('success'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                  <strong>{{ session('success') }}</strong> 
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
              <div class="card-header"> <h4>Pievienot ceļazīmi</h4> </div>
                <div class="card-body">
                  
                      <form action="{{route('store.itinerary')}}" method="POST">
                        @csrf 
                        
                          <div class="form-group row border border-secondary">
                            <div class="col-md-2">
                              <label for="user_id" class="form-label">Vadītājs</label>
                              <input type="text" name="user_id" class="form-control border border-dark bg-light" id="user_id" value="{{Auth::user()->name}}">
                              @error('user_id')
                              <span class="text-danger">{{ $message }}</span>
                              @enderror
                            </div>
                        
                        
                        <div class="col-md-2">
                            <label for="car_id" class="form-label">Izvēlies auto</label>
                            <select class="form-control border border-dark" name="car_id" id="car_id">
                                @foreach($car as $c)
                                  <option value="{{ $c->id }}">{{$c->reg_nr}}</option>
                                @endforeach
                            </select>
                            @error('car_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <!--</div>-->
                        <!--<div class="form-group row">-->
                        <div class="col-auto">
                            <label for="ti_nr" class="form-label">Ceļazīmes numurs (Izveidojas automātiski. NAV jāaizpilda)</label>
                            <input type="text" name="ti_nr" class="form-control border border-dark" id="ti_nr" aria-describedby="emailHelp" readonly>
                            <div id="emailHelp" class="form-text">Ieraksts izveidojas automātiski. Nemainiet to!</div>
                        </div>
                        </div>
                        
                        <div class="form-group row border border-secondary">
                          <div class="col-auto">
                              <label for="date_start" class="form-label">Perioda sākuma datums</label>
                              <input type="date" name="date_start" class="form-control border border-dark bg-light" id="date_start" onblur="concatan()" aria-describedby="emailHelp">
                            <div id="emailHelp" class="form-text">Izvēlies no kalendāra!</div>
                              @error('date_start')<!-- ja validācija dod kļūdu -->
                              <span class="text-danger">{{ $message }}</span>
                              @enderror
                          </div>
                        
                          <div class="col-auto">
                            <label for="date_end" class="form-label">Perioda beigu datums</label>
                            <input type="date" name="date_end" class="form-control border border-dark bg-light" id="date_end" aria-describedby="emailHelp">
                            <div id="emailHelp" class="form-text">Izvēlies no kalendāra!</div>
                            @error('date_end')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                          </div>
                        </div>
                        
                        <div class="form-group row border border-secondary">
                        <div class="col-md-3">
                            <label for="odo_start" class="form-label">Odometrs perioda sākumā</label>
                            <input type="number" name="odo_start" class="form-control border border-dark bg-light" id="odo_start" aria-describedby="emailHelp">
                            <div id="emailHelp" class="form-text">Lūdzu, ievadiet veselu, pozitīvu skaitli!</div>
                            @error('odo_start')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="odo_end" class="form-label">Odometrs perioda beigās</label>
                            <input type="number" name="odo_end" class="form-control border border-dark bg-light" id="odo_end" 
                            aria-describedby="emailHelp" onblur="totaldistance()">
                            <div id="emailHelp" class="form-text">Lūdzu, ievadiet veselu, pozitīvu skaitli!</div>
                            @error('odo_end')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-auto">
                            <label for="total_distance_km" class="form-label">Nobrauktie kilometri (aprēķins notiek fonā)</label>
                            <input type="number" name="total_distance_km" class="form-control border border-dark bg-light" id="total_distance_km" aria-describedby="emailHelp" readonly >
                            <div id="emailHelp" class="form-text">Ieraksts izveidojas automātiski. Nemainiet to!</div>
                            @error('total_distance_km')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                          </div>

                        </div>

                        <div class="form-group row border border-secondary">

                          <div class="col-auto">
                            <label for="fuel_leftover" class="form-label">Sākuma atlikums (l)</label>
                            <input type="number" name="fuel_leftover" class="form-control border border-dark bg-light" id="fuel_leftover" step="any" 
                            aria-describedby="emailHelp">
                            <div id="emailHelp" class="form-text">Ievadiet veselu, pozitīvu skaitli!</div>
                          </div>

                          <div class="col-auto">
                            <label for="fuel_filled" class="form-label">Ielietā degviela (l)</label>
                            <input type="number" name="fuel_filled" class="form-control border border-dark bg-light" id="fuel_filled" step="any" 
                            aria-describedby="emailHelp" onblur="totalfuel()">
                            <div id="emailHelp" class="form-text">Ievadiet veselu, pozitīvu skaitli!</div>
                          </div>

                          <div class="col-auto">
                            <label for="total_fuel_l" class="form-label">Degviela kopā(l)</label>
                            <input type="number" name="total_fuel_l" class="form-control border border-dark bg-light" id="total_fuel_l" step="any" 
                            aria-describedby="emailHelp" onblur="avgfuel()">
                            <div id="emailHelp" class="form-text">Lūdzu, ievadiet veselu, pozitīvu skaitli!</div>
                            @error('total_fuel_l')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                          </div>

                          <div class="col-auto">
                            <label for="fuel_average" class="form-label">Aprēķinātais vidējais degvielas patēriņš (l/100 km)</label>
                            <input type="number" name="fuel_average" class="form-control border border-dark bg-light" step="any" id="fuel_average" aria-describedby="emailHelp" readonly>
                            <div id="emailHelp" class="form-text">Ieraksts izveidojas automātiski. Nemainiet to!</div>
                          </div>
                        </div>

                        <div class="form-group row border border-secondary">
                          <div class="col-auto">
                            <label for="distance_business" class="form-label">Darba ietvaros veikto braucienu kopējā distance</label>
                            <input type="number" name="distance_business" class="form-control border border-dark bg-light" id="distance_business" onblur="privatekm()">
                          </div>

                          <div class="col-auto">
                            <label for="distance_private" class="form-label">Privāto braucienu kopējā distance (aprēķins notiek fonā)</label>
                            <input type="number" name="distance_private" class="form-control border border-dark bg-light" id="distance_private" aria-describedby="emailHelp">
                            <div id="emailHelp" class="form-text">Ieraksts izveidojas automātiski. Nemainiet to!</div>  
                          </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Saglabāt</button>
                        
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          

            </div>
<!--</div>-->



<script>
 function totaldistance()
{
    var a1 = parseFloat(document.getElementById('odo_end').value);
    var a2 = parseFloat(document.getElementById('odo_start').value); 
     document.getElementById('total_distance_km').value = parseFloat(a1) - parseFloat(a2);
   }

   function avgfuel()
  {
    var a1 = parseFloat(document.getElementById('odo_end').value);
    var a2 = parseFloat(document.getElementById('odo_start').value); 
    var a3 = parseFloat(document.getElementById('total_fuel_l').value);
    var a4 = 100;
    var aa = (a3/(a1-a2))*a4;
    var aaa = aa.toFixed(2);
    document.getElementById('fuel_average').value = aaa;
   
     //te jāturpina lai skaitli noapaļo līdz 2 zīmēm aiz komata
   
    }

   function concatan()
   {
    var str1 = document.getElementById('car_id').value;
    let ms = Date.now();
    var res = str1.concat(ms);
    document.getElementById('ti_nr').value = res;
   }
   
   function privatekm()
   {
    var a5 = parseFloat(document.getElementById('total_distance_km').value); 
    var a6 = parseFloat(document.getElementById('distance_business').value); 
    var a7 = a5 - a6;
    var a8 = a7.toFixed(2);
    document.getElementById('distance_private').value = a8;
   }

  function totalfuel()
  {
    var fl = parseFloat(document.getElementById('fuel_leftover').value); 
    var ff = parseFloat(document.getElementById('fuel_filled').value); 
    var sum = fl + ff;
    var total = sum.toFixed(2);
    document.getElementById('total_fuel_l').value = total;
  }


</script>

@endsection
