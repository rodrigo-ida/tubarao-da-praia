<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\ProductPromotion;

use App\Loja;

use App\PaymentMethod;

use App\ProductCategories;

use App\Product;

use App\User;

use App\Client;

use App\LojaPaymentMethods;



class StaticMethodsController extends Controller

{



    static public function getPromotions()

    {

        return ProductPromotion::pluck('name_promotion', 'id');

    }



    static public function getLojasList()

    {

        return Loja::where('status', '=', '1')->pluck('nome_loja', 'id');

    }



    static public function getPaymentMethods()

    {

        return PaymentMethod::pluck('name_method', 'id');

    }



    static public function getAllPaymentMethods()

    {

        return LojaPaymentMethods::all();

    }



    static public function getPaymentMethodsByShop($id)

    {

        return LojaPaymentMethods::select('*')

            ->join('payment_methods', 'payment_methods_loja.payment_method_ids', '=', 'payment_methods.id')

            ->where('payment_method_loja_id', '=', $id)

            ->get()

            ->pluck('name_method', 'id');

    }



    static public function getCategories()

    {

        return ProductCategories::pluck('name_category', 'id');

    }



    static public function getUsers()

    {

        return \App\User::pluck('name', 'id');

    }



    static public function getAdminUsers()

    {

        return \App\User::whereIn('role', ['0', '1'])->pluck('name', 'id');

    }



    static public function products()

    {

        return Product::where('status_product', '=', '1')->where('product_type', '=', '0')->pluck('name_product', 'id');

    }



    static public function getUserById($id)

    {



        $user = \DB::table('users')

            ->select('*')

            ->where('client_id', '=', $id)

            ->get()->First();

        return $user;

    }



    static public function getClientById($id)

    {

        $client = \DB::table('clients')

            ->select('*')

            ->where('id', '=', $id)

            ->get()->First();



        return $client;

    }



    static function getDistance($addressFrom, $addressTo, $unit = 'km')

    {

        // Google API key

        // $apiKey = 'AIzaSyBhisVkzRYusCzvGynPWPYE2c0zzaiMCgY';



        // // Change address format

        // $formattedAddrFrom    = str_replace(' ', '+', $addressFrom);

        // $formattedAddrTo     = str_replace(' ', '+', $addressTo);



        // // Geocoding API request with start address

        // $geocodeFrom = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address=' . $formattedAddrFrom . '&sensor=false&key=' . $apiKey);

        // $outputFrom = json_decode($geocodeFrom);



        // dd($outputFrom);



        // if (!empty($outputFrom->error_message)) {

        //     return $outputFrom->error_message;

        // }



        // // Geocoding API request with end address

        // $geocodeTo = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address=' . $formattedAddrTo . '&sensor=false&key=' . $apiKey);

        // $outputTo = json_decode($geocodeTo);

        // if (!empty($outputTo->error_message)) {

        //     return $outputTo->error_message;

        // }



        // Get latitude and longitude from the geodata

        $from  = self::getLatLng($addressFrom);



        $to    = self::getLatLng($addressTo);



        if (isset($from['lat'], $from['lng']) && isset($to['lat'], $to['lng'])) {



            return self::distanceCalculation($from['lat'], $from['lng'], $to['lat'], $to['lng']);

        }

        return 0;

    }



    static public function getLatLng($address = ''): array

    {

        //$apiKey = 'AIzaSyBhisVkzRYusCzvGynPWPYE2c0zzaiMCgY';

        $apiKey = env('MAPS_KEY');



        if (!empty($address)) {

            $formattedAddrFrom    = str_replace(' ', '+', $address);

            $geocodeFrom = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address=' . $formattedAddrFrom . '&sensor=false&key=' . $apiKey);

            $outputFrom = json_decode($geocodeFrom);

            if ($outputFrom->status == 'ZERO_RESULTS') {

                return array('status' => false);

            }

            $lat = $outputFrom->results[0]->geometry->location->lat;

            $lng = $outputFrom->results[0]->geometry->location->lng;

        }



        return array(

            'lat' => $lat ?? null,

            'lng' => $lng ?? null

        );

    }



    static public function distanceCalculation($point1_lat, $point1_long, $point2_lat, $point2_long, $unit = 'km', $decimals = 3)

    {

        // Calculate the distance in degrees

        $degrees = rad2deg(acos((sin(deg2rad($point1_lat)) * sin(deg2rad($point2_lat))) + (cos(deg2rad($point1_lat)) * cos(deg2rad($point2_lat)) * cos(deg2rad($point1_long - $point2_long)))));



        // Convert the distance in degrees to the chosen unit (kilometres, miles or nautical miles)

        switch ($unit) {

            case 'km':

                $distance = $degrees * 111.13384; // 1 degree = 111.13384 km, based on the average diameter of the Earth (12,735 km)

                break;

            case 'mi':

                $distance = $degrees * 69.05482; // 1 degree = 69.05482 miles, based on the average diameter of the Earth (7,913.1 miles)

                break;

            case 'nmi':

                $distance =  $degrees * 59.97662; // 1 degree = 59.97662 nautic miles, based on the average diameter of the Earth (6,876.3 nautical miles)

        }

        return round($distance, $decimals);

    }



    static public function getDeliveryManList()

    {

        return User::with('getLoja')

            ->where('role', '=', User::ROLE_DELIVERYMAN)

            ->where('deliveryman_online', '=', '1')

            ->get();

    }

}

