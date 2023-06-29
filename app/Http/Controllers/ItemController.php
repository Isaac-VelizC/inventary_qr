<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Item;
use App\Models\MoveHistory;
use App\Models\Tipo;
use Carbon\Carbon;
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
        $tipoActivo = Tipo::all();
        $areas = Area::all();
        if ($id === '0') {
            return view('items.create')->with('areas', $areas)->with('tipoActivo', $tipoActivo);;
        } else {
            $idarea = Area::find($id);
            return view('items.create')->with('areas', $areas)->with('tipoActivo', $tipoActivo)->with('idarea', $idarea);
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
        $coll->tipo_id = $request->id_tipo;
        $coll->fecha_compra = $request->fecha;
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
        
        return view('items.show')->with('item', $item)->with('rutaimg', $rutaimg)->with('miQr', $miQr);
    }

    public function edit($id)
    {
        $tipoActivo = Tipo::all();
        // retrieve item
        $item = Item::find($id);
        // retrieve areas
        $areas = Area::all();
        return view('items.edit')
            ->with('item', $item)
            ->with('areas', $areas)
            ->with('tipoActivo', $tipoActivo);
    }

    public function update(Request $request, $id)
    {
        // Validate
        $this->validate($request, [
            'nombre' => 'required',
            'id_area' => 'required'
        ]);

        // Update
        $item = Item::find($id);
        $item->nombre = $request->nombre;
        $item->descripcion = $request->descripcion;
        if ($item->area_id != $request->id_area) {
            $nomArea = Area::find($request->id_area);
            $movi = new MoveHistory();
            $movi->item_id = $id;
            $movi->descripcion = 'Se movio de '.$item->area->nombre.' a '.$nomArea->nombre;
            $movi->save();
        }
        $item->area_id = $request->id_area;
        $item->tipo_id = $request->id_tipo;
        if ($request->fecha_compra != null) {
            $item->fecha_compra = $request->fecha_compra;
        }

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

    public function destroy(Request $request, $id)
    {
        $item = Item::find($id);
        /*$nombresImagenes = [
            $item->image,
        ];
        
        foreach ($nombresImagenes as $nombreImagen) {
            $rutaImagen = public_path('img\fotos'.$nombreImagen);
            if (File::exists($rutaImagen)) {
                File::delete($rutaImagen);
            }
        };*/
        if ($request->filled('encargado') || $request->filled('descripcion')) {
            $item->user_baja = $request->encargado;
            $item->descripcion = $request->descripcion;
            $item->fecha_baja = Carbon::now();
            $item->estado = 0;
            $item->update();
            return redirect('/')->with('success', 'Mueble eliminado correctamente');
        } else {
            return redirect('/')->with('success', 'No existe datos para dar de baja');
        }
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

    public function history($id)
    {
        $coll = Item::find($id);
        $hitory = MoveHistory::where('item_id', $id)->get();
        return view('items.history')->with('hitory', $hitory)->with('item', $coll);
    }
}
