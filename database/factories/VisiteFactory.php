<?php

namespace Database\Factories;

use App\Models\Visite;
use Illuminate\Database\Eloquent\Factories\Factory;

class VisiteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Visite::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date' => $this->faker->dateTimeBetween($startDate = '-180 days', $endDate = 'now'),
            'detail' => $this->faker->realText($maxNbChars = 200, $indexSize = 2),
            'remarqueClient' => $this->faker->realText($maxNbChars = 200, $indexSize = 2),
        ];
    }
}
/*Client::factory()->count(20)->create()->each(function($client) {$client->visites()->save(Visite::factory()->create());})
Client::factory()->count(20)->for($user)->has(Visite::factory()->create())->create()
Visite::factory()->count(20)->for($user)->for(Client::factory()->count(20))->create();
Visite::factory()->count(20)->for($user)->for($client)->create();*/
