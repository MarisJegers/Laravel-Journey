<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Car;
use App\Models\User;
use App\Models\Journey;
use App\Models\Costcenter;
use Illuminate\Http\Request;
use App\Models\Travelitinerary;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Query\Builder;

class TravelitineraryController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    //šim jābūt pieejamam tikai adminiem
    public function allitineraries(){
        // $data = Costcenter::all(); <- tas atgriezīs visus tabulas ierakstus
        // $data = Costcenter::latest()->get(); <- arī atgriezīs visu, bet jaunākie pievienotie būs tabulas augšā
        $data = Travelitinerary::latest()->paginate(10);
        return view('itineraries.index', compact('data'))
        ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function createitineraries(){
        //skatā ir jāielādē dati par konkrētā ielogojušās lietotāja
        //pēdējo veikto ierakstu
        $user = User::all(); //šis formai, lai parādītos ceļazīmes ievadītāja vārds
        $car = Car::all();  //arī formai, lai varētu no dropdown list izvēlēties auto
        //$data = Travelitinerary::all();
        //$data = Travelitinerary::where('user_id', Auth::user('id'))->max('id'); //šis lai parādītu pēdējo pievienoto ierakstu
        //$data = Travelitinerary::where('user_id', 1)->max('id')->get();
        //$data = DB::table('travelitineraries')->max('id');
        $usr = Auth::id();
        $data = Travelitinerary::where('user_id', $usr)
               ->orderBy('created_at', 'desc')
               ->orderBy('odo_end', 'desc')
               ->take(2)
               ->get();
        //print_r($data);
        //die();
        //dd($data);
        return view('itineraries.create', compact('data'))
                                    ->with('user', $user)
                                    ->with('car', $car);
                                    
    }
    

    public function additineraries(Request $request){
        //$this->authorize('isAdmin');
        //$totalkm = $request->odo_end - $request->odo_start; 
        //avgfuel = ($request->total_fuel_l / ($request->odo_end - $request->odo_start))* 100
        //$kmstart = $request->input('odo_start');
        //$kmend = $request->input('odo_end');
        //$kmtotal = $kmend - $kmstart;
        $request->validate([
            'ti_nr' => 'required|unique:travelitineraries|max:20',
            'date_start' => 'required|date',
            'date_end' => 'required|date|after_or_equal:date_start',
            'user_id' => 'required',
            'car_id' => 'required',
            'odo_start' => 'required|numeric|gt:0',
            'odo_end' => 'required|numeric|gte:odo_start',
            'total_fuel_l' => 'nullable|numeric|gt:0',
            'total_distance_km' => 'required|numeric|gt:0',
            'fuel_average' => 'nullable|numeric|gt:0',
            'distance_business' => 'nullable|numeric|gt:0',
            'distance_private' => 'nullable|numeric|min:0 ',
        ],
    [
        'date_end.required' => 'Laukam jābūt aizpildītam', // šīs ir error message
        'date_end.after_or_equal' => 'Beigu datums ir pirms sākuma datuma!!!',
        'odo_start.required' => 'Laukam jābūt aizpildītam', // šīs ir error message
        'odo_start.numeric' => 'Iespējams ievadīt tikai ciparus. Burti nederēs.',
        'odo_start.gt' => 'Iespējams ievadīt tikai pozitīvu skaitli',
        'odo_end.required' => 'Laukam jābūt aizpildītam', // šīs ir error message
        'odo_end.numeric' => 'Iespējams ievadīt tikai ciparus. Burti nederēs.',
        'odo_end.gte' => 'Ievadītajam skaitlim jābūt lielākam par Km-izbraucot',
        'total_fuel_l.numeric' => 'Iespējams ievadīt tikai ciparus. Burti nederēs.',
        'total_distance_km.required' => 'Laukam jābūt aizpildītam', 
        'total_distance_km.numeric' => 'Iespējams ievadīt tikai ciparus. Burti nederēs.',
        'total_distance_km.gt' => 'Iespējams ievadīt tikai pozitīvu skaitli',
    ]);
    
    // eloquent variants datu pievienošanai
    Travelitinerary::insert([
        'ti_nr'=>$request->ti_nr,   //pirmais cc_number ir index.blade formas input lauks, request ir mainīgais kura tas tiek saglabāts un padots uz db`zes tabulu
        'date_start'=>$request->date_start,
        'date_end'=>$request->date_end,
        'user_id'=>Auth::user()->id,
        'car_id'=>$request->car_id,
        'odo_start'=>$request->odo_start,
        'odo_end'=>$request->odo_end,
        'total_fuel_l'=>$request->total_fuel_l,
        'total_distance_km'=>$request->total_distance_km,
        'fuel_average'=>$request->fuel_average,
        'distance_private'=>$request->distance_private,
        'distance_business'=>$request->distance_business,
        'created_at'=>Carbon::now(),
        //'created_at'=>Carbon::now()->format('dmY'),
    ]);

        return redirect()->back()->with('success', 'Ceļazīme sekmīgi pievienota');

    }

    public function edititinerary($id){
        //$this->authorize('isAdmin');
        //$costcenter = Costcenter::all();
        $data = Travelitinerary::find($id);
        $user = User::all(); //šis formai, lai parādītos ceļazīmes ievadītāja vārds
        $car = Car::all();
        return view('itineraries.edit', compact('data','user', 'car'));
    }

    public function updateitinerary(Request $request, $id){
        //$this->authorize('isAdmin');
        //$data tiek izsaukts no edit.blade.php skata formas action lauka
        //formā esošo ierakstu (id) Costcenter modelis meklē datubāzē
        //un aizstāj ar $request mainīgajā labāto lietotāja no jauna
        //ierakstīto vērtību, kuru funkcija update ieraksta datubāzē
        //cc_number kreisajā pusē ir edit.blade formas input lauka nosaukums,
        //labajā pusē db`zes tabulas lauka nosaukums
        $data = Travelitinerary::find($id)->update([
            //'ti_nr'=>$request->ti_nr,   //pirmais cc_number ir index.blade formas input lauks, request ir mainīgais kura tas tiek saglabāts un padots uz db`zes tabulu
            'date_start'=>$request->date_start,
            'date_end'=>$request->date_end,
            'user_id'=>Auth::user()->id,
            'car_id'=>$request->car_id,
            'odo_start'=>$request->odo_start,
            'odo_end'=>$request->odo_end,
            'total_fuel_l'=>$request->total_fuel_l,
            'total_distance_km'=>$request->total_distance_km,
            'fuel_average'=>$request->fuel_average,
            'distance_private'=>$request->distance_private,
            'distance_business'=>$request->distance_business,
            //'created_at'=>Carbon::now(),
        ]);

        // route('costcenters.index') ir routa name no web.php
        return redirect()->route('itineraries.create')->with('success', 'Ceļazīmes dati izlaboti');
    }

    public function deleteitinerary($id){
        //$this->authorize('isAdmin');
        Travelitinerary::find($id)->delete();
           
           return Redirect()->back()->with('success', 'Ieraksts dzēsts');

    }

    // šī metode ir esence un nervs visai šai ceļazīmju megasistēmai
    // lietotājs darbojas skatā, kurā vienlaikus ir aktuālās ceļazīmes dati
    // un braucienu pievienošanas forma un ievadīto braucienu tabula.
    // lietotājs aizpilda tikai formu, bet redz datus no divām dažādām DB`zes tabulām.
    public function show($id)
    {
        $data = Travelitinerary::find($id);
        $costcenter = Costcenter::all();
        $journey = Journey::where('ti_nr_id', $id)
               ->orderBy('created_at', 'desc')
               ->take(10)
               ->get();
        
        //dd($data);
        //dd($journey);
        return view('itineraries.show',compact('data'))
                    ->with('costcenter', $costcenter)
                    ->with('journey', $journey);
    }

    public function search(Request $request){
        // Lietotāja ierakstītā frāze tiek iegūta no formas input lauka,
        // kurš tiek saglabāts $search mainīgajā
        // tiek meklēts starp laukiem lietotāja vārds,
        // auto VRN un pievienošanas datuma
        // lietotāja vārds un VRN ir lauki users un cars tabulās, tie ar itineraries 
        // tabulu ir savienoti caur user_id un car_id foreign laukiem
        // Meklēšanas vaicājums izmanto whereHas metodi, kurā ir parametri user un car,
        // kas tiek padoti no travelitineary modeļa user un car metodēm, kuras ir relāciju definēšanas metodes,
        // šī ceļazīme belongsTo User un Car modeļiem.
        // Tas ļauj caur foreign key atgriezt nevis id, bet name vai reg_nr vērtību (suudīgs skaidrojums)
        $search = $request->input('search');
        $datestart = $request->input('datestart');
        $dateend = $request->input('dateend');
        $search = $request->input('search');
        $users = Travelitinerary::whereHas('user', function ($query) use($search) {
            $query->where('name', 'like', "%$search%");
            })->get();
        $cars = Travelitinerary::whereHas('car', function ($query) use($search) {
            $query->where('reg_nr', 'like', "%$search%");
            })->get();

            //dd($cc); //Šis strādā, bet kā padot meklējamo vārdu no formas
            //šis varētu strādāt pie datuma no-līdz atlasei
        // $dates = DB::table('travelitineraries')
        //         ->whereDate('created_at', '<=', "%{$datestart}%")
        //         ->whereDate('created_at', '>=', "%{$dateend}%")
        //         ->get();
        
       // meklēšanas rezultātu atgriešanas skats
        return view('itineraries.search', compact('users', 'cars'));
    }



}
