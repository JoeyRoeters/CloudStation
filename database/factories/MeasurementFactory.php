<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Measurement>
 */
class MeasurementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $temperature = 10;

        return [
            'temperature' => $this->faker->randomFloat(1, $temperature, $temperature + 3),
            'dew_point_temperature' => $this->faker->randomFloat(1, 20, 25),
            'station_air_pressure' => $this->faker->randomFloat(1, 1000, 1030),
            'sea_level_pressure' => $this->faker->randomFloat(1, 1000, 1030),
            'visibility' => $this->faker->randomFloat(1, 15, 20),
            'wind_speed' => $this->faker->randomFloat(1, 20, 30),
            'precipitation' => $this->faker->randomFloat(1, 0.5, 1),
            'snow_depth' => 0,
            'cloud_cover' => $this->faker->randomFloat(1, 50, 80),
            'weather_condition' => 000000,
            'wind_direction' => $this->faker->numberBetween(0, 50),
        ];
    }
}
