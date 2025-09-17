<?php

namespace Database\Factories;

use App\Models\ProgramRegistration;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProgramRegistration>
 */
class ProgramRegistrationFactory extends Factory
{
  protected $model = ProgramRegistration::class;

  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    $programTypes = ['training_program', 'market_access_program', 'community_program'];
    $programType = $this->faker->randomElement($programTypes);

    return [
      'program_type' => $programType,
      'program_id' => $this->faker->numberBetween(1, 5),
      'user_name' => $this->faker->name(),
      'email' => $this->faker->safeEmail(),
      'phone' => $this->faker->numerify('+93 7# ### ####'),
      'location' => $this->faker->randomElement([
        'Kabul',
        'Herat',
        'Mazar-i-Sharif',
        'Kandahar',
        'Jalalabad',
        'Kunduz',
        'Ghazni',
        'Bamyan',
        'Farah',
        'Balkh'
      ]),
      'status' => $this->faker->randomElement(['pending', 'approved', 'rejected', 'completed']),
      'registration_date' => $this->faker->dateTimeBetween('-3 months', 'now'),
      'created_at' => $this->faker->dateTimeBetween('-3 months', 'now'),
    ];
  }

  public function pending(): static
  {
    return $this->state(fn(array $attributes) => [
      'status' => 'pending',
    ]);
  }

  public function approved(): static
  {
    return $this->state(fn(array $attributes) => [
      'status' => 'approved',
    ]);
  }

  public function completed(): static
  {
    return $this->state(fn(array $attributes) => [
      'status' => 'completed',
    ]);
  }

  public function forTrainingProgram(): static
  {
    return $this->state(fn(array $attributes) => [
      'program_type' => 'training_program',
    ]);
  }

  public function forCommunityProgram(): static
  {
    return $this->state(fn(array $attributes) => [
      'program_type' => 'community_program',
    ]);
  }
}
