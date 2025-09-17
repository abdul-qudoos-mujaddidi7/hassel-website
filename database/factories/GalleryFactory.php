<?php

namespace Database\Factories;

use App\Models\Gallery;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Gallery>
 */
class GalleryFactory extends Factory
{
  protected $model = Gallery::class;

  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    $title = $this->faker->sentence(3, true);

    return [
      'title' => $title,
      'slug' => \Illuminate\Support\Str::slug($title),
      'description' => $this->faker->optional(0.8)->text(200),
      'cover_image' => $this->getRandomImage(),
      'status' => $this->faker->randomElement(['published', 'draft']),
      'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
    ];
  }

  /**
   * Get random image URL
   */
  private function getRandomImage(): string
  {
    $images = [
      'https://images.unsplash.com/photo-1625246335525-4d50c8507f68?auto=format&fit=crop&w=800&q=80',
      'https://images.unsplash.com/photo-1620228885847-9eab2a1adddc?auto=format&fit=crop&w=800&q=80',
      'https://images.unsplash.com/photo-1574323347407-f5e1ad6d020b?auto=format&fit=crop&w=800&q=80',
      'https://images.unsplash.com/photo-1605000797499-95a51c5269ae?auto=format&fit=crop&w=800&q=80',
      'https://images.unsplash.com/photo-1592982736371-20b888cce3ba?auto=format&fit=crop&w=800&q=80',
      'https://images.unsplash.com/photo-1560493676-04071c5f467b?auto=format&fit=crop&w=800&q=80',
      'https://images.unsplash.com/photo-1582560469781-1965b9af903d?auto=format&fit=crop&w=800&q=80',
      'https://images.unsplash.com/photo-1532619187608-e5375cab36aa?auto=format&fit=crop&w=800&q=80',
    ];

    return $this->faker->randomElement($images);
  }

  /**
   * State for different gallery themes
   */
  public function farmingActivities(): static
  {
    return $this->state(fn(array $attributes) => [
      'title' => $this->faker->randomElement([
        'Seasonal Farming Activities',
        'Harvest Season Documentation',
        'Modern Farming Techniques',
        'Agricultural Equipment in Action',
        'Crop Cultivation Process',
      ]),
    ]);
  }

  public function trainingEvents(): static
  {
    return $this->state(fn(array $attributes) => [
      'title' => $this->faker->randomElement([
        'Farmer Training Workshop',
        'Agricultural Skills Development',
        'Community Education Program',
        'Technical Training Session',
        'Knowledge Sharing Event',
      ]),
    ]);
  }

  public function projects(): static
  {
    return $this->state(fn(array $attributes) => [
      'title' => $this->faker->randomElement([
        'Irrigation System Installation',
        'Greenhouse Construction Project',
        'Rural Infrastructure Development',
        'Water Management Initiative',
        'Sustainable Agriculture Project',
      ]),
    ]);
  }

  public function published(): static
  {
    return $this->state(fn(array $attributes) => [
      'status' => 'published',
    ]);
  }

  public function draft(): static
  {
    return $this->state(fn(array $attributes) => [
      'status' => 'draft',
    ]);
  }
}
