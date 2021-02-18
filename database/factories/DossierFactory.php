<?php

namespace Database\Factories;

use App\Models\Dossier;
use Illuminate\Database\Eloquent\Factories\Factory;

class DossierFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Dossier::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'num' => $this->faker->lastName,
            'prenom' => $this->faker->firstName,
            'cin' => $this->faker->swiftBicNumber,
            'mobile' => $this->faker->e164PhoneNumber,
        ];
    }
}
