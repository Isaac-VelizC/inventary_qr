@extends('layouts.app')

@section('content')
  <section class="section">
      <div class="col-lg-8" style="margin: 0 auto;">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Ingresar nueva Area</h5>
            <!-- Vertical Form -->
            <form action="{{ url('admin/area')}}" method="POST" role="form text-left">
                @csrf
                @if($errors->any())
                    <div class="mt-3  alert alert-primary alert-dismissible fade show" role="alert">
                        <span class="alert-text text-black">
                        {{$errors->first()}}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            <i class="fa fa-close" aria-hidden="true"></i>
                        </button>
                    </div>
                @endif
                @if(session('success'))
                    <div class="m-3  alert alert-success alert-dismissible fade show" id="alert-success" role="alert">
                        <span class="alert-text text-black">
                        {{ session('success') }}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            <i class="fa fa-close" aria-hidden="true"></i>
                        </button>
                    </div>
                @endif
                <div class="col-12">
                    <label for="nombre" class="form-label"> Nombre</label>
                    <input type="text" class="form-control" name="nombre" value="{{ old('nombre') }}" id="nombre">
                    @error('nombre')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="encargado" class="form-label"> Encargado/a</label>
                    <input type="text" class="form-control" name="encargado" value="{{ old('encargado') }}" id="encargado">
                    @error('encargado')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="descripcion" class="form-label"> Descripcion</label>
                    <textarea name="descripcion" data-length="15000" class="form-control" id="descripcion">{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <br><br>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">guardar</button>
                    <a href="{{url('/')}}" type="reset" class="btn btn-secondary">Cancelar</a>
                </div>
            </form><!-- Vertical Form -->
          </div>
        </div>
      </div>
  </section>
@endsection
