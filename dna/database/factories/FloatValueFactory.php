<?php

namespace Database\Factories;

use App\Models\FloatValue;
use Illuminate\Database\Eloquent\Factories\Factory;

class FloatValueFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FloatValue::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {   
        
        return [
            'value1' => $this->faker->randomFloat(null, 1,100),
            'value2' => $this->faker->randomFloat(null, 1,100)
        ];
    }

    public function init($attributes){
        print_r($attributes);
    }

}
