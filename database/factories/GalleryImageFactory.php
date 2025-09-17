<?php

namespace Database\Factories;

use App\Models\Gallery;
use App\Models\GalleryImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GalleryImage>
 */
class GalleryImageFactory extends Factory
{
  protected $model = GalleryImage::class;

  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    return [
      'gallery_id' => Gallery::factory(),
      'title' => $this->faker->optional(0.7)->sentence(3),
      'image_path' => $this->generateImagePath(),
      'alt_text' => $this->faker->sentence(4),
      'sort_order' => $this->faker->numberBetween(0, 20),
      'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
    ];
  }

  /**
   * Generate realistic image path
   */
  private function generateImagePath(): string
  {
    $images = [
      'https://images.unsplash.com/photo-1625246335525-4d50c8507f68?auto=format&fit=crop&w=600&q=80',
      'https://images.unsplash.com/photo-1620228885847-9eab2a1adddc?auto=format&fit=crop&w=600&q=80',
      'https://images.unsplash.com/photo-1574323347407-f5e1ad6d020b?auto=format&fit=crop&w=600&q=80',
      'https://images.unsplash.com/photo-1605000797499-95a51c5269ae?auto=format&fit=crop&w=600&q=80',
      'https://images.unsplash.com/photo-1592982736371-20b888cce3ba?auto=format&fit=crop&w=600&q=80',
      'https://images.unsplash.com/photo-1560493676-04071c5f467b?auto=format&fit=crop&w=600&q=80',
      'https://images.unsplash.com/photo-1582560469781-1965b9af903d?auto=format&fit=crop&w=600&q=80',
      'https://images.unsplash.com/photo-1532619187608-e5375cab36aa?auto=format&fit=crop&w=600&q=80',
      'https://images.unsplash.com/photo-1573160815715-6dd89acee50b?auto=format&fit=crop&w=600&q=80',
      'https://images.unsplash.com/photo-1571781926291-c477ebfd024b?auto=format&fit=crop&w=600&q=80',
    ];

    return $this->faker->randomElement($images);
  }

  /**
   * State for specific gallery
   */
  public function forGallery(Gallery $gallery): static
  {
    return $this->state(fn(array $attributes) => [
      'gallery_id' => $gallery->id,
    ]);
  }
}
