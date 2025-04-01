<?php

namespace App\Http\Controllers;

use App\Http\Livewire\Pos\PosInterface;
use Illuminate\Http\Request;


//Controlador mal hecho , llama mal al componente live wire, 
// por el contrario se deberia crear un blade con el componente y , en el controlador llamar al blade
class PosController extends Controller
{
    public function index()
    {
        return view('pos.index', [
            'posComponent' => new PosInterface()
        ]);
    }
}