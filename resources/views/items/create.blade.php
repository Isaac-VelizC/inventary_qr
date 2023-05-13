@extends('layouts.app')

@section('content')
<section class="section">
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
            <div class="card-body">
                <h5 class="card-title"> Registrar nuevo mueble</h5>
                <!-- Advanced Form Elements -->
                <form id="image-form" method="post" action="{{ url('item/') }}" enctype="multipart/form-data">
                    @csrf
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Detalles objeto</label>
                    <div class="col-sm-10">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="nombre" value="{{ old('nombre') }}" id="nombre">
                        <label for="nombre">Nombre</label>
                    </div>
                    
                    <div id="switch-container">
                        <input type="checkbox" id="switch-input">
                        <label for="switch-input">Cámara</label>
                    </div>

                    <div class="form-floating mb-3" id="upload-container">
                        <input type="file" name="image" class="form-control" id="uploadInput">
                    </div>

                    <input type="hidden" id="image-source" name="image_source">
                    <input type="hidden" id="image-data" name="image_data">
                    
                    <div class="form-floating mb-3">
                        <textarea class="form-control" name="descripcion" placeholder="Descripción corta del mueble" id="descripcion" style="height: 100px;"></textarea>
                        <label for="descripcion">Descripcion</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" id="id_area" name="id_area" aria-label="Selecciona una Area">
                        <option value="" selected disabled>Selecciona el Area</option>
                            @if( count($areas) > 0 )
                                @foreach( $areas as $collection )
                                    @if ( isset($idarea) )
                                        @if ($collection->id === $idarea->id)
                                            <option value="{{$collection->id}}" selected>{{$collection->nombre}}</option>    
                                        @else
                                            <option value="{{$collection->id}}">{{$collection->nombre}}</option>
                                        @endif
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
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{ URL::previous() }}" type="reset" class="btn btn-secondary">Cancelar</a>
                </div>
                </form><!-- End General Form Elements -->
            </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div id="imageContainer"></div>
            <div id="camera-container">
                <video id="video-preview" autoplay></video>
                <button id="capture-btn">Capturar imagen</button>
            </div>
            
            <div id="image-preview-container">
                <img id="image-preview" src="" alt="Vista previa de la imagen">
            </div>

        </div>
    </div>
</section>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
        var switchInput = document.getElementById('switch-input');
        var uploadContainer = document.getElementById('upload-container');
        var cameraContainer = document.getElementById('camera-container');
        var video = document.getElementById('video-preview');
        var captureBtn = document.getElementById('capture-btn');
        var imagePreview = document.getElementById('image-preview');
        var imageSource = document.getElementById('image-source');
        var imageDataInput = document.getElementById('image-data');
        var imageForm = document.getElementById('image-form');
        var mediaStream;

        switchInput.addEventListener('change', function() {
            if (switchInput.checked) {
                uploadContainer.style.display = 'none';
                cameraContainer.style.display = 'block';

                // Activar la cámara
                if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                    navigator.mediaDevices.getUserMedia({ video: true })
                        .then(function(stream) {
                            video.srcObject = stream;
                            mediaStream = stream;
                            video.addEventListener('loadedmetadata', function() {
                                // Ajustar el tamaño de la cámara al tamaño del contenedor
                                var containerWidth = video.parentElement.clientWidth;
                                var containerHeight = video.parentElement.clientHeight;

                                var videoRatio = video.videoWidth / video.videoHeight;
                                var containerRatio = containerWidth / containerHeight;

                                if (videoRatio > containerRatio) {
                                    video.style.width = containerWidth + 'px';
                                    video.style.height = (containerWidth / videoRatio) + 'px';
                                } else {
                                    video.style.width = (containerHeight * videoRatio) + 'px';
                                    video.style.height = containerHeight + 'px';
                                }
                            });
                        })
                        .catch(function(error) {
                            console.log("Se produjo un error al acceder a la cámara: ", error);
                        });
                }
            } else {
                uploadContainer.style.display = 'block';
                cameraContainer.style.display = 'none';

                // Detener la cámara
                if (mediaStream) {
                    var tracks = mediaStream.getTracks();
                    tracks.forEach(function(track) {
                        track.stop();
                    });
                }
            }
        });

        captureBtn.addEventListener('click', function() {
            var canvas = document.createElement('canvas');
            var context = canvas.getContext('2d');

            if (video.videoWidth > 0 && video.videoHeight > 0) {
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;

                context.drawImage(video, 0, 0, canvas.width, canvas.height);

                var imageData = canvas.toDataURL();
                
                imageSource.value = 'Cámara';
                imageDataInput.value = encodeURIComponent(imageData);
                
                // Mostrar la imagen capturada en la vista previa
                imagePreview.src = imageData;
                imageForm.sunmit();

            }
            
        });

        uploadInput.addEventListener('change', function() {
            // ...

            // Establecer el origen de la imagen como "Subida"
            imageSource.value = 'Subida';
            var reader = new FileReader();
            reader.onload = function(e) {
                imageDataInput.value = e.target.result;
            imageForm.submit();
            };
            reader.readAsDataURL(file);
        });

    });

    </script>
@endsection
