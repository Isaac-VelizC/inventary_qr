<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Item;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
        $rutaimg = public_path('img/qr_codes/qr-'.uniqid().'.png');
        $miQr = QrCode::
                              //format('png')
                              size(100)  //defino el tamaño
                              ->backgroundColor(250, 240, 215) //defino el fondo
                              ->color(0, 0, 255)
                              ->margin(0.5)  //defino el margen
                              ->generate(url('vistaQR/'.$item->id));
        //redirect
        return view('items.show')->with('item', $item)->with('rutaimg', $rutaimg)->with('miQr', $miQr);
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
        $miQr = QrCode::size(100)  //defino el tamaño
                        ->backgroundColor(250, 240, 215) //defino el fondo
                        ->color(0, 0, 255)
                        ->margin(0.5)  //defino el margen
                        ->generate(url('vistaQR/'.$item->id));
        // Redirect
        return view('items.show')->with('success', 'Mueble actualizado correctamente.')->with('item', $item)->with('miQr', $miQr);
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

    public function printQR(Request $request)
    {
        $coll = Item::find($request->id_item);
        if ($coll->qr_code === null) {
            if ($request->input('image_data')) {
                // Obtener la foto en formato base64
                $imagenBase64 = $request->input('image_data');
                $imagenCodificadaLimpia = str_replace("data:image/png;base64,", "", urldecode($imagenBase64));
                $nombreImagen = 'qr_' . $request->codigo . '.png';
                // Ruta de destino para guardar la imagen
                $rutaImagen = public_path('/img/qr_codes/' . $nombreImagen);
                // Decodifica la imagen base64 y obtén el tipo de contenido
                $imagenDecodificada = base64_decode($imagenCodificadaLimpia);
                $moved = file_put_contents($rutaImagen, $imagenDecodificada);
    
                if ($moved) {
                    $coll->qr_code = $nombreImagen;
                    $coll->update();
                    $msg = 'Imagen creada correctamente';
                }
            } else {
                $msg = 'Error al crear la imagen';
            }
        } else {
            if ($request->input('image_data')) {
                // Obtener la foto en formato base64
                $imagenBase64 = $request->input('image_data');
                $imagenCodificadaLimpia = str_replace("data:image/png;base64,", "", urldecode($imagenBase64));
                $nombreImagen = 'qr_' . $request->codigo . '.png';
                // Ruta de destino para guardar la imagen
                $rutaImagen = public_path('/img/qr_codes/' . $nombreImagen);
                $path = public_path() . '/img/qr_codes';
                // Decodifica la imagen base64 y obtén el tipo de contenido
                $imagenDecodificada = base64_decode($imagenCodificadaLimpia);
                $moved = file_put_contents($rutaImagen, $imagenDecodificada);
    
                if ($moved) {
                    $previousPath = $path . '/' . $coll->image;
                    $coll->qr_code = $nombreImagen;
                    $saved = $coll->update();
                    if ($saved)
                        File::delete($previousPath);
                    $msg = 'Imagen creada correctamente';
                }
            } else {
                $msg = 'Error al crear la imagen';
            }
        }
        
        return back()->with($msg);
    }

    public function printPDf($nombre)
    {
        $ruta_imagen = public_path('/img/qr_codes/'.$nombre);
        if (File::exists($ruta_imagen))
            return Response::download($ruta_imagen, $nombre);
        else
            abort(404, 'Imagen no encontrada');
    }
}