<?php

namespace Database\Factories;

use App\Models\Publication;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Publication>
 */
class PublicationFactory extends Factory
{
  protected $model = Publication::class;

  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    $title = $this->faker->sentence(4, true);
    $fileTypes = ['report', 'manual', 'guideline', 'policy', 'research'];
    $fileType = $this->faker->randomElement($fileTypes);

    return [
      'title' => $title,
      'slug' => \Illuminate\Support\Str::slug($title),
      'description' => $this->faker->text(300),
      'file_path' => $this->generateFilePath($fileType),
      'file_type' => $fileType,
      'status' => $this->faker->randomElement(['published', 'draft']),
      'published_at' => $this->faker->optional(0.7)->dateTimeBetween('-2 years', 'now'),
      'created_at' => $this->faker->dateTimeBetween('-2 years', 'now'),
    ];
  }

  /**
   * Generate realistic file path
   */
  private function generateFilePath(string $type): string
  {
    $filename = $this->faker->slug(3) . '_' . time() . '_' . $this->faker->randomElement(['report', 'guide', 'manual']) . '.pdf';
    return "publications/{$type}s/" . date('Y/m') . "/{$filename}";
  }

  /**
   * State for different file types
   */
  public function report(): static
  {
    return $this->state(fn(array $attributes) => [
      'file_type' => 'report',
      'title' => $this->faker->randomElement([
        'Annual Agricultural Development Report',
        'Crop Yield Analysis Report',
        'Rural Community Impact Assessment',
        'Irrigation Systems Effectiveness Study',
        'Food Security Status Report',
      ]),
    ]);
  }

  public function manual(): static
  {
    return $this->state(fn(array $attributes) => [
      'file_type' => 'manual',
      'title' => $this->faker->randomElement([
        'Sustainable Farming Practices Manual',
        'Irrigation Management Handbook',
        'Crop Protection Guidelines',
        'Post-Harvest Handling Manual',
        'Organic Farming Techniques Guide',
      ]),
    ]);
  }

  public function guideline(): static
  {
    return $this->state(fn(array $attributes) => [
      'file_type' => 'guideline',
      'title' => $this->faker->randomElement([
        'Environmental Protection Guidelines',
        'Water Management Best Practices',
        'Soil Conservation Guidelines',
        'Integrated Pest Management Protocol',
        'Climate-Smart Agriculture Guide',
      ]),
    ]);
  }

  public function published(): static
  {
    return $this->state(fn(array $attributes) => [
      'status' => 'published',
      'published_at' => $this->faker->dateTimeBetween('-2 years', 'now'),
    ]);
  }

  public function draft(): static
  {
    return $this->state(fn(array $attributes) => [
      'status' => 'draft',
      'published_at' => null,
    ]);
  }
}
