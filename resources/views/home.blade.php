@extends('layouts.app')

@section('content')
            <div class="card">
                <div class="card-header" style="text-align: center; color:black; font-weight: 700; 
                text-decoration: underline;">AREA</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if( count($areas) > 0 )
                    <div class="row">
                      <section class="section dashboard">
                          <!-- Left side columns -->
                          <div class="col-lg-12">
                            <div class="row">
                              <!-- Sales Card -->
                              @foreach($areas as $collection)
                              <div class="col-xxl-4 col-md-6">
                                <div class="card info-card sales-card">
                                  <div class="filter">
                                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                      <li><a class="dropdown-item" href="{{ url('area/'.$collection->id.'/edit')}}">Editar</a></li>
                                      <li>
                                        <form action="{{ url('area/'.$collection->id)}}" method="post">
                                          <input name="_method" type="hidden" value="delete">
                                          <input class="dropdown-item" type="submit" value="Borrar" id="btnDelete">
                                          {{ csrf_field() }}
                                        </form>
                                      </li>
                                    </ul>
                                  </div>
                                  <a href="{{ url ('area/'.$collection->id.'/show')}}">
                                  <div class="card-body">
                                    <h5 class="card-title"> {{$collection->nombre}} <span>| {{$collection->encargado}}</span></h5>
                                    <div class="d-flex align-items-center">
                                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-cart"></i>
                                      </div>
                                      <div class="ps-3">
                                        @if( count($collection->items) == 1 )
                                          <h6>{{count($collection->items)}}</h6>
                                        @elseif( count($collection->items) > 1 )
                                          <h6>{{count($collection->items)}}</h6>
                                        @else
                                          <h6>0</h6>
                                        @endif
                                        <span class="text-muted small pt-2 ps-1">{{ Str::limit($collection->descripcion, 50, '...')}}</span>
                                      </div>
                                    </div>
                                  </div>
                                </a>
                                </div>
                              </div><!-- End Sales Card -->
                              @endforeach
                            </div>
                          </div><!-- End Left side columns -->
                      </section>
                    </div>
                  @else
                    <p class="flow-text">Actualmente no tienes ninguna Area registrado. ¡Haga clic en el botón para agregar algunos!</p>
                  @endif
                  <a class="btn btn-outline-primary" href="{{ url('/area/create')}}">
                    <i class="bi bi-collection"> Nueva Area</i>
                  </a>
                  <a class="btn btn-outline-dark" href="{{ isset($area->id) ? url('/item/create/'.$area->id) : url('/item/create/0') }}">
                    <i class="bi bi-collection"> Mueble</i>
                  </a>
                </div>
            </div>
            
@endsection