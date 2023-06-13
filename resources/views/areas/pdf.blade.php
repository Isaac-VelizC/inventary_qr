<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    
<section class="section dashboard">
    <div class="row">
        <!-- Left side columns -->
        <div class="col-lg-8">
            <div class="row">
            <!-- Recent Sales -->
                <div class="col-12">
                    <div class="card recent-sales">
                    <div class="card-body scrollable-table">
                        <h5 class="card-title">Muebles del Area de <span>| {{ $area->nombre}}</span></h5>
                        @if( count($datosFiltrados) > 0 )
                        <table id="tabla-items" class="table table-borderless datatable">
                            <thead>
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Mueble</th>
                                <th scope="col">Fecha de compra</th>
                                <th scope="col">Descripción</th>
                                <th scope="col">Codigo</th>
                                <th scope="col">Fecha dado de baja</th>
                                <th scope="col">Estado</th>
                                </tr>
                            </thead>
                            @foreach($datosFiltrados as $item)
                            <tbody>
                                <tr>
                                    <th scope="row">#{{$item->id}}</th>
                                    <td>{{$item->nombre}}</td>
                                    <td style="display: none">{{$item->tipo_id}}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->fecha_compra)->format('d/m/Y') }}</td>
                                    <td>{{ Str::limit($item->descripcion, 25, '...')}}</td>
                                    <td>{{$item->codigo}}</td>
                                    @if ($item->estado == '1')
                                        <td>No hay</td>
                                        <td><span class="badge bg-success">Activo</span></td>
                                    @else
                                        <td>{{$item->fecha_baja}}</td>
                                        <td><span class="badge bg-danger">Inactivo</span></td>
                                    @endif
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
</section>
</body>
</html>