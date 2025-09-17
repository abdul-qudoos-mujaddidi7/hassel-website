<?php

namespace Database\Factories;

use App\Models\News;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
  protected $model = News::class;

  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    $title = $this->faker->sentence(6, true);

    return [
      'title' => $title,
      'slug' => \Illuminate\Support\Str::slug($title),
      'excerpt' => $this->faker->text(200),
      'content' => $this->generateContent(),
      'featured_image' => $this->getRandomImage('agriculture'),
      'status' => $this->faker->randomElement(['published', 'draft']),
      'published_at' => $this->faker->optional(0.8)->dateTimeBetween('-6 months', 'now'),
      'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
    ];
  }

  /**
   * Generate realistic content for news articles
   */
  private function generateContent(): string
  {
    $paragraphs = [
      "Mount Agro Institution continues to lead agricultural development initiatives across Afghanistan, bringing innovative solutions to farmers and rural communities.",

      "Our comprehensive programs focus on sustainable farming practices, modern irrigation techniques, and crop diversification strategies that have proven successful in similar agricultural contexts.",

      "Through partnerships with international organizations and local cooperatives, we have been able to reach thousands of farmers with training, resources, and ongoing support.",

      "The implementation of new technologies and farming methods has resulted in increased yields, improved crop quality, and enhanced food security for participating communities.",

      "We believe that sustainable agriculture is the foundation of economic growth and community resilience, and our programs are designed to create lasting positive impact.",

      "Training sessions cover topics such as soil management, pest control, water conservation, and post-harvest handling to ensure farmers have comprehensive knowledge and skills.",

      "Our field teams work directly with farmers to provide hands-on support and ensure that new techniques are properly implemented and maintained over time.",

      "Success stories from our programs demonstrate the transformative power of education, technology, and community collaboration in agricultural development.",
    ];

    return implode("\n\n", $this->faker->randomElements($paragraphs, $this->faker->numberBetween(4, 6)));
  }

  /**
   * Get random image URL
   */
  private function getRandomImage(string $category = 'agriculture'): string
  {
    $images = [
      'https://images.unsplash.com/photo-1625246335525-4d50c8507f68?auto=format&fit=crop&w=1200&q=80', // farming
      'https://images.unsplash.com/photo-1620228885847-9eab2a1adddc?auto=format&fit=crop&w=1200&q=80', // crops
      'https://images.unsplash.com/photo-1532619187608-e5375cab36aa?auto=format&fit=crop&w=1200&q=80', // greenhouse
      'https://images.unsplash.com/photo-1574323347407-f5e1ad6d020b?auto=format&fit=crop&w=1200&q=80', // irrigation
      'https://images.unsplash.com/photo-1605000797499-95a51c5269ae?auto=format&fit=crop&w=1200&q=80', // harvest
      'https://images.unsplash.com/photo-1592982736371-20b888cce3ba?auto=format&fit=crop&w=1200&q=80', // tractor
      'https://images.unsplash.com/photo-1560493676-04071c5f467b?auto=format&fit=crop&w=1200&q=80', // rural
      'https://images.unsplash.com/photo-1582560469781-1965b9af903d?auto=format&fit=crop&w=1200&q=80', // workers
    ];

    return $this->faker->randomElement($images);
  }

  /**
   * State for published news
   */
  public function published(): static
  {
    return $this->state(fn(array $attributes) => [
      'status' => 'published',
      'published_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
    ]);
  }

  /**
   * State for draft news
   */
  public function draft(): static
  {
    return $this->state(fn(array $attributes) => [
      'status' => 'draft',
      'published_at' => null,
    ]);
  }
}
