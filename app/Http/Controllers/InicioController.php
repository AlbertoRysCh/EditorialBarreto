<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;
// Excel
// use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use App\Helpers\Customize;
// Modelos
use App\Models\Cliente;
use App\User;
use Illuminate\Support\Facades\Auth;

class InicioController extends Controller
{
    public function index()
    {


        $array_obj  = [

        ];

        return View::make("inicio.index")->with("data", $array_obj)->render();
    }

 
}
