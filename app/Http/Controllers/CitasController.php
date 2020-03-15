<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use Auth;
use Exception;
use Illuminate\Http\Request;

class CitasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $citas = Cita::all();
            
            return response()->json([
                'error' => count($citas) > 0 ? false : true,
                'res' => [
                    'rows' => count($citas),
                    'data' => count($citas) > 0 ? $citas->toArray() : null
                ]
            ]);
        } else {
            $citas = Cita::paginate(5);

            return view('citas.index', ['citas' => $citas]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('citas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->input();
        $response = array('error' => false, 'message' => '');

        $request->validate([
            'titulo' => 'required',
            'descripcion' => 'required',
            'fecha_inicio' => 'required|date|after:yesterday',
            'fecha_fin' => 'required|date|after:fecha_inicio'
        ]);


        $citas = new Cita();

        $citaFound = Cita::whereBetween('fecha_inicio', [$input['fecha_inicio'], $input['fecha_fin']]) 
                        ->orWhereBetween('fecha_fin', [$input['fecha_inicio'], $input['fecha_fin']])->get();

        if (count($citaFound) > 0) {
            $response['error'] = true;
            $response['message'] = trans('view.dates_overlap');
            return redirect('/home/citas/create')->withErrors($response['message'])->withInput();
        } else {
            $citas->titulo = strtoupper(trim($input['titulo']));
            $citas->descripcion = ucfirst($input['descripcion']);
            $citas->fecha_inicio = $input['fecha_inicio'];
            $citas->fecha_fin = $input['fecha_fin'];
            $citas->usuario_id = Auth::user()->id;

            if ($citas->save()) {
                $response['message'] = trans('view.new_cita_created');
            }
        }

        if ($request->ajax()) {
            return response()->json($response);
        } else {
            return redirect()->route('citas');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cita = Cita::find($id);

        return view('citas.edit', ['cita' => $cita]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->input();
        $response = array('error' => false, 'message' => '');
        
        $cita = Cita::find($id);

        $request->validate([
            'titulo' => 'required',
            'descripcion' => 'required',
            'fecha_inicio' => 'required|date|after:yesterday',
            'fecha_fin' => 'required|date|after:fecha_inicio'
        ]);

        $citaFound = Cita::whereBetween('fecha_inicio', [$input['fecha_inicio'], $input['fecha_fin']]) 
                        ->orWhereBetween('fecha_fin', [$input['fecha_inicio'], $input['fecha_fin']])->where('id', '<>', $id)->get();

        if (count($citaFound) > 0) {
            $response['error'] = true;
            $response['message'] = trans('view.dates_overlap');
            return redirect('/home/citas/' . $id . '/edit')->withErrors($response['message'])->withInput();
        } else {
            $cita->titulo = strtoupper(trim($input['titulo']));
            $cita->descripcion = ucfirst($input['descripcion']);
            $cita->fecha_inicio = $input['fecha_inicio'];
            $cita->fecha_fin = $input['fecha_fin'];

            if ($cita->save()) {
                $response['message'] = trans('view.cita_modified');
            }
        }

        if ($request->ajax()) {
            return response()->json($response);
        } else {
            return redirect()->route('citas');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = array('error' => false, 'message' => '');

        try {
            Cita::destroy($id);
            $response['message'] = trans('view.cita_removed');
        } catch (Exception $e) {
            $response['error'] = true;
            $response['message'] = $e->getMessage();
        }

        return response()->json($response);
    }
}
