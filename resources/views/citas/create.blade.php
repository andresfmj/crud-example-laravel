@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    @unless (Auth::check())
                        <p>Sin autorizacion</p>
                    @else
                        <div class="card-header">Crear nueva cita</div>
                        <div class="card-body">
                            <form action="{{ url('/home/citas/create') }}" method="POST">
                                @csrf

                                @if($errors->any())
                                    <div class="alert alert-danger" role='alert'>
                                        <h4 class="alert-heading">Hubo un problema al crear la cita</h4>
                                        <ul>
                                            @foreach ($errors->all() as $err)
                                                <li>{{ $err }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="form-group row">
                                    <label for="inputTitulo" class="col-sm-2 col-form-label">Titulo</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputTitulo" name='titulo' placeholder="Titulo de la cita" autocomplete="off" value="{{ old('titulo') ? old('titulo') : '' }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputDescripcion" class="col-sm-2 col-form-label">Descripcion</label>
                                    <div class="col-sm-10">
                                        <textarea name="descripcion" class="form-control" id="inputDescripcion" cols="15" rows="5">{{ old('descripcion') ? old('descripcion') : '' }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputDateIni" class="col-sm-2 col-form-label">Inicio</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputDateIni" name='fecha_inicio' readonly value="{{ old('fecha_inicio') ? old('fecha_inicio') : '' }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputDateEnd" class="col-sm-2 col-form-label">Fin</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputDateEnd" name='fecha_fin' readonly value="{{ old('fecha_fin') ? old('fecha_fin') : '' }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-10 offset-sm-2">
                                    <button type="submit" class="btn btn-primary btn-block">Registrar cita</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endunless
                </div>
            </div>
        </div>
    </div>
@endsection