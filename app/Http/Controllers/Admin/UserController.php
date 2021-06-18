<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mockery\Exception;
use App\Http\Controllers\StaticMethodsController;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    private $estadoModel;

    public function __construct(\App\User $loja)
    {
        $this->lojaModel = $loja;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$users = User::paginate(15);
        $users = \DB::table('users')
            ->select('users.id', 'name', 'email', 'role', 'nome_loja', 'loja_id')
            ->join('loja', 'users.loja_id', '=', 'loja.id')
            ->orderBy('id')->paginate(15);

        $lojas = StaticMethodsController::getLojasList();

        return view('admin.users.index', compact(['users', 'lojas']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {

            $user = \Auth::user();

            $lojas = StaticMethodsController::getLojasList();

            return view('admin.users.create', compact(['user', 'lojas']));
        } catch (Exception $e) {
            return redirect()->route('admin.users.index');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $data = $request->all();

            $data['password'] = bcrypt($data['password']);

            $user = new User();

            $user->fill($data);

            if ($data['role'] == User::ROLE_DELIVERYMAN) {
                $data['deliveryman_online'] = 0;
            }

            if (!$user->validate(true)) {
                return Redirect::back()->withInput($request->all())->withErrors($user->getErrors());
            }

            $user->save();

            return redirect()->route('admin.users.index', ['id' => $user->id])
                ->with('alert-success', 'Usuário criado com sucesso!');
        } catch (Exception $e) {
            return redirect()->route('admin.users.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {

            $user = User::find($id);

            $lojas = StaticMethodsController::getLojasList();

            return view('admin.users.edit', compact(['user', 'lojas']));
        } catch (Exception $e) {
            return redirect()->route('admin.users.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {

            $user = User::findOrFail($id);

            $data = $request->all();

            if ($data['password'] == '') {
                $data['password'] = $user->password;
            } else {
                $data['password'] = bcrypt($data['password']);
            }

            $required_fields = [];
            if (!$user->validate(false)) {
                $required_fields = [];
                foreach ($user->getErrors()->getMessages() as $key => $value) {
                    $required_fields[] = $key;
                }
            }

            $user->fill($data);

            if (!$user->validate(false)) {
                return Redirect::back()->withInput($request->all())->withErrors($user->getErrors());
            }

            $user->save();

            return redirect()->route('admin.users.index');
        } catch (Exception $e) {
            return redirect()->route('admin.users.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            $usuario = new \App\User;

            $usuario->find($id);

            if ($usuario) {

                $usuario->destroy($id);

                return redirect()->Route('admin.users.index');
            }
        } catch (Exception $e) {
            return redirect()->route('admin.users.index');
        }
    }

    public function searchUsers($id)
    {
        $users = \DB::table('users')
            ->select('users.id', 'name', 'email', 'role', 'nome_loja', 'loja_id')
            ->join('loja', 'users.loja_id', '=', 'loja.id')
            ->where('loja.id', '=', $id)
            ->orderBy('id')->paginate(15);

        $lojas = StaticMethodsController::getLojasList();

        return view('admin.users.index', compact(['users', 'lojas']));
    }
}
