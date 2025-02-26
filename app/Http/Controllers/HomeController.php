<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function admin()
    {
        $cursos = Curso::all();
        return view('pages.admin.index', compact('cursos'));
    }
    public function cursos()
    {
        $cursos = Curso::all();
        return view('pages.curso', compact('cursos'));
    }
}
