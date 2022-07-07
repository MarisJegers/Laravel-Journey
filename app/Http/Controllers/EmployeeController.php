<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use PDF;

class EmployeeController extends Controller
{
    //aizsardzībai
    public function __construct(){
        $this->middleware('auth');
    }

    //visi sistēmas lietotāji
    public function showEmployees(){
        $employee = User::all();
        return view('employees.index', compact('employee'));
      }

      // Izmēģinājums ar df ģenerēšanu
      // ar composeri jāinstalē barryun/domPDF paka
      // jāizveido skats ieks views un atbilstoš routs iekš web.php
      public function createPDF() {
        // atgriež visu no db`zes
        $data = User::all();
  
        // padod no db sdaņemtos datus uz pdf faila sagatavošanas skatu
        view()->share('employee',$data);
        $pdf = PDF::loadView('employees.pdf', $data)->setOptions(['defaultFont' => 'arial']);
  
        // izsauc download metodi faila lejuplādes sākšani
        return $pdf->download('pdf_file.pdf');
      }

      public function editemployee($id){
        $this->authorize('isAdmin');
        $data = User::find($id);
        return view('employees.edit', compact('data'));
    }
    
    public function updateemployee(Request $request, $id){
        $this->authorize('isAdmin');
        
        $data = User::find($id)->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'position'=>$request->position,
        ]);

        return redirect()->route('employees.index')->with('success', 'Ieraksts labots');
    }

    public function deleteemployee($id){
        $this->authorize('isAdmin');
        User::find($id)->delete();
           
           return Redirect()->back()->with('success', 'Lietotājs dzēsts');
    }
}
