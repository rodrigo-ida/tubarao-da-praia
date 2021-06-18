<?php

/**
 * Created by PhpStorm.
 * User: andre.merlo
 * Date: 14/09/2017
 * Time: 15:13
 */

namespace App\Http\Controllers\Admin;


use App\Client;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ClientsController extends Controller
{

    /**
     * @var Client
     */
    private $model;

    public function __construct(Client $model)
    {
        $this->model = $model;
    }

    public function index(Request $request)
    {
        $searchTerm = $request->get('search', null);

        $searchable = [
            'nome', 'email', 'whatsapp', 'origem'
        ];

        $query = $this->model->orderBy('created_at', 'desc');



        if (!is_null($searchTerm)) {
            $searchTerms = explode(' ', $searchTerm);
            foreach ($searchTerms as $term) {
                $query->where(function ($query) use ($term, $searchable) {
                    foreach ($searchable as $attribute) {
                        $query->orWhere($attribute, 'like', sprintf('%%%s%%', $term));
                    }
                });
            }
        }

        /* @var $paginator LengthAwarePaginator */
        $paginator = $query->paginate()->appends('search', $searchTerm);

        $clients = new Collection($paginator->items());

        $viewData = compact(['clients', 'paginator', 'searchTerm']);
        return view('admin.clients.index', $viewData);
    }

    public function show($id)
    {
        /* @var $client Client */
        $client = $this->model->findOrFail($id);
        return view('admin.clients.show', compact(['client']));
    }

    public function export()
    {
        $table = Client::select(
            'nome',
            'email',
            'whatsapp',
            'cep',
            'estado',
            'cidade',
            'logradouro',
            'bairro',
            'numero',
            'complemento',
            'sexo',
            'origem',
            'sobrenome'
        )->get();

        $path = public_path() . '/clients.csv';

        $file = fopen('clients.csv', 'w');

        foreach ($table as $row) {
            fputcsv($file, $row->toArray());
        }

        fclose($file);

        // $headers = array(
        //     'Content-Type: application/csv',
        // );

        return \Response::download($path)->deleteFileAfterSend(true);
    }
}
