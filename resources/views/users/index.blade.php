@extends('layouts.app')

@section('content')

<style>
    @media screen and (max-width: 767px) {
        .scrollable-table {
            overflow: auto;
            -webkit-overflow-scrolling: touch;
        }
    }
    .custom-button {
        padding: 0;
        border: none;
        background-color: transparent;
        color: #fff;
    }

    .custom-button .badge {
        background-color: #dc3545;
        font-size: 12px;
        padding: 5px 10px;
        border-radius: 10px;
    }
</style>

<section class="section">
    <div class="col-12">
        <div class="card top-selling">
            <div class="card-body pb-0 scrollable-table">
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <h5 class="card-title">Cuentas de Usuario <span>| Lista</span></h5>
                    <a href="{{ url('admin/users/create') }}" class="btn btn-outline-success smaller-button"><i class="bi bi-box-arrow-down"></i> 
                        <span class="label-text">Nuevo</span>
                    </a>
                </div>
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th scope="col">Vista</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Correo Electronico</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Tag</th>
                        </tr>
                    </thead>
                    @foreach ($users as $item)
                        <tbody>
                            <tr>
                                <th scope="row"><a href="#"><img src="" alt=""></a></th>
                                <td><a href="#" class="text-primary fw-bold">{{$item->name}}</a></td>
                                <td>{{$item->email}}</td>
                                @if ($item->estado == 'A')
                                    <td><a href="#"><span class="badge bg-success">Activo</span></a></td>
                                @else
                                    <td><span class="badge bg-danger">Inactivo</span></td>
                                @endif
                                <td>
                                    <a href="{{ url('admin/users/'.$item->id.'/edit')}}">
                                        <span class="badge bg-primary"><i class="bi bi-brush-fill me-1"></i></span>
                                    </a>
                                    <span class="badge bg-danger">
                                        <form action="{{ url('admin/users/'.$item->id.'/delete')}}" method="post">
                                            @csrf
                                            <input name="_method" type="hidden" value="delete">
                                            <button type="submit" class="custom-button">
                                                  <i class="bi bi-x-octagon me-1"></i>
                                            </button>
                                        </form>
                                    </span>
                                    <a href="{{ url('admin/users/'.$item->id.'/show')}}">
                                        <span class="badge bg-info text-dark"><i class="bi bi-info-circle me-1"></i></span>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</section>

@endsection