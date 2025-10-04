<?php

namespace Database\Factories;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
  protected $model = Contact::class;

  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    $subjects = [
      'job_application',
      'technical_support',
      'partnership',
      'project_discussion',
      'general_inquiry',
      'media_inquiry',
      'other',
    ];

    $subject = $this->faker->randomElement($subjects);

    return [
      'name' => $this->faker->name(),
      'email' => $this->faker->safeEmail(),
      'phone' => $this->faker->optional(0.7)->numerify('+93 7# ### ####'),
      'subject' => $subject,
      'message' => $this->generateMessage($subject),
      'status' => $this->faker->randomElement(['new', 'read', 'replied', 'archived']),
      'created_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
    ];
  }

  private function generateMessage(string $subject): string
  {
    $messages = [
      'job_application' => 'I am interested in applying for a position at Mount Agro Institution. Please find my application details and CV attached.',
      'technical_support' => 'I need assistance with implementing the farming techniques learned in your training program. Could someone from your technical team help me?',
      'partnership' => 'Our organization works in rural development and we would like to explore potential collaboration opportunities with Mount Agro Institution.',
      'project_discussion' => 'I would like to discuss a potential agricultural project collaboration. Could we schedule a meeting to explore opportunities?',
      'general_inquiry' => 'I have a general question about your programs and services. Could you please provide more information?',
      'media_inquiry' => 'I am a journalist and would like to feature your organization in an upcoming article. Could you provide some background information?',
      'other' => 'I have a specific inquiry that doesn\'t fit into the other categories. Please let me know how I can get assistance.',
    ];

    return $messages[$subject] ?? $this->faker->paragraph(3);
  }

  public function unread(): static
  {
    return $this->state(fn(array $attributes) => [
      'status' => 'new',
    ]);
  }

  public function replied(): static
  {
    return $this->state(fn(array $attributes) => [
      'status' => 'replied',
    ]);
  }
}
