<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Item;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function index()
    {
        $areas = Area::all();
        return view('home')->with('areas', $areas);
    }

    public function create()
    {
        return view('areas.create');
    }

    public function store(Request $request)
    {
        // Validate
        $this->validate($request, [
          'nombre' => 'required',
          'encargado' => 'required',
          'descripcion' => 'required'
        ]);

        // Store
        $coll = new Area();
        $coll->nombre = $request->nombre;
        $coll->descripcion = $request->descripcion;
        $coll->encargado = $request->encargado;
        $coll->save();
        return redirect('/')->with('success', 'Registrado con éxito.');;
    }

    public function show($id)
    {
        $area = Area::find($id);
        return view('areas.show')
          ->with('area', $area);
    }

    public function edit($id)
    {
        $area = Area::find($id);
        return view('areas.edit')
          ->with('area', $area);
    }

    public function update(Request $request, $id)
    {
        // Validate
        $this->validate($request, [
            'nombre' => 'required',
            'encargado' => 'required',
            'descripcion' => 'required'
        ]);

        // Update
        $coll = Area::find($id);
        $coll->nombre = $request->nombre;
        $coll->encargado = $request->encargado;
        $coll->descripcion = $request->descripcion;
        $coll->update();

        // Redirect
        return redirect('/')->with('success', 'Area actualizada con éxito.');
    }

    public function destroy($id)
    {
        $area = Area::find($id);
        $area->delete();
        return redirect('/')->with('success', 'Area eliminada con éxito');
    }

}
