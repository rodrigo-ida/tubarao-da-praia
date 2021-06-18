<?php
/**
 * Created by PhpStorm.
 * User: andre.merlo
 * Date: 14/09/2017
 * Time: 15:13
 */

namespace App\Http\Controllers\Admin;


use App\Client;
use App\Coupon;
use App\coupons_validados;
use App\Criteria\ActiveOffersCriteria;
use App\Http\Controllers\Controller;
use App\Repositories\OfferRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    /**
     * @var OfferRepository
     */
    private $repository;

    public function __construct(OfferRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $clientTotal = Client::count();
        $validatedEmails = Client::whereVerifiedEmail(true)->count();
        $percentualvalidatedEmails = $clientTotal > 0 ? ($validatedEmails * 100) / $clientTotal : 0;

        $couponTotal = Coupon::count();
        $usedCouponTotal = Coupon::whereNotNull('validation_date')->count();
        $percentualUsedCoupons = $couponTotal > 0 ? ($usedCouponTotal * 100) / $couponTotal : 0;

        //**********************************************
        // Coupons Statistics/List
        //**********************************************
        $this->repository
            ->pushCriteria(ActiveOffersCriteria::class)
            ->withCount([
                'coupons',
                'coupons AS used_coupons' => function ($query) {
                    $query->where('validation_date', '!=', 'Null');
                }
            ]);
        $offers = $this->repository->all();

        $totalCupons = 0;
        $totalUsedCupons = 0;
        $porcentagemUtilizada = 0;          
            


        foreach ($offers as $offer) {
            $totalCupons += $offer->coupons_count;
            $totalUsedCupons += $offer->used_coupons;
        }

        if ($totalCupons > 0) {
            $porcentagemUtilizada = number_format(($totalUsedCupons * 100) / $totalCupons, 2, ',', '.');
        }


        
        //**********************************************

        //**********************************************
        // Client Register Statistics
        //**********************************************
        $cidades = Client::select(DB::raw('count(*) as count, cidade, cidade as label'))
            ->groupBy('cidade')
            ->orderBy('count', 'desc')
            ->get();
        $cidades = $this->combineData($cidades, 5);

        $origem = Client::select(DB::raw('count(*) as count, origem, origem as label'))
            ->groupBy('origem')
            ->orderBy('count', 'desc')
            ->get();
        $origem = $this->combineData($origem, 5);

        $bairros = Client::select(DB::raw('count(*) as count, bairro, bairro as label'))
            ->groupBy('bairro', 'cidade')
            ->orderBy('count', 'desc')
            ->get();
        $bairros = $this->combineData($bairros, 5);

        $sexo = Client::select(DB::raw('count(*) as count, sexo as label'))
            ->groupBy('sexo')
            ->orderBy('count', 'desc')
            ->get();
        $sexo = $this->combineData($sexo, 3);

        $horaCadastro = Client::select(DB::raw('count(*) as count, HOUR(created_at) as label'))
            ->groupBy('label')
            ->orderBy('count', 'desc')
            ->get();
        $horaCadastro = $this->combineData($horaCadastro, 10);

        $ageRange = $this->generateAgeRangeData();

        $ultimosCadastros =  Client::select([
                // This aggregates the data and makes available a 'count' attribute
                DB::raw('count(id) as `count`'),
                // This throws away the timestamp portion of the date,
                DB::raw('DATE_FORMAT(created_at, "%d/%m") as `label`'),
                // This throws away the timestamp portion of the date
                DB::raw('DATE(created_at) as day')
                // Group these records according to that day
            ])->groupBy('day')
            ->where('created_at', '>=', Carbon::today()->subDays(15))
            ->get();

        $minDate = Carbon::today()->subDays(15);
        $maxDate = Carbon::today();

        //**********************************************
        //**********************************************

        return view('admin.dashboard.index', compact([
            'clientTotal',
            'validatedEmails',
            'offers',
            'cidades',
            'bairros',
            'horaCadastro',
            'sexo',
            'ageRange',
            'ultimosCadastros',
            'minDate',
            'maxDate',
            'totalCupons',
            'totalUsedCupons',
            'porcentagemUtilizada',
            'couponTotal',
            'usedCouponTotal',
            'percentualUsedCoupons',
            'percentualvalidatedEmails',
            'origem',
        ]));
    }

    public function show($id) {

        return view('admin.offers.show', compact(['offer', 'coupons']));
    }

    public function couponData(Request $request)
    {

        $intervalStart = Carbon::today()->subDays(15);
        $intervalEnd = Carbon::today();

        $created = Coupon::select(['id', 'created_at'])
            ->where('created_at', '>=', $intervalStart)
            ->orderBy('created_at')
            ->get()
            ->groupBy(function($coupon) {
                return Carbon::parse($coupon->created_at)->format('Y-m-d');
            });

        $used = Coupon::select(['id', 'validation_date'])
            ->where('validation_date', '>=', $intervalStart)
            ->orderBy('validation_date')
            ->get()
            ->groupBy(function($coupon) {
                return Carbon::parse($coupon->validation_date)->format('Y-m-d');
            });

        $items = [];

        foreach ($created as $time => $i) {
            $items[$time]['created'] = $i->count();
        }

        foreach ($used as $time => $i) {
            $items[$time]['used'] = $i->count();
        }

        $finalItems = [];
        foreach ($items as $time => $i) {
            $finalItems[] = [
                'timestamp' => Carbon::parse($time)->timestamp,
                'totals' => [
                    'created' => isset($i['created']) ? $i['created'] : 0,
                    'used' => isset($i['used']) ? $i['used'] : 0
                ]
            ];
        }

        return response()->json([
            'data' => [
                'interval' => [
                    'start' => $intervalStart->getTimestamp(),
                    'end' => $intervalEnd->getTimestamp(),
                ],
                'items' => $finalItems,
            ]
        ]);
    }

    private function combineData($data, $limit) {
        if ($data->count() > $limit) {
            $slice = $data->slice($limit);
            $data = $data->slice(0, $limit);
            $otherTotals = 0;
            $slice->each(function ($item, $key) use (&$otherTotals) {
                $otherTotals += $item->count;
            });
            $others = new \stdClass();
            $others->label = 'Outras';
            $others->count = $otherTotals;
            $data->push($others);
        }
        return $data;
    }

    /**
     * @param $ageRange
     */
    protected function generateAgeRangeData()
    {
        $ageRange[0] = Client::select(DB::raw('count(*) as count, \'0-18\' as label'))
            ->where('data_nasc', '>=', Carbon::today()->addDay()->subYears(19))
            ->first();

        $ageRange[1] = Client::select(DB::raw('count(*) as count, \'19-24\' as label'))
            ->whereBetween('data_nasc', [Carbon::today()->addDay()->subYears(25), Carbon::today()->subYears(19)])
            ->first();

        $ageRange[2] = Client::select(DB::raw('count(*) as count, \'25-34\' as label'))
            ->whereBetween('data_nasc', [Carbon::today()->addDay()->subYears(35), Carbon::today()->subYears(25)])
            ->first();

        $ageRange[3] = Client::select(DB::raw('count(*) as count, \'35-44\' as label'))
            ->whereBetween('data_nasc', [Carbon::today()->addDay()->subYears(45), Carbon::today()->subYears(35)])
            ->first();

        $ageRange[4] = Client::select(DB::raw('count(*) as count, \'45-54\' as label'))
            ->whereBetween('data_nasc', [Carbon::today()->addDay()->subYears(55), Carbon::today()->subYears(45)])
            ->first();

        $ageRange[5] = Client::select(DB::raw('count(*) as count, \'55-64\' as label'))
            ->whereBetween('data_nasc', [Carbon::today()->addDay()->subYears(65), Carbon::today()->subYears(55)])
            ->first();

        $ageRange[6] = Client::select(DB::raw('count(*) as count, \'+65\' as label'))
            ->where('data_nasc', '!=', '0000-00-00')
            ->where('data_nasc', '<=', Carbon::today()->addDay()->subYears(65))
            ->first();

        $ageRange[7] = Client::select(DB::raw('count(*) as count, \'não definido\' as label'))
            ->whereNull('data_nasc')
            ->first();

        return $ageRange;
    }
}