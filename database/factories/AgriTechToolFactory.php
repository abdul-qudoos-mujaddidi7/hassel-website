<?php

namespace Database\Factories;

use App\Models\AgriTechTool;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AgriTechTool>
 */
class AgriTechToolFactory extends Factory
{
  protected $model = AgriTechTool::class;

  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    $title = $this->faker->randomElement([
      'Smart Irrigation Controller',
      'Crop Health Monitoring System',
      'Weather Station Pro',
      'Soil Analysis Kit',
      'Drone Surveying Platform',
      'Greenhouse Automation System',
      'Livestock Tracking Device',
      'Harvest Planning Software',
      'Pest Detection Camera',
      'Mobile Farm Management App',
    ]);

    return [
      'name' => $title,
      'slug' => \Illuminate\Support\Str::slug($title . '-' . $this->faker->unique()->randomNumber(3)),
      'description' => $this->generateDescription($title),
      'cover_image' => '/images/seed/covers/' . $this->faker->randomElement(['cover1.jpg', 'cover2.jpg', 'cover3.jpg']),
      'thumbnail_image' => '/images/seed/thumbs/' . $this->faker->randomElement(['thumb1.jpg', 'thumb2.jpg', 'thumb3.jpg']),
      'features' => json_encode($this->generateFeatures()),
      'tool_type' => $this->faker->randomElement(['mobile_app', 'web_tool', 'desktop_software']),
      'platform' => $this->faker->randomElement(['Android', 'iOS', 'Web', 'Windows']),
      'download_link' => $this->faker->optional(0.7)->url(),
      'version' => $this->faker->optional(0.8)->numerify('#.#.#'),
      'status' => $this->faker->randomElement(['published', 'draft']),
      'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
    ];
  }

  private function generateDescription(string $title): string
  {
    return "The {$title} is an advanced agricultural technology solution designed to enhance farming efficiency and productivity. " .
      "This innovative tool combines modern technology with practical agricultural needs, providing farmers with real-time insights and automated solutions. " .
      "Suitable for both small-scale and commercial farming operations.";
  }

  private function generateFeatures(): array
  {
    $features = [
      'Real-time data monitoring and analysis',
      'Mobile app integration for remote control',
      'Weather-resistant design for field conditions',
      'Easy installation and setup process',
      'Data export and reporting capabilities',
      'Battery life up to 6 months',
      'Wireless connectivity options',
      'User-friendly interface',
      'Technical support and training included',
      'Scalable for different farm sizes',
    ];

    return $this->faker->randomElements($features, $this->faker->numberBetween(4, 7));
  }

  private function getRandomImage(): string
  {
    $images = [
      'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=600&q=80',
      'https://images.unsplash.com/photo-1574323347407-f5e1ad6d020b?auto=format&fit=crop&w=600&q=80',
      'https://images.unsplash.com/photo-1605000797499-95a51c5269ae?auto=format&fit=crop&w=600&q=80',
      'https://images.unsplash.com/photo-1592982736371-20b888cce3ba?auto=format&fit=crop&w=600&q=80',
    ];

    return $this->faker->randomElement($images);
  }

  public function published(): static
  {
    return $this->state(fn(array $attributes) => [
      'status' => 'published',
    ]);
  }
}
