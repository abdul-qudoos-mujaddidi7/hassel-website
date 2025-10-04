<?php

namespace Database\Factories;

use App\Models\JobAnnouncement;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobAnnouncement>
 */
class JobAnnouncementFactory extends Factory
{
  protected $model = JobAnnouncement::class;

  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    $title = $this->faker->randomElement([
      'Agricultural Development Officer',
      'Field Coordinator',
      'Training Specialist',
      'Project Manager',
      'Agricultural Engineer',
      'Community Liaison Officer',
      'Data Analyst',
      'Financial Officer',
      'Marketing Specialist',
      'IT Support Specialist',
      'Research Assistant',
      'Program Coordinator',
    ]);

    return [
      'title' => $title,
      'slug' => \Illuminate\Support\Str::slug($title . '-' . $this->faker->unique()->randomNumber(4)),
      'description' => $this->generateJobDescription($title),
      'requirements' => $this->generateRequirements(),
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
        'Remote'
      ]),
      'salary_range' => $this->generateSalaryRange(),
      'deadline' => $this->faker->dateTimeBetween('now', '+2 months'),
      'status' => $this->faker->randomElement(['open', 'draft', 'close']),
      'opened_at' => $this->faker->optional(0.8)->dateTimeBetween('-1 month', 'now'),
      'created_at' => $this->faker->dateTimeBetween('-2 months', 'now'),
    ];
  }

  /**
   * Generate job description
   */
  private function generateJobDescription(string $title): string
  {
    return "Mount Agro Institution is seeking a dedicated {$title} to join our team and contribute to agricultural development in Afghanistan. " .
      "This position offers an opportunity to make a meaningful impact on rural communities while working with a passionate team of professionals. " .
      "The successful candidate will work closely with farmers, local communities, and international partners to implement sustainable agricultural practices and programs.";
  }

  /**
   * Generate job requirements
   */
  private function generateRequirements(): string
  {
    $requirements = [
      "Bachelor's degree in Agriculture, Development Studies, or related field",
      "Minimum 2-3 years of relevant work experience",
      "Strong communication skills in English and local languages",
      "Experience working with rural communities",
      "Knowledge of agricultural practices and modern farming techniques",
      "Ability to work in challenging field conditions",
      "Valid driver's license and willingness to travel",
      "Computer literacy (MS Office, data analysis tools)",
    ];

    return implode("\n", $this->faker->randomElements($requirements, $this->faker->numberBetween(4, 6)));
  }

  /**
   * Generate salary range
   */
  private function generateSalaryRange(): string
  {
    return $this->faker->randomElement([
      '$30,000 - $50,000',
      '$40,000 - $60,000',
      '$50,000 - $70,000',
      '$60,000 - $80,000',
      '$70,000 - $100,000',
      'Competitive salary',
      'Negotiable based on experience'
    ]);
  }

  /**
   * State for open positions
   */
  public function open(): static
  {
    return $this->state(fn(array $attributes) => [
      'deadline' => $this->faker->dateTimeBetween('now', '+2 months'),
      'status' => 'open',
      'opened_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
    ]);
  }

  /**
   * State for closed positions
   */
  public function closed(): static
  {
    return $this->state(fn(array $attributes) => [
      'deadline' => $this->faker->dateTimeBetween('-2 months', 'now'),
      'status' => 'closed',
      'opened_at' => $this->faker->dateTimeBetween('-3 months', '-1 month'),
    ]);
  }

  /**
   * State for different job types
   */
  public function fullTime(): static
  {
    return $this->state(fn(array $attributes) => [
      'salary_range' => $this->faker->randomElement([
        '$50,000 - $70,000',
        '$60,000 - $80,000',
        '$70,000 - $100,000'
      ]),
    ]);
  }

  public function contract(): static
  {
    return $this->state(fn(array $attributes) => [
      'salary_range' => $this->faker->randomElement([
        '$35,000 - $50,000',
        '$40,000 - $60,000',
        'Negotiable based on experience'
      ]),
    ]);
  }

  public function draft(): static
  {
    return $this->state(fn(array $attributes) => [
      'status' => 'draft',
      'opened_at' => null,
    ]);
  }
}
