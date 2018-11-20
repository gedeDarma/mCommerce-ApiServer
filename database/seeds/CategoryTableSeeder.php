<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategoryTableSeeder extends Seeder
{
    public function run()
    {
        Category::truncate();

        //#1
        Category::create([
            'name' => 'Food',
            'remark' => '{"note":"-"}'
        ]);

        //#2
        Category::create([
            'name' => 'Accesories',
            'remark' => '{"note":"-"}'
        ]);

        //#3
        Category::create([
            'name' => 'Toys',
            'remark' => '{"note":"-"}'
        ]);

        //#4
        Category::create([
            'name' => 'Grooming',
            'remark' => '{"note":"-"}'
        ]);

        //#5
        Category::create([
            'name' => 'Health Care',
            'remark' => '{"note":"-"}'
        ]);
    }
}
