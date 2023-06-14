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
                    <h6><b>Tipo:</b> {{$item->tipo->nombre}}</h6>
                    <h6><b>fecha compra:</b> {{ \Carbon\Carbon::parse($item->fecha_compra)->format('d/m/Y') }}</h6>
                    <h6><b>Encargado:</b> {{$item->area->encargado}}</h6>
                    <p>{{$item->descripcion}}</p>
                </div>
                <div class="col-md-4" id="graficoBarras" style="margin-left: auto; margin-right: auto;">
                  <br>
                  {{ $miQr }}
                  <p>Cod.{{$item->codigo}}</p>
                </div>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-4">
                <a class="btn btn-outline-primary" href="{{ url('admin/item/'.$item->id.'/edit')}}">
                    <i class="bi bi-collection">Editar</i>
                  </a>
            </div>
            <div class="col-md-4">
              <!--form action="{{ url('admin/item/'.$item->id)}}" method="post">
                <input name="_method" type="hidden" value="delete">
                <input class="btn btn-outline-danger" type="submit" value="Borrar" id="btnDelete">
                  {{ csrf_field() }}
              </form-->
            </div>
            <div class="col-md-4">
              <a class="btn btn-outline-primary" id="btnimgGraficaBarras">
                  <i class="bi bi-print">Crear IMG</i>
              </a>
            </div>
          </div>
          <br>
          <!-- End Card with header and footer -->
      </div>

      <form id="image-form" method="post" action="{{ url('admin/printQR/') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id_item" value="{{$item->id}}">
        <input type="hidden" name="codigo" value="{{$item->codigo}}">
        <input type="hidden" id="image-data" name="image_data">
          <div id="image-preview-container">
            <img id="image-preview" src="" alt="Vista previa de la imagen">
          </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Guardar Img</button>
        </div>
      </form>
      <br>
      <div class="text-center">
        @if ($item->qr_code !== null)
          <a href="{{ url('admin/printPdf/'.$item->qr_code)}}" class="btn btn-primary">Descargar QR</a>
        @endif
        <a href="{{ url('admin/area/'.$item->area->id.'/show') }}" class="btn btn-secondary">Volver</a> 
    </div>
</section>

<script src="{{ asset('imagenseccion/librerias/jquery-3.4.1.min.js')}}"></script>
<script src="{{ asset('imagenseccion/librerias/bootstrap4/popper.min.js')}}"></script>
<script src="{{ asset('imagenseccion/librerias/bootstrap4/bootstrap.min.js')}}"></script>
<script src="{{ asset('imagenseccion/librerias/plotly-latest.min.js')}}" charset="utf-8"></script>
<script src="{{ asset('imagenseccion/librerias/htmlToCanvas.js')}}"></script>

<script type="text/javascript">

  var imagePreview = document.getElementById('image-preview');
  var imageDataInput = document.getElementById('image-data');
  var imageForm = document.getElementById('image-form');

  $(document).ready(function(){
      $('#btnimgGraficaBarras').click(function(){
        tomarImagenPorSeccion('graficoBarras','graficoBarras');
      });
    });

  function tomarImagenPorSeccion(div,nombre) {
      html2canvas(document.querySelector("#" + div)).then(canvas => {
        var img = canvas.toDataURL();
        base = "img=" + img + "&nombre=" + nombre;
        imagePreview.src = img;
        imageDataInput.value = encodeURIComponent(img);
        imageForm.sunmit();
      });	
    }
</script>

@endsection
