@extends('layouts.app')

@section('content')

<style>
    @media screen and (max-width: 767px) {
        .scrollable-table {
            overflow: auto;
            -webkit-overflow-scrolling: touch;
        }
    }
</style>

<section class="section">
      <div class="col-lg-6" style="margin: 0 auto;">
        <!-- Card with header and footer -->
        <div class="card">
          <div class="card-header" style="text-align: center">{{$area->nombre}}</div>
          <div class="card-body">
            <h5 class="card-title">{{$area->encargado}}</h5>
            {{$area->descripcion}}
          </div>
          <br>
            <a class="btn btn-outline-dark" href="{{ isset($area->id) ? url('admin/item/create/'.$area->id) : url('admin/item/create/'.'0') }}">
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
                    <div class="card-body scrollable-table">
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
                                <th scope="col">Ver</th>
                                </tr>
                            </thead>
                            @foreach($area->items as $item)
                            <tbody>
                                <tr>
                                <th scope="row">#{{$item->id}}</th>
                                <td>{{$item->nombre}}</td>
                                <td>{{ Str::limit($item->descripcion, 25, '...')}}</td>
                                <td>{{$item->codigo}}</td>
                                @if ($item->estado == '1')
                                    <td><a href=""><span class="badge bg-success">Activo</span></a></td>
                                @else
                                    <td><a href=""><span class="badge bg-danger">Inactivo</span></a></td>
                                @endif
                                <td><a href="{{ url('admin/item/'.$item->id.'/show') }}"><i class="fa fa-eye"></i></a></td>
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
    <a class="badge bg-primary" href="{{url('/')}}"><i class="fa fa-check"></i> Volver</a>
  </section>
@endsection
