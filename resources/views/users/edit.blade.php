@extends('layouts.app')

@section('content')

<section class="section">
    <div class="col-12">
        <div class="card top-selling">
            <div class="card-body pb-0">
                <h5 class="card-title">Editar Usuario <span>| {{ $edit->name }}</span></h5>
                        <!-- Advanced Form Elements -->
                        <form>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Datos de la cuenta</label>
                                <div class="col-sm-10">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" id="floatingInput" placeholder="Username" value="{{$edit->name}}">
                                                <label for="floatingInput">Username</label>  
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-floating mb-3">
                                                <input type="email" class="form-control" id="floatingInput" value="{{ $edit->email }}" placeholder="name@example.com">
                                                <label for="floatingInput">Correo Electronico</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <div class="row mb-5">
                            <label class="col-sm-2 col-form-label">Permisos</label>
                            <div class="col-sm-10">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
                                    <label class="form-check-label" for="flexSwitchCheckDefault">Default switch checkbox input</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
                                    <label class="form-check-label" for="flexSwitchCheckChecked">Checked switch checkbox input</label>
                                </div>
                            </div>
                        </div>

                </form><!-- End General Form Elements -->
            </div>
        </div>
    </div>
</section>

@endsection