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
      'Training Program Inquiry',
      'Technical Support Request',
      'Partnership Opportunity',
      'Grant Application Question',
      'Program Registration Help',
      'Research Collaboration',
      'Equipment Purchase Inquiry',
      'Consultation Request',
      'General Information',
      'Feedback and Suggestions',
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
      'Training Program Inquiry' => 'I am interested in participating in your agricultural training programs. Could you please provide more information about upcoming sessions and registration requirements?',
      'Technical Support Request' => 'I need assistance with implementing the farming techniques learned in your training program. Could someone from your technical team help me?',
      'Partnership Opportunity' => 'Our organization works in rural development and we would like to explore potential collaboration opportunities with Mount Agro Institution.',
      'Grant Application Question' => 'I would like to apply for grants or funding opportunities for my agricultural project. Can you guide me through the application process?',
      'Program Registration Help' => 'I am having difficulty registering for your training program online. Could you please assist me with the registration process?',
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
