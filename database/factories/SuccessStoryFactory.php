<?php

namespace Database\Factories;

use App\Models\SuccessStory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SuccessStory>
 */
class SuccessStoryFactory extends Factory
{
  protected $model = SuccessStory::class;

  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    $clientName = $this->faker->name();
    $title = "Success Story: " . $clientName;

    return [
      'title' => $title,
      'slug' => \Illuminate\Support\Str::slug($title),
      'story' => $this->generateStory($clientName),
      'client_name' => $clientName,
      'image' => $this->getRandomImage(),
      'status' => $this->faker->randomElement(['published', 'draft']),
      'published_at' => $this->faker->optional(0.8)->dateTimeBetween('-2 years', 'now'),
      'created_at' => $this->faker->dateTimeBetween('-2 years', 'now'),
    ];
  }

  /**
   * Generate realistic success story content
   */
  private function generateStory(string $clientName): string
  {
    $stories = [
      "{$clientName} started with just 2 acres of land and traditional farming methods. Through Mount Agro Institution's training programs and support, they learned modern irrigation techniques and sustainable farming practices. Within two seasons, crop yields increased by 40%, and income doubled. Today, {$clientName} employs 5 local farmers and serves as a model for the community.",

      "Before joining our program, {$clientName} struggled with pest management and low crop quality. Our technical team provided hands-on training in integrated pest management and soil health improvement. The transformation was remarkable - crop losses reduced from 30% to less than 5%, and product quality improved significantly, opening new market opportunities.",

      "{$clientName} had the vision but lacked the knowledge to implement greenhouse farming. Through our comprehensive training program and ongoing mentorship, they successfully established a modern greenhouse operation. The controlled environment allowed year-round production, increasing annual income by 300% and providing fresh vegetables to the local market.",

      "Water scarcity was the biggest challenge for {$clientName}'s farm. Our water management specialists introduced drip irrigation and rainwater harvesting techniques. These innovations reduced water usage by 50% while increasing crop yields. The success inspired neighboring farmers to adopt similar practices, creating a ripple effect throughout the region.",

      "Starting as a small-scale farmer, {$clientName} participated in our business development program. They learned financial management, market analysis, and value-added processing. Today, they run a successful agro-processing business, creating employment for 15 people and adding value to local agricultural products before selling to urban markets."
    ];

    return $this->faker->randomElement($stories);
  }

  /**
   * Get random client image
   */
  private function getRandomImage(): string
  {
    $images = [
      'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=400&q=80',
      'https://images.unsplash.com/photo-1494790108755-2616b612b47c?auto=format&fit=crop&w=400&q=80',
      'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=400&q=80',
      'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=400&q=80',
      'https://images.unsplash.com/photo-1527980965255-d3b416303d12?auto=format&fit=crop&w=400&q=80',
      'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&w=400&q=80',
      'https://images.unsplash.com/photo-1463453091185-61582044d556?auto=format&fit=crop&w=400&q=80',
      'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=400&q=80',
    ];

    return $this->faker->randomElement($images);
  }

  /**
   * State for different business types
   */
  public function farming(): static
  {
    return $this->state(fn(array $attributes) => [
      'story' => str_replace(
        '{client}',
        $attributes['client_name'] ?? 'the farmer',
        'This farming success story demonstrates how modern techniques transformed traditional agriculture. Through dedicated training and support, significant improvements in crop yield and quality were achieved.'
      ),
    ]);
  }

  public function livestock(): static
  {
    return $this->state(fn(array $attributes) => [
      'story' => str_replace(
        '{client}',
        $attributes['client_name'] ?? 'the farmer',
        'This livestock success story shows how proper animal husbandry practices led to increased productivity and better animal health outcomes for the farming operation.'
      ),
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
