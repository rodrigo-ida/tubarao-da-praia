<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Rede\Store;
use Rede\Transaction;
use Rede\eRede;
use Rede\Environment;

class eRedeController extends Controller
{

    protected $PV;
    protected $TOKEN;

    public function __construct()
    {
        $this->PV = env('EREDE_PV');
        $this->TOKEN = env('EREDE_TOKEN');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($data)
    {

        // Configuração da loja em modo produção
        $store = new Store($this->PV, $this->TOKEN, Environment::production());

        // Configuração da loja em modo sandbox
        // $store = new \Rede\Store('PV', 'TOKEN', \Rede\Environment::sandbox());

        // Transação que será autorizada
        $transaction = (new Transaction(floatval($data->total), 'pedido' . time()))->creditCard(
            $data->card_number,
            $data->card_security_number,
            $data->card_month,
            $data->card_year,
            $data->card_name
        );

        // Autoriza a transação
        $transaction = (new eRede($store))->create($transaction);

        if ($transaction->getReturnCode() == '00') {
            return $transaction->getTid();
        }

        return null;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($data, $tipo)
    {
        try {
            $store = new Store($this->PV, $this->TOKEN, Environment::production());

            // Configuração da loja em modo sandbox
            // $store = new \Rede\Store('PV', 'TOKEN', \Rede\Environment::sandbox());

            $exp = explode('/', $data->erede_card_exp);

            if (preg_match('/cartão de crédito/', $tipo)) {

                $transaction = (new Transaction(floatval($data->total + $data->taxa), 'pedido' . time()))->creditCard(
                    str_replace(' ', '', $data->erede_card_number),
                    $data->erede_card_sec,
                    $exp[0],
                    $exp[1],
                    $data->erede_card_name
                );
            } elseif (preg_match('/cartão de débito/', $tipo)) {

                $transaction = (new Transaction(floatval($data->total + $data->taxa), 'pedido' . time()))->debitCard(
                    str_replace(' ', '', $data->erede_card_number),
                    $data->erede_card_sec,
                    $exp[0],
                    $exp[1],
                    $data->erede_card_name
                );
            }

            // Autoriza a transação
            $transaction = (new eRede($store))->create($transaction);

            if ($transaction->getReturnCode() == '00') {
                return $transaction->getTid();
            }

            return null;
        } catch (\Exception $e) {
            return null;
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
        //
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
