<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bill>
 */
class BillFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition()
	{
		return [
			'name' => $this->faker->firstName(),
			'user_id' => rand(1, 2),
			'category_id' => rand(1, 10),
			'subcategory_id' => rand(1, 10),
			'amount' => rand(0.1, 250),
			'paid' => rand(0, 1),
			'due_date' => now()->addDays(rand(10, 30)),
		];
	}
}
