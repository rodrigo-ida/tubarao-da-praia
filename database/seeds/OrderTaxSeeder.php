<?php

use Illuminate\Database\Seeder;
use App\OrderTax;

class OrderTaxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ceps = 
        [
            [

                'order_tax_cep_inicial'  => '11701390',
                'order_tax_cep_final'    => '11702340',
                'order_tax_status'       => '0',
                'order_tax_loja_id'      => 1,
                'order_tax_price'        => 0.00,
                'order_tax_neighborhood' => 'Guilhermina'

            ],
            [

                'order_tax_cep_inicial'  => '11724000',
                'order_tax_cep_final'    => '11726120',
                'order_tax_status'       => '0',
                'order_tax_loja_id'      => 1,
                'order_tax_price'        => 0.00,
                'order_tax_neighborhood' => 'Sítio do Campo'

            ],
            [

                'order_tax_cep_inicial'  => '11724150',
                'order_tax_cep_final'    => '11721280',
                'order_tax_status'       => '0',
                'order_tax_loja_id'      => 1,
                'order_tax_price'        => 0.00,
                'order_tax_neighborhood' => 'Glória'

            ],
            [

                'order_tax_cep_inicial'  => '11720000',
                'order_tax_cep_final'    => '11721250',
                'order_tax_status'       => '0',
                'order_tax_loja_id'      => 1,
                'order_tax_price'        => 0.00,
                'order_tax_neighborhood' => 'Antártica'

            ],
            [

                'order_tax_cep_inicial'  => '11713280',
                'order_tax_cep_final'    => '11713650',
                'order_tax_status'       => '0',
                'order_tax_loja_id'      => 1,
                'order_tax_price'        => 0.00,
                'order_tax_neighborhood' => 'Esmeralda'

            ],
            [

                'order_tax_cep_inicial'  => '11708525',
                'order_tax_cep_final'    => '11708170',
                'order_tax_status'       => '0',
                'order_tax_loja_id'      => 1,
                'order_tax_price'        => 0.00,
                'order_tax_neighborhood' => 'Flórida'

            ],
            [

                'order_tax_cep_inicial'  => '11714000',
                'order_tax_cep_final'    => '11715000',
                'order_tax_status'       => '0',
                'order_tax_loja_id'      => 1,
                'order_tax_price'        => 0.00,
                'order_tax_neighborhood' => 'Ribeirópolis'

            ],
            [

                'order_tax_cep_inicial'  => '11705330',
                'order_tax_cep_final'    => '11705755',
                'order_tax_status'       => '0',
                'order_tax_loja_id'      => 1,
                'order_tax_price'        => 0.00,
                'order_tax_neighborhood' => 'Maracanã'

            ],
            [

                'order_tax_cep_inicial'  => '11706000',
                'order_tax_cep_final'    => '11706005',
                'order_tax_status'       => '0',
                'order_tax_loja_id'      => 1,
                'order_tax_price'        => 0.00,
                'order_tax_neighborhood' => 'Balneário Paqueta'

            ],
            [

                'order_tax_cep_inicial'  => '11700005',
                'order_tax_cep_final'    => '11701380',
                'order_tax_status'       => '0',
                'order_tax_loja_id'      => 1,
                'order_tax_price'        => 0.00,
                'order_tax_neighborhood' => 'Boqueirão'

            ],
            [

                'order_tax_cep_inicial'  => '11702350',
                'order_tax_cep_final'    => '11702860',
                'order_tax_status'       => '0',
                'order_tax_loja_id'      => 1,
                'order_tax_price'        => 0.00,
                'order_tax_neighborhood' => 'Aviação'

            ],
            [

                'order_tax_cep_inicial'  => '11700140',
                'order_tax_cep_final'    => '11700870',
                'order_tax_status'       => '0',
                'order_tax_loja_id'      => 1,
                'order_tax_price'        => 0.00,
                'order_tax_neighborhood' => 'Canto do Forte'

            ],
            [

                'order_tax_cep_inicial'  => '11710000',
                'order_tax_cep_final'    => '11710340',
                'order_tax_status'       => '0',
                'order_tax_loja_id'      => 1,
                'order_tax_price'        => 0.00,
                'order_tax_neighborhood' => 'Cidade da Criança'

            ],
            [

                'order_tax_cep_inicial'  => '11704050',
                'order_tax_cep_final'    => '11704595',
                'order_tax_status'       => '0',
                'order_tax_loja_id'      => 1,
                'order_tax_price'        => 0.00,
                'order_tax_neighborhood' => 'Ocian'

            ],
            [

                'order_tax_cep_inicial'  => '11724650',
                'order_tax_cep_final'    => '11724700',
                'order_tax_status'       => '0',
                'order_tax_loja_id'      => 1,
                'order_tax_price'        => 0.00,
                'order_tax_neighborhood' => 'Ilha das Caieiras'

            ],
            [

                'order_tax_cep_inicial'  => '11718130',
                'order_tax_cep_final'    => '11717290',
                'order_tax_status'       => '0',
                'order_tax_loja_id'      => 1,
                'order_tax_price'        => 0.00,
                'order_tax_neighborhood' => 'Anhanguera'

            ],
            [

                'order_tax_cep_inicial'  => '11711380',
                'order_tax_cep_final'    => '11711790',
                'order_tax_status'       => '0',
                'order_tax_loja_id'      => 1,
                'order_tax_price'        => 0.00,
                'order_tax_neighborhood' => 'Imperador'

            ],
            [

                'order_tax_cep_inicial'  => '11707190',
                'order_tax_cep_final'    => '11708160',
                'order_tax_status'       => '0',
                'order_tax_loja_id'      => 1,
                'order_tax_price'        => 0.00,
                'order_tax_neighborhood' => 'Real'

            ],
            [

                'order_tax_cep_inicial'  => '11712000',
                'order_tax_cep_final'    => '11712380',
                'order_tax_status'       => '0',
                'order_tax_loja_id'      => 1,
                'order_tax_price'        => 0.00,
                'order_tax_neighborhood' => 'Melvi'

            ],
            [

                'order_tax_cep_inicial'  => '11711000',
                'order_tax_cep_final'    => '11712000',
                'order_tax_status'       => '0',
                'order_tax_loja_id'      => 1,
                'order_tax_price'        => 0.00,
                'order_tax_neighborhood' => 'Princesa'

            ],
            [

                'order_tax_cep_inicial'  => '11718135',
                'order_tax_cep_final'    => '11718380',
                'order_tax_status'       => '0',
                'order_tax_loja_id'      => 1,
                'order_tax_price'        => 0.00,
                'order_tax_neighborhood' => 'Quietude'

            ],
            [

                'order_tax_cep_inicial'  => '11712400',
                'order_tax_cep_final'    => '11713270',
                'order_tax_status'       => '0',
                'order_tax_loja_id'      => 1,
                'order_tax_price'        => 0.00,
                'order_tax_neighborhood' => 'Samambaia'

            ],
            [

                'order_tax_cep_inicial'  => '11709000',
                'order_tax_cep_final'    => '11709490',
                'order_tax_status'       => '0',
                'order_tax_loja_id'      => 1,
                'order_tax_price'        => 0.00,
                'order_tax_neighborhood' => 'Solemar'

            ],
            [

                'order_tax_cep_inicial'  => '11706010',
                'order_tax_cep_final'    => '11707180',
                'order_tax_status'       => '0',
                'order_tax_loja_id'      => 1,
                'order_tax_price'        => 0.00,
                'order_tax_neighborhood' => 'Caiçara'

            ],
            [

                'order_tax_cep_inicial'  => '11701390',
                'order_tax_cep_final'    => '11702340',
                'order_tax_status'       => '0',
                'order_tax_loja_id'      => 1,
                'order_tax_price'        => 0.00,
                'order_tax_neighborhood' => 'Guilhermina'

            ],
            [

                'order_tax_cep_inicial'  => '11704600',
                'order_tax_cep_final'    => '11705260',
                'order_tax_status'       => '0',
                'order_tax_loja_id'      => 1,
                'order_tax_price'        => 0.00,
                'order_tax_neighborhood' => 'Mirim'

            ],
            [

                'order_tax_cep_inicial'  => '11722000',
                'order_tax_cep_final'    => '11723260',
                'order_tax_status'       => '0',
                'order_tax_loja_id'      => 1,
                'order_tax_price'        => 0.00,
                'order_tax_neighborhood' => 'Vila Sonia'

            ],
            [

                'order_tax_cep_inicial'  => '11703000',
                'order_tax_cep_final'    => '11704040',
                'order_tax_status'       => '0',
                'order_tax_loja_id'      => 1,
                'order_tax_price'        => 0.00,
                'order_tax_neighborhood' => 'Tupi'

            ],
            [

                'order_tax_cep_inicial'  => '11719000',
                'order_tax_cep_final'    => '11724740',
                'order_tax_status'       => '0',
                'order_tax_loja_id'      => 1,
                'order_tax_price'        => 0.00,
                'order_tax_neighborhood' => 'Tupiry'

            ],
            [

                'order_tax_cep_inicial'  => '11717000',
                'order_tax_cep_final'    => '11717285',
                'order_tax_status'       => '0',
                'order_tax_loja_id'      => 1,
                'order_tax_price'        => 0.00,
                'order_tax_neighborhood' => 'Nova Mirim'

            ],
            
        ];

        for($i = 0; $i < count($ceps); $i++)
        {
            
            DB::table('order_tax')->insert($ceps[$i]);

        }
    }
}
