<?php

namespace Tests\Feature;

use App\Models\FloatValue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SetAndGetValue extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testFloatValue()
    {

        $all = FloatValue::all();

        foreach ($all as $pair) {
            print_r($pair->attributes);
        }
    }

    public function testFind()
    {

        $pairs = FloatValue::find([1, 4]);

        foreach ($pairs as $pair)
            print_r($pair->getAttributes());
    }

    public function testInsert()
    {

        $pair = new FloatValue();

        $pair->value1 = 100;
        $pair->value2 = 100;

        $insert_array[] = $pair;

        foreach ($insert_array as $insert) {
            print_r($insert->getAttributes());
            $insert->save();
        }
    }

    public function testDelete()
    {

        $pairs = FloatValue::where('value1', '>=', 100)->get();
        //$pairs = FloatValue::whereColumn('value1', 'value2')->get();

        foreach ($pairs as $pair) {
            print_r($pair->getAttributes());
            $pair->delete();
        }
    }

    public function testFactory()
    {
        $faker = \Faker\Factory::create();
        $row = array();

        for ($i = 1; $i <= 5; $i++) {
            $row[] = [
                'value1' => $faker->randomFloat(null, 1, 100),
                'value2' => $faker->randomFloat(null, 1, 100)
            ];
        }
        $pairs = FloatValue::factory()->createMany($row);
        print_r($row);

        /*foreach($pairs as $pair)
            print_r($pair->getAttributes());*/
    }
}
