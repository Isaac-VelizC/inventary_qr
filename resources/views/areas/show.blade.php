@extends('layouts.app')

@section('content')
<section class="section">
      <div class="col-lg-6" style="margin: 0 auto;"><!-- Card with header and footer -->
        <div class="card">
          <div class="card-header" style="text-align: center">{{$area->nombre}}</div>
          <div class="card-body">
            <h5 class="card-title">{{$area->encargado}}</h5>
            {{$area->descripcion}}
          </div>
          <br>
            <a class="btn btn-outline-dark" href="{{ isset($area->id) ? url('item/create/'.$area->id) : url('item/create/'.'0') }}">
              <i class="bi bi-collection">Agregar Muebles</i>
            </a>
            <!-- End Card with header and footer -->
      </div>
</section>


<section class="section dashboard">
    <div class="row">
        <!-- Left side columns -->
        <div class="col-lg-8">
            <div class="row">
            <!-- Recent Sales -->
                <div class="col-12">
                    <div class="card recent-sales">
                    <div class="card-body">
                        <h5 class="card-title">Muebles en el Area <span>| {{$area->nombre}}</span></h5>
                        @if( count($area->items) > 0 )
                        <table class="table table-borderless datatable">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Mueble</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Codigo</th>
                            <th scope="col">Estado</th>
                            </tr>
                        </thead>
                        @foreach($area->items as $item)
                        <tbody>
                            <tr>
                            <th scope="row">#{{$item->id}}</th>
                            <td>{{$item->nombre}}</td>
                            <td>{{ Str::limit($item->descripcion, 25, '...')}}</td>
                            <td>{{$item->codigo}}</td>
                            <td><a href="{{ url('item/'.$item->id.'/show') }}"><span class="badge bg-success">Activo</span></a></td>
                            </tr>
                        </tbody>
                            @endforeach
                        </table>
                        @else
                            <div class="divider"></div>
                            <p class="center-align">No hay elementos para mostrar. ¡Vamos a agregar algunos!</p>
                        @endif
                    </div>
                    </div>
                </div><!-- End Recent Sales -->
            </div>
        </div><!-- End Left side columns -->
    </div>
    <a href="{{url('/')}}"><i class="fa fa-check"></i> Volver</a>
  </section>
@endsection
