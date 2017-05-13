<?php

use Illuminate\Database\Seeder;

class PurposesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $purposes = ['Withdraw', 'Deposit', 'Transfer', 'Service Charge'];

        foreach( $purposes as $purpose ){
            DB::table('purposes')->insert([
                'name' => $purpose,
            ]);
        }
    }
}
