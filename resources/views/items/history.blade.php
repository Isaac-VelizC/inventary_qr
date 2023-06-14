@extends('layouts.app')

@section('content')

<section class="section">
    <div class="col-lg-6" style="margin: 0 auto;">
        <!-- Card with header and footer -->
        <div class="card">
            <div class="card-header" style="text-align: center">Historial de {{ $item->nombre }}</div>
                <div class="card-body">
                    @foreach ($hitory as $item)
                        <h5 class="card-title">{{$item->descripcion}}</h5>
                        fecha de movimiento: {{$item->movimiento}}
                        <br>
                    @endforeach
                </div>
                <a class="badge bg-primary" href="{{ URL::previous() }}">Volver</a>
            <!-- End Card with header and footer -->
    </div>
</section>

@endsection
