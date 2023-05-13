<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ItemController extends Controller
{
    public function index()
    {
        //
    }

    public function create($id)
    {
        $areas = Area::all();
        if ($id === '0') {
            return view('items.create')->with('areas', $areas);
        } else {
            $idarea = Area::find($id);
            return view('items.create')->with('areas', $areas)->with('idarea', $idarea);
        }
    }

    public function store(Request $request)
    {
        
        $imageData = $request->input('image_data');
        $imageSource = $request->input('image_source');

        $area = Area::find($request->id_area);
        // Store
        $coll = new Item();
        $coll->nombre = $request->nombre;
        $coll->descripcion = $request->descripcion;
        $coll->area_id = $request->id_area;
        //Codigo
        $idArea = Item::max('id');
        if ($idArea === null) {
            $coll->codigo = substr($area->nombre, 0, 4) . '-' . $request->nombre . '.1';
        } else {
            $coll->codigo = substr($area->nombre, 0, 4) . '-' . $request->nombre . '.' . $idArea + 1;
        }
        //save image file
        if ($imageData) {
            // Obtener la foto tomada por la cámara en formato base64
            $imagenBase64 = $request->input('image_data');
            $imagenCodificadaLimpia = str_replace("data:image/png;base64,", "", urldecode($imagenBase64));
            $nombreImagen = 'camara_' . uniqid() . '.png';
            // Ruta de destino para guardar la imagen
            $rutaImagen = public_path('/img/fotos/' . $nombreImagen);
            // Decodifica la imagen base64 y obtén el tipo de contenido
            $imagenDecodificada = base64_decode($imagenCodificadaLimpia);
            $moved = file_put_contents($rutaImagen, $imagenDecodificada);

            if ($moved) {
                $coll->image = $nombreImagen;
                $coll->save();
            }
        } else {
            $file = $request->file('image');
            $path = public_path() . '/img/fotos';
            $fileName = uniqid() . '-' . $file->getClientOriginalName();
            $moved = $file->move($path, $fileName);
            if ($moved) {
                $coll->image = $fileName;
                $coll->save();
            }
        }
        $coll->save();
        // Redirect
        return redirect('/')->with('success', 'Mueble registrado exitosamente');
    }

    public function show($id)
    {
        // retrieve item
        $item = Item::find($id);

        //redirect
        return view('items.show')
            ->with('item', $item);
    }

    public function edit($id)
    {
        // retrieve item
        $item = Item::find($id);
        // retrieve areas
        $areas = Area::all();
        return view('items.edit')
            ->with('item', $item)
            ->with('areas', $areas);
    }

    public function update(Request $request, $id)
    {
        // Validate
        $this->validate($request, [
            'nombre' => 'required',
            'descripcion' => 'required',
            'id_area' => 'required'
        ]);

        // Update
        $item = Item::find($id);
        $item->nombre = $request->nombre;
        $item->descripcion = $request->descripcion;
        $item->area_id = $request->id_area;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = public_path() . '/img/fotos';
            $fileName = uniqid() . '-' . $file->getClientOriginalName();
            $moved = $file->move($path, $fileName);

            if ($moved) {
                $previousPath = $path . '/' . $item->image;
                $item->image = $fileName;
                $saved = $item->save();

                if ($saved)
                    File::delete($previousPath);
            }
        }

        $item->save();
        // Redirect
        return view('items.show')->with('success', 'Mueble actualizado correctamente.')->with('item', $item);;
    }

    public function destroy($id)
    {
        $item = Item::find($id);
        /* generate redirect url (redirect to parent collection) */
        $url = 'area/' . $item->area_id . '/show';
        $nombresImagenes = [
            $item->image,
        ];
        $item->delete();
        // Elimina las imágenes del servidor
        foreach ($nombresImagenes as $nombreImagen) {
            $rutaImagen = public_path('img\fotos'.$nombreImagen);
            if (File::exists($rutaImagen)) {
                File::delete($rutaImagen);
            }
        }
        return redirect($url)->with('success', 'Mueble eliminado correctamente');
    }

    public function vistaQR($id)
    {
        $item = Item::find($id);
        return view('layouts.showqr')->with('item', $item);
    }
}
