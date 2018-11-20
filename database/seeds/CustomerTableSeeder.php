<?php

use Illuminate\Database\Seeder;
use App\Customer;

class CustomerTableSeeder extends Seeder
{
    public function run()
    {
        Customer::truncate();

        //#1
        Customer::create([
            'fullname' => 'Gede Darma Arista',
            'username' => 'darma',
            'password' => 'darma123',
            'email' => 'de.darma.damuh@gmail.com',
            'phone' => '081927251656',
            'address' => 'Jl. Tukad Balian Gg. Bule No. 7, Sidakarya, Denpasar',
            'remark' => '{"note":"-"}'
        ]);
    }
}
