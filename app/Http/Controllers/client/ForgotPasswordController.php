<?php



namespace App\Http\Controllers\Client;



use Illuminate\Http\Request;

use App\Mail\resetPassword;

use App\Http\Controllers\Controller;

use Hash;

use App\Client;

use App\User;

use App\Http\Controllers\StaticMethodsController;

use App\ForgotPassword;

use App\Jobs\SendMail;

use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\DB;


class ForgotPasswordController extends Controller

{

    public function generateResetToken($string)

    {

        return Hash::make($string);

    }



    private function generateCode()

    {

        $str = "";

        $characters = array_merge(range('A', 'Z'), range('a', 'z'), range('0', '9'));

        $max = count($characters) - 1;

        for ($i = 0; $i < 6; $i++) {

            $rand = mt_rand(0, $max);

            $str .= $characters[$rand];

        }

        return $str;

    }



    public function resetPasswordEmail($id)

    {



        $string = $this->generateCode();



        $token = $this->generateResetToken($string);



        $user = StaticMethodsController::getUserById($id);



        $ins = $this->insertResetDb($user, $token, $string);



        if ($ins) {

            $this->sendMail($token, $user, $string, $user->email);

            return $msg = ['msg' => 'Verifique seu email para resetar sua senha.', 'status' => 200];

        }



        return $msg = 'false';

    }



    private function sendMail($token, $user, $hash, $email)

    {

        $mail = new resetPassword($token, $hash, $user);



        return Mail::to($email)->send($mail);

    }



    public function verifyClient($email)

    {

        try {



            if (!empty($email)) {

                $client = Client::whereEmail($email)->get();
                $clientA = DB::table('clients')->where('Email', $email)->get();;
                //dd($clientA->First());
                if (!$clientA->isEmpty() && $this->getUser($clientA->First()->email)) {

                    $ver = $this->verifyQtdGenToken($clientA->First()->id);

                    if ($ver >= 1) {

                        return response()->json($msg = ['msg' => 'Você já solicitou uma mudança de senha, cheque seu email ou solicite novamente', 'status' => 201]);

                    }

                    return $this->resetPasswordEmail($clientA->First()->id);

                }

                return response()->json($msg = ['msg' => 'Você não cadastrou uma senha ainda, vamos cadastra-la agora!', 'status' => 403, 'redirect' => 'https://pedidos.tubaraodapraia.com.br/client/area-do-cliente/primeiro-acesso' . '?id=' . $clientA->First()->id . '&token=' . Hash::make($clientA->First()->id) . '&redirect=' . route('productdelivery.index')]);

            }

        } catch (\Exception $e) {

            return $e;

        }

    }



    private function getUser($email)

    {

        $user = User::where('email', '=', $email)->get();



        if(!$user->isEmpty())

        {

            return true;

        }



        return false;

    }



    public function insertResetDb($user, $hash, $code)

    {

        $insert = \DB::table('forgot_password')

            ->insert([

                'client_id' => $user->client_id,

                'reset_token' => $hash,

                'status' => '0',

                'reset_code' => $code,

                'created_at' => date('Y/m/d H:i:s')

            ]);



        if ($insert) {

            return true;

        }



        return false;

    }



    public function createUsers()

    {

        $clients = Client::all();



        foreach ($clients as $client) {



            if (isset($client->id)) {



                $find = Client::find($client->id)->First();



                if (isset($find->id)) {



                    \DB::table('users')

                        ->insert([

                            'name' => $client->nome,

                            'email' => $client->email,

                            'password' => '',

                            'role' => 2,

                            'loja_id' => 1,

                            'client_id' => $client->id,

                            'created_at' => date('Y/m/d H:i:s')

                        ]);

                }

            }

        }

    }



    private function verifyQtdGenToken($id)

    {

        return $qtd = ForgotPassword::select('*')

            ->where('client_id', '=', $id)

            ->where('status', '=', '0')

            ->count();

    }



    public function verifyClientToken($token, $id)

    {

        if (!empty($token) && !empty($id)) {



            $pass = ForgotPassword::select('*')

                ->where('reset_code', '=', $token)

                ->where('client_id', '=', $id)

                ->where('status', '=', '0')

                ->get();



            if (isset($pass->First()->reset_code) && $pass->First()->reset_code == $token) {

                $pass = ForgotPassword::where('id', '=', $pass->First()->id)->update(['status' => '1']);

                return response()->json(['reset' => 'true']);

            }

        }



        return response()->json(['reset' => 'false']);

    }



    public function resetPassword(Request $request)

    {

        $data = $request->all();



        if (!empty($data['token']) && !empty($data['id'])) {

            $resToken = ForgotPassword::select('*')

                ->where('reset_token', '=', $data['token'])

                ->where('client_id', '=', $data['id'])

                ->where('status', '=', '0')

                ->with(['getClient'])

                ->get();



            if (isset($resToken->First()->reset_token) && $resToken->First()->reset_token == $data['token']) {

                return view('area-cliente.reset-pass', compact('resToken'));

            }

        }



        return view('area-cliente.reset-pass', compact('resToken'));

    }



    public function newPassword(Request $request)

    {

        $data = $request->all();



        if ($data['id']) {

            $newPass = User::where('client_id', '=', $data['id'])->update(['password' => Hash::make($data['password'])]);

            return response()->json(['reset_password' => 'true']);

        }



        return response()->json(['reset_password' => 'false']);

    }



    public function testeEmail()

    {

        $user = StaticMethodsController::getUserById(4464);



        return view('emails.forget_password', ['fp' => '$2y$10$XJ8S6hhYJ9PECpUEsq36ueIyMSmkoKt74ZbA/1lGEGhsBFKpWrPc6', 'hash' => 'mYugPX', 'client' => $user]);

    }

}

