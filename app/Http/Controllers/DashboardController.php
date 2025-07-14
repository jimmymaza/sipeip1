<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $usuario = Auth::user(); // Ya viene con relaciones si se acceden con ->rol

        return view('dashboard', [
            'usuario' => $usuario
        ]);
    }
}
