<?php

namespace App\Http\Controllers\Deliveryman;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Support\Facades\Auth;
use App\DeliverymanTime;
use App\User;

class DeliveryManController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()) {

            $deliveryManLogged = User::with('getLoja')->where('id', '=', Auth::user()->id)->get();

            if (isset($deliveryManLogged)) {

                $orders = Order::select('*', 'orders.id', 'orders.created_at')
                    ->join('clients', 'orders.order_client_id', '=', 'clients.id')
                    ->join('order_status', 'orders.order_status', '=', 'order_status.id')
                    ->with('getLoja')
                    ->with('getPaymentMethod')
                    ->whereIn('order_status.status_name', ['Pendente', 'Em Entrega'])
                    ->where('orders.deliveryman_id', '=', $deliveryManLogged->First()->id)
                    ->orderBy('orders.id', 'desc')
                    ->get();


                $devManStatistics = $this->getDeliveryManStatisticsDay($deliveryManLogged->First()->id);

                return view('deliveryman.index', compact('deliveryManLogged', 'orders', 'devManStatistics'));
            }
        }
        return redirect('admin/login');
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
        //
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

    public function getDeliveryManStatisticsDay($id)
    {
        $data = [
            'totalDeliveredToday' => Order::select('*', 'orders.id', 'orders.created_at')
                ->join('order_status', 'orders.order_status', '=', 'order_status.id')
                ->with('getLoja')
                ->where('order_status.status_name', 'LIKE', '%Pendente%')
                ->where('orders.deliveryman_id', '=', $id)
                ->where('orders.created_at', 'LIKE', '%' . date("Y-m-d") . '%')
                ->orderBy('orders.id', 'desc')
                ->sum('orders.order_tax_rate'),
            'Day' => date('d/m/Y')
        ];

        return $data;
    }

    public function delivered(Request $request)
    {
        $order = Order::findOrFail($request->all()['id']);

        if (isset($order)) {

            $data = [
                'order_status' => 6,
                'order_dev_time' => (new \DateTime("now"))->format('H:i:s'),
            ];

            $order->fill($data);

            $order->save();

            $ex = explode(',', $request->all()['latLng']);

            $time = DeliverymanTime::where('order_id', '=', $order->id)->update([
                'updated_at' => new \DateTime("now"),
                'lat' => $ex[0],
                'lng' => $ex[1]
            ]);

            return json_encode(['status_code' => 200, 'msg' => 'Pedido entregue com sucesso!']);
        }

        return json_encode(['status_code' => 400, 'msg' => 'Não foi possível concluir o pedido, tente novamente mais tarde!']);
    }

    public function online(Request $request)
    {
        $data = $request->all();

        try {

            if (isset($data['id'], $data['deliveryman_online'])) {

                $user = User::findOrFail($data['id']);

                if (isset($user)) {
                    $user->fill(['deliveryman_online' => $data['deliveryman_online']]);

                    $user->save();

                    return response()->json(['status' => 200]);
                }
            }
        } catch (\Exception $e) {
            //throw $th;
            return response()->json(['status' => 400, 'msg' => $e]);
        }
    }

    public function updateLocation(Request $request)
    {
        try {
            if (isset($request->all()['latLng'], $request->all()['id'])) {

                $ex = explode(',', $request->all()['latLng']);

                $user = User::where('id', '=', $request->all()['id'])->update([
                    'updated_at' => new \DateTime("now"),
                    'lat' => $ex[0],
                    'lng' => $ex[1]
                ]);

                return response()->json(['status' => 200, 'msg' => 'success']);
            }

            return response()->json(['status' => 400, 'msg' => 'invalid parameters']);
        } catch (\Exception $e) {

            return response()->json(['status' => 400, 'msg' => $e]);
        }
    }
}
