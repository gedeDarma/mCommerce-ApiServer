<?php

use Illuminate\Database\Seeder;
use App\Product;

class ProductTableSeeder extends Seeder
{
    public function run()
    {
        Product::truncate();

        //#1
        Product::create([
            'category_id' => '1',
            'name' => 'Nourish Life Chicken, Kitten & Adult Cat 4 Lbs',
            'description' => 'Makanan ini terbuat dari daging olahan terbaik dan bersumber dari ikan dan ayam yang kaya nutrisi',
            'price' => '230000',
            'stock' => '15',
            'remark' => '{"note":"-"}'
        ]);

        //#2
        Product::create([
            'category_id' => '2',
            'name' => 'PM Sky Kennel 90-125 Lbs',
            'description' => 'Kandang pet cargo merk aspenpet size besar',
            'price' => '6000000',
            'stock' => '5',
            'remark' => '{"note":"-"}'
        ]);

        //#3
        Product::create([
            'category_id' => '3',
            'name' => 'M.Food Toy',
            'description' => 'Mainan yang berbentuk seperti senter dan diisikan makanan untuk anjing bermain',
            'price' => '65000',
            'stock' => '30',
            'remark' => '{"note":"-"}'
        ]);

        //#4
        Product::create([
            'category_id' => '4',
            'name' => 'Forbis Aloe Shampoo 550 Ml',
            'description' => 'Shampoo untuk anjing dan kucing',
            'price' => '190000',
            'stock' => '10',
            'remark' => '{"note":"-"}'
        ]);

        //#5
        Product::create([
            'category_id' => '5',
            'name' => 'Fish Oil Plus 60 Tab',
            'description' => 'Supplemen yang dibuat dari squalence dan minyak salmon omega 3 yang berfungsi untuk menjaga kilau bulu',
            'price' => '45000',
            'stock' => '50',
            'remark' => '{"note":"-"}'
        ]);
        
        //#6
        Product::create([
            'category_id' => '1',
            'name' => 'Bolt Dog Beef Flavour 20 Kg',
            'description' => 'Makanan anjing dengan rasa daging sapi',
            'price' => '270000',
            'stock' => '10',
            'remark' => '{"note":"-"}'
        ]);
    }
}
