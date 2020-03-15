@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Citas</div>

                    <div class="alert mt-3 mb-3 mr-3 ml-3" style='display: none;'>
                        <div class="alert-heading" id="alertTitle"></div>
                    </div>
                    

                    <div class="card-body">
                        @unless(Auth::check())
                            <p>Sin autorizacion</p>
                        @else
                            <a class="btn btn-primary mb-3" href="{{ url('/home/citas/create') }}">Nueva cita</a>
                            <table class="table bordered striped responsive" id='tblCitas'>
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Titulo / Descripcion</th>
                                        <th>Fecha Inicio</th>
                                        <th>Fecha Fin</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($citas as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>
                                                <h5>{{ $item->nombre }}</h5>
                                                <p>{{ $item->descripcion }}</p>
                                            </td>
                                            <td>{{ $item->fecha_inicio }}</td>
                                            <td>{{ $item->fecha_fin }}</td>
                                            <td><a href="{{ url('/home/citas/' . $item->id . '/edit') }}">editar</a> | <a href="#delete" data-id='{{ $item->id }}' onclick="removeItem(this, '/home/citas/#id#/delete')">eliminar</a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $citas->render() }}
                        @endunless
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection