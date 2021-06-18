<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Order;
use App\Http\Controllers\Controller;

class ReportsController extends Controller
{
    public function index()
    {

        $noTaxReport   = $this->getNoTaxReport();

        $withTaxReport = $this->getWithTaxReport();

        $totalReport   = $this->getTotalOfOrdersReport();

        $firstOrder    = $this->getFirstOrderReport();

        $neighborhood  = $this->getTotalPerNeighborhoodReport();

        $neighNoTax    = $this->getNeighborhoodNoTaxReport();

        $avgTotal      = $this->getAvgTotalReport();
        
        
        $preferPaymets      = $this->getPreferPayments();
        
        $avgTotalPerDay      = $this->getAvgPerDayReport();

        $totalOrders   = $this->getTotalOrders();

        $minDate = Carbon::today()->subDays(30);
        $maxDate = Carbon::today();

        return view('admin.reports.index', 
        compact(
            'noTaxReport', 'minDate','maxDate', 'avgTotal', 'withTaxReport', 'totalReport', 'firstOrder','preferPaymets', 
            'neighborhood', 'neighNoTax', 'totalOrders','avgTotalPerDay'
        ));
    }
 public function getAvgPerDayReport()
    {

          $minDate = Carbon::today()->subDays(30);
        $maxDate = Carbon::today();


        $total = Order::select(
            \DB::raw(
               "SUM(orders.order_total) as total, 
                COUNT(orders.id) as orders, 
                orders.created_at,
                orders.created_at
        "))
        ->join('order_status', 'orders.order_status', '=', 'order_status.id')
        ->where('order_status.status_name', '=', 'Concluído')
        ->groupBy(\DB::raw("DATE_FORMAT(orders.created_at,'%d-%b-%Y')"))
        ->whereBetween( 'orders.created_at',[ $minDate, $maxDate])
        ->get();
 
        return $total;
    }
    public function getNoTaxReport()
    {
         $minDate = Carbon::today()->subDays(30);
        $maxDate = Carbon::today();

        $noTax = Order::select(\DB::raw('SUM(orders.order_total) as total, loja.nome_loja'))
        ->join('order_status', 'orders.order_status', '=', 'order_status.id')
        ->join('loja', 'orders.order_loja_id', '=', 'loja.id')
        ->where('order_status.status_name', '=', 'Concluído')
        ->groupBy('orders.order_loja_id')
        ->whereBetween( 'orders.created_at',[ $minDate, $maxDate])
        ->get();

        return $noTax;
    }

    public function getWithTaxReport()
    {

          $minDate = Carbon::today()->subDays(30);
        $maxDate = Carbon::today();

        $withTax = Order::select(\DB::raw('SUM(orders.order_total + orders.order_tax_rate) as total, loja.nome_loja ,COUNT(orders.id) as total_orders'))
        ->join('order_status', 'orders.order_status', '=', 'order_status.id')
        ->join('loja', 'orders.order_loja_id', '=', 'loja.id')
        ->where('order_status.status_name', '=', 'Concluído')
        ->groupBy('orders.order_loja_id')
        ->whereBetween( 'orders.created_at',[ $minDate, $maxDate])
        ->get();

        return $withTax;
    }
    public function getPreferPayments()
    {

          $minDate = Carbon::today()->subDays(30);
        $maxDate = Carbon::today();

        $withTax = Order::select(\DB::raw('SUM(orders.order_total) as total, payment_methods.name_method ,COUNT(orders.id) as total_orders'))
        ->join('order_status', 'orders.order_status', '=', 'order_status.id')
        ->join('payment_methods', 'orders.order_payment_method', '=', 'payment_methods.id')
        ->where('order_status.status_name', '=', 'Concluído')
        ->groupBy('orders.order_payment_method')
        ->whereBetween( 'orders.created_at',[ $minDate, $maxDate])
        ->get();

        return $withTax;
    }

    public function getTotalOfOrdersReport()
    {

          $minDate = Carbon::today()->subDays(30);
        $maxDate = Carbon::today();
        $totalOfOrders = Order::select(\DB::raw('SUM(orders.order_total + orders.order_tax_rate) as total'))
        ->join('order_status', 'orders.order_status', '=', 'order_status.id')
        ->where('order_status.status_name', '=', 'Concluído')
        ->whereBetween( 'orders.created_at',[ $minDate, $maxDate])
        ->get();

        return $totalOfOrders->First()->total;
    }

    public function getFirstOrderReport()
    {

              $minDate = Carbon::today()->subDays(30);
        $maxDate = Carbon::today();
        $firstDate = Order::select('orders.created_at')
        ->join('order_status', 'orders.order_status', '=', 'order_status.id')
        ->where('order_status.status_name', '=', 'Concluído')
        ->whereBetween( 'orders.created_at',[ $minDate, $maxDate])
        ->orderBy('orders.id')
        ->limit(1)
        ->get();
        
            if($firstDate->First() == null){}
            else{
        return $firstDate->First()->created_at;
            }
    }

    public function getTotalPerNeighborhoodReport()
    {
          $minDate = Carbon::today()->subDays(30);
        $maxDate = Carbon::today();


        $total = Order::select(\DB::raw('SUM(orders.order_total + orders.order_tax_rate) as total, orders.order_neighborhood'))
        ->join('order_status', 'orders.order_status', '=', 'order_status.id')
        ->where('order_status.status_name', '=', 'Concluído')
        ->groupBy('orders.order_neighborhood')
        ->whereBetween( 'orders.created_at',[ $minDate, $maxDate])
        ->get();

        return $total;
    }

    public function getNeighborhoodNoTaxReport()
    {
          $minDate = Carbon::today()->subDays(30);
        $maxDate = Carbon::today();


        $total = Order::select(\DB::raw('SUM(orders.order_total) as total, orders.order_neighborhood'))
        ->join('order_status', 'orders.order_status', '=', 'order_status.id')
        ->where('order_status.status_name', '=', 'Concluído')
        ->groupBy('orders.order_neighborhood')
        ->whereBetween( 'orders.created_at',[ $minDate, $maxDate])
        ->get();

        return $total;
    }

    public function getAvgTotalReport()
    {

          $minDate = Carbon::today()->subDays(30);
        $maxDate = Carbon::today();


        $total = Order::select(
            \DB::raw(
                'AVG(orders.order_total) as "total", 
                COUNT(orders.id) as "orders", 
                orders.order_neighborhood
        '))
        ->join('order_status', 'orders.order_status', '=', 'order_status.id')
        ->where('order_status.status_name', '=', 'Concluído')
        ->groupBy('orders.order_neighborhood')
        ->whereBetween( 'orders.created_at',[ $minDate, $maxDate])
        ->get();

        return $total;
    }

    public function getTotalOrders()
    {

          $minDate = Carbon::today()->subDays(30);
        $maxDate = Carbon::today();

        $total = Order::select(
            \DB::raw(
                'COUNT(orders.id) as "total_orders", 
                order_status.status_name
                '
            )
        )
        ->join('order_status', 'orders.order_status', '=', 'order_status.id')
        ->whereIn('order_status.status_name', array('concluído', 'cancelado'))
        ->groupBy('order_status.status_name')
        ->whereBetween( 'orders.created_at',[ $minDate, $maxDate])
        ->get();

        return $total;
    }

}
