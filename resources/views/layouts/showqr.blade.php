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
                </div>
            </div>
          </div>
          <br>
            <!-- End Card with header and footer -->
      </div>
</section>

@endsection
