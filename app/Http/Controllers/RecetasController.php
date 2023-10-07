<?php

namespace App\Http\Controllers;

use App\Models\Receta;
use Illuminate\Http\Request;

class RecetasController extends Controller
{
    public function index()
    {
        return response()->json(Receta::all());
    }

    public function store(Request $request)
    {
        /** @var \App\Models\User */
        $user = auth()->user();
        $receta = $user->recetas()->create($request->all());
        return response()->json(['receta' => $receta], 201);
    }

    public function update(Request $request, Receta $receta)
    {
        $receta->update($request->all());
        return response()->json(['receta' => $receta]);
    }

    public function destroy(Receta $receta)
    {
        $receta->delete();
        return response()->json(null, 204);
    }
}
