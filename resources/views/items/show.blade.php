@extends('layouts.app')

@section('content')
<section class="section">
      <div class="col-lg-6" style="margin: 0 auto;"><!-- Card with header and footer -->
        <div class="card">
          <div class="card-header" style="text-align: center">{{$item->nombre}}</div>
          <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <img src="{{ asset('img/fotos/'.$item->image) }}" alt="Foto" width="250" height="200">
                </div>
                <div class="col-md-6">
                    <h5 class="card-title">Area: {{$item->area->nombre}}</h5>
                    <p>{{$item->descripcion}}</p>
                    <p>Cod.{{$item->codigo}}</p> 
                    {{
                        $miQr = QrCode::
                              // format('png')
                              size(100)  //defino el tamaño
                              ->backgroundColor(250, 240, 215) //defino el fondo
                              ->color(0, 0, 255)
                              ->margin(0.5)  //defino el margen
                              ->generate(url('vistaQR/'.$item->id)) /** genero el codigo qr **/
                        }}
                </div>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-6">
                <a class="btn btn-outline-primary" href="{{ url('item/'.$item->id.'/edit')}}">
                    <i class="bi bi-collection">Editar</i>
                  </a>
            </div>
            <div class="col-md-6">
                    <form action="{{ url('item/'.$item->id)}}" method="post">
                        <input name="_method" type="hidden" value="delete">
                        <input class="btn btn-outline-danger" type="submit" value="Borrar" id="btnDelete">
                        {{ csrf_field() }}
                      </form>
            </div>
          </div>
            <!-- End Card with header and footer -->
      </div>
      
      <div class="text-center">
        <a href="{{ URL::previous() }}" class="btn btn-secondary">Volver</a>
    </div>
</section>

@endsection
