<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $size = [
            'S',
            'M',
            'L'
        ];

        return [
            'name'          => $this->faker->unique()->company(),
            'inventory'     => $this->faker->numberBetween(0, 100),
            'description'   => $this->faker->paragraph(2, false),
            'size'          => $size[random_int(0, 2)],
            'boarding'      => $this->faker->date('Y-m-d'),
            'brand_id'      => Brand::all()->random()->id,
        ];
    }
}
