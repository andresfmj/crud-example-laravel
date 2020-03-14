<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Str;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = Usuario::all();

        return response()->json([
            'error' => count($users) > 0 ? false : true,
            'res' => [
                'rows' => count($users),
                'data' => count($users) > 0 ? $users->toArray() : null
            ]
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'nombre' => 'required',
            'password' => 'required|min:6',
            'email' => 'required|unique:usuarios'
        ]);


        $user = new Usuario();

        $user->nombre = ucfirst($input['nombre']);
        $user->password = bcrypt($input['password']);
        $user->email = $input['email'];
        $user->api_token = Str::random(60);

        if ($user->save()) {
            $response['message'] = trans('view.new_user_created');
        }

        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Usuario::find($id);

        return response()->json([
            'error' => $user ? false : true,
            'res' => $user ? $user : null
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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

        $user = Usuario::find($id);

        $user->nombre = ucfirst($input['nombre']);
        
        if (strlen($input['password']) > 0)
            $user->password = bcrypt($input['password']);
        
        $user->email = $input['email'];

        if ($user->save()) {
            $response['message'] = trans('view.user_updated');
        }

        return response()->json($response);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
