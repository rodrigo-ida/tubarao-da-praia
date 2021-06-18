<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\DeliveryConfig;
use App\Http\Controllers\StaticMethodsController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class DeliveryConfigController extends Controller
{
    public function index()
    {

        $configs = DeliveryConfig::select('*')
        ->with(['getLoja'])
        ->paginate(15);

        return view('admin.deliveryconfigs.index', compact('configs'));
    }

    public function create()
    {
        $horas = DeliveryConfig::getHours();

        $lojas = StaticMethodsController::getLojasList();

        return view('admin.deliveryconfigs.create',compact('horas', 'lojas'));
    }

    public function store(Request $request)
    {
        $data   = $request->all(); 

        $serializedHours = $this->serializeDayHours($data);

        for($i = 0; $i < 7; $i++)
        {
            if($i == 0)
            {

                $data['config_date'] = 'segunda-feira';
                $data['config_time'] = $serializedHours[$i]['hora'];
                $data['config_time_end'] = $serializedHours[$i]['hora_final'];

            }
            elseif($i == 1)
            {

                $data['config_date'] = 'terca-feira';
                $data['config_time'] = $serializedHours[$i]['hora'];
                $data['config_time_end'] = $serializedHours[$i]['hora_final'];

            }
            elseif($i == 2)
            {

                $data['config_date'] = 'quarta-feira';
                $data['config_time'] = $serializedHours[$i]['hora'];
                $data['config_time_end'] = $serializedHours[$i]['hora_final'];

            }
            elseif($i == 3)
            {

                $data['config_date'] = 'quinta-feira';
                $data['config_time'] = $serializedHours[$i]['hora'];
                $data['config_time_end'] = $serializedHours[$i]['hora_final'];

            }
            elseif($i == 4)
            {

                $data['config_date'] = 'sexta-feira';
                $data['config_time'] = $serializedHours[$i]['hora'];
                $data['config_time_end'] = $serializedHours[$i]['hora_final'];

            }
            elseif($i == 5)
            {

                $data['config_date'] = 'sabado';
                $data['config_time'] = $serializedHours[$i]['hora'];
                $data['config_time_end'] = $serializedHours[$i]['hora_final'];

            }
            elseif($i == 6)
            {

                $data['config_date'] = 'domingo';
                $data['config_time'] = $serializedHours[$i]['hora'];
                $data['config_time_end'] = $serializedHours[$i]['hora_final'];

            }

            $conf   = new DeliveryConfig();
            
            $conf->fill($data); 

            $conf->save();
        }
        
        return redirect()->route('admin.lojadeliveryconfig.index');
    }
    
    public function serializeDayHours($data)
    {
        $date = [];
        for($i = 0; $i < 7; $i++)
        {

            $date[$i] = ['hora' => $data['config_time'][$i], 'hora_final' => $data['config_time_end'][$i]];

        }

        return $date;

    }

    public function edit($id)
    {

        $config  = DeliveryConfig::find($id);

        $horas   = DeliveryConfig::getHours();

        $lojas   = StaticMethodsController::getLojasList();

        return view('admin.deliveryconfigs.edit', compact('config', 'lojas', 'horas'));

    }

    public function update(Request $request, $id)
    {

        $config = DeliveryConfig::findOrFail($id);

        $data   = $request->all();

        $config->fill($data);

        $config->save();

        return redirect()->back();

        return redirect()->route('admin.lojadeliveryconfig.index');
    }

}
