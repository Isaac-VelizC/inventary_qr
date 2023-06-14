@extends('layouts.app')

@section('content')
<section class="section">
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
            <div class="card-body">
                <h5 class="card-title"> Modificar {{$item->nombre}}</h5>
                <!-- Advanced Form Elements -->
                <form method="post" action="{{ url('admin/item/'.$item->id.'/edit') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Detalles objeto</label>
                    <div class="col-sm-10">
                    <div class="form-floating mb-3">
                        <select class="form-select" id="id_tipo" name="id_tipo" aria-label="Tipo de activo">
                        <option value="" selected disabled>Selecciona el Tipo</option>
                            @if( count($tipoActivo) > 0 )
                                @foreach( $tipoActivo as $collection )
                                @if ( $collection->id == old('tipo_id') )
                                        <option value="{{$collection->id}}" selected>{{$collection->nombre}}</option>
                                    @elseif ( $collection->id == $item->tipo_id && old('tipo_id') === null )
                                        <option value="{{$collection->id}}" selected>{{$collection->nombre}}</option>
                                    @else
                                        <option value="{{$collection->id}}">{{$collection->nombre}}</option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                        <label for="id_area">Selecciona un Tipo</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="nombre" value="{{ old('nombre', $item->nombre) }}" id="nombre">
                        <label for="nombre">Nombre</label>
                    </div>
                    
                    <div class="form-floating mb-3">
                        <input type="date" class="form-control" name="fecha_compra" value="{{ old('fecha_compra', $item->fecha_compra) }}" id="fecha_compra">
                        <label for="fecha_compra">Fecha de compra</label>
                    </div>
                    
                    <div class="form-floating mb-3">
                        <input type="file" name="image" class="form-control" id="uploadInput">
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" name="descripcion" placeholder="Descripción corta del mueble" id="descripcion" style="height: 100px;">{{ old('descripcion', $item->descripcion) }}</textarea>
                        <label for="descripcion">Descripcion</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" id="id_area" name="id_area" aria-label="Selecciona una Area">
                        <option value="" selected disabled>Selecciona el Area</option>
                            @if( count($areas) > 0 )
                                @foreach( $areas as $collection )
                                    @if ( $collection->id == old('area_id') )
                                        <option value="{{$collection->id}}" selected>{{$collection->nombre}}</option>
                                    @elseif ( $collection->id == $item->area_id && old('area_id') === null )
                                        <option value="{{$collection->id}}" selected>{{$collection->nombre}}</option>
                                    @else
                                        <option value="{{$collection->id}}">{{$collection->nombre}}</option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                        <label for="id_area">Selecciona una Area</label>
                    </div>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a href="{{ url('/') }}" type="reset" class="btn btn-secondary">Cancelar</a>
                </div>
                </form><!-- End General Form Elements -->

            </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div id="imageContainer">
            </div>
            <br>
            <h4>Imagen Anterior</h4>
            <img src="{{ asset('img/fotos/'.$item->image)}}" alt="Imagen Anterior">
        </div>
    </div>
</section>
	<script>
		// Obtener referencia al elemento de entrada de archivo
		var uploadInput = document.getElementById('uploadInput');
		// Obtener referencia al contenedor de la imagen
		var imageContainer = document.getElementById('imageContainer');
		// Agregar un evento change al elemento de entrada de archivo
		uploadInput.addEventListener('change', function(event) {
			// Obtener el archivo seleccionado
			var file = event.target.files[0];
			// Crear una instancia de FileReader
			var reader = new FileReader();
			// Definir la función de carga completada
			reader.onload = function(e) {
				// Crear un elemento de imagen
				var image = document.createElement('img');
				// Establecer la ruta de la imagen como el resultado de la carga
				image.src = e.target.result;
				// Agregar la imagen al contenedor
				imageContainer.appendChild(image);
			}
			// Leer el archivo como una URL de datos
			reader.readAsDataURL(file);
		});
	</script>
@endsection
