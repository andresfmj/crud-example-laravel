@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Usuarios</div>

                    <div class="card-body">
                        @unless(Auth::check())
                            <p>Sin autorizacion</p>
                        @else
                            <table class="table bordered striped responsive">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>Correo</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>100</td>
                                        <td>A</td>
                                        <td>a@a.com</td>
                                        <td>editar | eliminar</td>
                                    </tr>
                                </tbody>
                            </table>
                        @endunless
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection