@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    @unless (Auth::check())
                        <p>Sin autorizacion</p>
                    @else
                        <div class="card-header">Crear usuario</div>
                        <div class="card-body">
                            <form action="{{ url('/home/users/create') }}" method="POST">
                                @csrf

                                @if($errors->any())
                                    <div class="alert alert-danger" role='alert'>
                                        <h4 class="alert-heading">Hubo un problema con el usuario</h4>
                                        <ul>
                                            @foreach ($errors->all() as $err)
                                                <li>{{ $err }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-2 col-form-label">Nombre</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputName" name='nombre' placeholder="Nombre completo" autocomplete="off" value="{{ old('nombre') ? old('nombre') : '' }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail" class="col-sm-2 col-form-label">Correo</label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" id="inputEmail" name='email' placeholder="Direccion de correo electronico" autocomplete="off" value="{{ old('email') ? old('email') : '' }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Contraseña</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" id="inputPassword" name='password' placeholder="Contraseña del usuario" value="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-10 offset-sm-2">
                                    <button type="submit" class="btn btn-primary btn-block">Registrar usuario</button>
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