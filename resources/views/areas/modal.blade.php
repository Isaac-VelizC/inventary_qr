<div id="modal-familiar" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" style="text-align: center">Dar de baja la {{$item->nombre}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
                <form action="{{ url('admin/item/'.$item->id.'/delete')}}" method="POST">
                    {{ csrf_field() }}
                    @if($errors->any())
                        <div class="mt-3  alert alert-primary alert-dismissible fade show" role="alert">
                            <span class="alert-text text-white">
                            {{$errors->first()}}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                <i class="fa fa-close" aria-hidden="true"></i>
                            </button>
                        </div>
                    @endif
                    @if(session('success'))
                        <div class="m-3  alert alert-success alert-dismissible fade show" id="alert-success" role="alert">
                            <span class="alert-text text-white">
                            {{ session('success') }}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                <i class="fa fa-close" aria-hidden="true"></i>
                            </button>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="encargado" class="form-control-label">{{ __('Nombre') }}</label>
                                <div class="@error('encargado')border border-danger rounded-3 @enderror">
                                    <input class="form-control" value="{{ old('encargado') }}" type="text" placeholder="encargado" id="encargado" name="encargado">
                                        @error('encargado')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">    
                            <div class="form-group">
                                <label for="descripcion">{{ 'Descripcion' }}</label>
                                <div class="@error('user.descripcion')border border-danger rounded-3 @enderror">
                                    <textarea class="form-control" id="descripcion" rows="3" placeholder="Motivo por la que se da de baja" name="descripcion"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">{{ 'Guardar' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>