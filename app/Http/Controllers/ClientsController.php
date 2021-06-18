<?php

namespace App\Http\Controllers;

use App\Client;
use App\Mail\RequestToken;
use App\Services\ClientService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class ClientsController extends Controller
{

    public function solicitarToken(){
        return view('clientes.solicitar-token', ['invalidLink' => false]);
    }

    public function acepgToken(){
        return view('clientes.acepg', ['invalidLink' => false]);
    }

    public function tokenInvalido() {
        return view('clientes.solicitar-token', ['invalidLink' => true]);
    }

    public function logout() {
        Auth::logout();
        return response()->redirectToRoute('solicitar.token');
    }

    public function cepSemCadastro(Request $request) {

        
//  DB::table('no_deliverycep');
    DB::table('no_deliverycep')->insert(
    array('cep' =>  $request->cep, 'created_at' => date('Y-m-d H-i-s')));

        return $request->cep;
        

            }

    public function verificarCadastro(Request $request, ClientService $clientService){
        $email = $request->get('email');
        $origem = $request->get('origem');

        $cliente = Client::whereEmail($email)->first();


        $info = array(

            'cadastrar_email' => $email,
            'origem' => $origem
            );
        print_r($info);

        if (!$cliente):
           // return response()->redirectToAction('ClientsController@cadastrar')->with('cadastrar_email', $email);
            return response()->redirectToAction('ClientsController@cadastrar')->with($info);


        else:
            $cliente->resetLoginToken($clientService);
            $cliente->save();
            $this->sendMail($cliente);
            return response()->redirectToRoute('success', ['action' => 'token']);
        endif;
    }

    public function cadastrar(Request $request){
        $email = $request->session()->get('cadastrar_email') ?  $request->session()->get('cadastrar_email')  : $request->old('email');
        $origem = $request->session()->get('origem') ?  $request->session()->get('origem')  : $request->old('origem');

        if (!$email){
            return response()->redirectToRoute('solicitar.token');
        }
        $cliente = new Client();
        $cliente->email = $email;
        $cliente->origem = $origem;
        $action = 'cadastrar';
        return view('clientes.cadastro', compact(['cliente', 'action']));
    }

    public function store(Request $request, ClientService $clientService) {
        $cliente = new Client();
        $cliente->fill($request->all());
        if (!$cliente->validate(true)){
            return Redirect::back()->withInput($request->all())->withErrors($cliente->getErrors());
        }
        $cliente->resetLoginToken($clientService);
        $cliente->save();
        $this->sendMail($cliente);
        return response()->redirectToRoute('success', ['action' => 'cadastro']);
    }

    public function update(Request $request){
        $cliente = new Client();
        
        $cliente = $cliente->find($request->get('id'));

        $required_fields = [];
        if (!$cliente->validate(false)) {
            $required_fields = [];
            foreach ($cliente->getErrors()->getMessages() as $key => $value){
                $required_fields[] = $key;
            }
        }

        $cliente->fill($request->only($required_fields));
        $cliente->data_nasc = null;
        if (!$cliente->validate(false)){
            return Redirect::back()->withInput($request->all())->withErrors($cliente->getErrors());
        }
        $cliente->update($request->only($required_fields));
        return response()->redirectToRoute('visualizar.cupons');
    }

    public function success(Request $request){
        $action = $request->get('action');
        return view('clientes.obrigado', compact('action'));
    }

    public function edit(){

        /* @var $cliente \App\Client */
        $cliente = Auth::getUser();
        $messages = null;
        $required_fields = [];
        if (!$cliente->validate(false)) {
            $required_fields = [];
            foreach ($cliente->getErrors()->getMessages() as $key => $value){
                $required_fields[] = $key;
            }
            $messages = ["Existem alguns campos que precisam ser preenchidos em seu cadastro. Por favor, preencha corretamente para continuar."];
        }
        $required_fields = json_encode($required_fields,  JSON_FORCE_OBJECT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
//        dd($required_fields);
        $action = 'atualizar';
        return view('clientes.cadastro', compact('cliente', 'messages', 'required_fields', 'action'));
    }

    protected function sendMail(Client $cliente){
        $mail = new RequestToken($cliente);
        Mail::to($cliente)->send($mail);
// Linhas abaixo foram comentadas pois estamos no aguardo para implementar o esquema de queue
//        $mail->to($cliente)->send($mail);
//        $job = (new SendMail($mail))->onQueue('email');
//        dispatch($job);
    }

}
