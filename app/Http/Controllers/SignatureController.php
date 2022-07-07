<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SignatureController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index()
    {
        return view('signatures.signature-pad');
    }
      
    public function store(Request $request)
    {
        $folderPath = public_path('image/');
        
        $image = explode(";base64,", $request->signed);
              
        $image_type = explode("image/", $image[0]);
           
        $image_type_png = $image_type[1];
           
        $image_base64 = base64_decode($image[1]);
           
        $file = $folderPath . uniqid() . '.'.$image_type_png;
      
        file_put_contents($file, $image_base64);
      
        return back()->with('success', 'Paraksts saglabāts veiksmīgi !!');
    }
}
