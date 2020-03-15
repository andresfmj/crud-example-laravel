<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Usuario;
use Auth;
use Exception;
use Illuminate\Http\Request;
use Log;
use Str;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = Usuario::all();
            
            return response()->json([
                'error' => count($users) > 0 ? false : true,
                'res' => [
                    'rows' => count($users),
                    'data' => count($users) > 0 ? $users->toArray() : null
                ]
            ]);
        } else {
            $users = Usuario::paginate(5);

            return view('users.index', ['users' => $users]);
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
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

        if ($request->ajax()) {
            return response()->json($response);
        } else {
            return redirect()->route('users');
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
        $user = Usuario::find($id);

        return view('users.edit', ['user' => $user]);
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
        $response = array('error' => true, 'message' => '');

        $user = Usuario::find($id);

        $emailFound = Usuario::where('email', $input['email'])->where('id', '<>', $id)->get();
        if (count($emailFound) > 0) {
            if ($request->ajax()) {
                $response['error'] = true;
                $response['message'] = trans('view.duplicate_email');
            } else {
                $response['message'] = trans('view.duplicate_email');
            }

        } else {

            $user->nombre = ucfirst($input['nombre']);

            if (strlen($input['password']) > 0)
                $user->password = bcrypt($input['password']);
            
            $user->email = $input['email'];
    
            if ($user->save()) {
                $response['message'] = trans('view.user_updated');
            }
        }

        if ($request->ajax()) {
            return response()->json($response);
        } else {
            if (count($emailFound) > 0) {
                return redirect('/home/users/' . $id . '/edit')->withInput()->withErrors($response['message']);
            } else {
                return view('users.edit', ['user' => $user, 'response' => $response]);
            }
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
            if (Auth::user()->id == $id) {
                $response['error'] = true;
                $response['message'] = trans('view.cannot_remove_user');
            } else {
                Usuario::destroy($id);
                $response['message'] = trans('view.user_removed');
            }
        } catch (Exception $e) {
            $response['error'] = true;
            $response['message'] = $e->getMessage();
        }

        return response()->json($response);

    }
}
