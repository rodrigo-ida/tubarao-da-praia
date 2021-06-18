<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/delivery/finalizar-pedido',
        '/admin/order/export',
        '/delivery/finalizar/cadclient',
        'delivery/finalizar/recu-email',
        '/delivery/selecionar-loja',
        '/delivery/selecionar-cep',
        '/delivery/loja/produto/comboVariacoes'
    ];
}
