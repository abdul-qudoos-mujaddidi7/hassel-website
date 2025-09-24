<?php

namespace Database\Factories;

use App\Models\TrainingProgram;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TrainingProgram>
 */
class TrainingProgramFactory extends Factory
{
    protected $model = TrainingProgram::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->randomElement([
            'Sustainable Farming Techniques Workshop',
            'Modern Irrigation Methods Training',
            'Organic Agriculture Certification Program',
            'Livestock Management Best Practices',
            'Greenhouse Farming Intensive Course',
            'Agricultural Business Development',
            'Soil Health and Fertility Management',
            'Post-Harvest Processing and Storage',
            'Climate-Smart Agriculture Training',
            'Integrated Pest Management Program',
        ]);

        $startDate = $this->faker->dateTimeBetween('-6 months', '+6 months');
        $duration = $this->faker->numberBetween(3, 30); // days
        $endDate = (clone $startDate)->modify("+{$duration} days");

        return [
            'title' => $title,
            'slug' => \Illuminate\Support\Str::slug($title . '-' . $this->faker->unique()->randomNumber(3)),
            'description' => $this->generateDescription($title),
            'cover_image' => '/images/seed/covers/' . $this->faker->randomElement(['cover1.jpg', 'cover2.jpg', 'cover3.jpg']),
            'thumbnail_image' => '/images/seed/thumbs/' . $this->faker->randomElement(['thumb1.jpg', 'thumb2.jpg', 'thumb3.jpg']),
            'program_type' => $this->faker->randomElement(['basic', 'advanced', 'specialized', 'workshop', 'field_school']),
            'duration' => $duration . ' days',
            'location' => $this->faker->randomElement([
                'Kabul Training Center',
                'Herat Agricultural Institute',
                'Mazar Training Facility',
                'Kandahar Field Station',
                'Jalalabad Campus',
                'Community Center - Bamyan'
            ]),
            'instructor' => $this->faker->name() . ', ' . $this->faker->randomElement([
                'Agricultural Engineer',
                'Farming Specialist',
                'Extension Officer',
                'Technical Expert'
            ]),
            'max_participants' => $this->faker->numberBetween(15, 50),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => $this->faker->randomElement(['published', 'draft']),
            'created_at' => $this->faker->dateTimeBetween('-3 months', 'now'),
        ];
    }

    /**
     * Generate program description
     */
    private function generateDescription(string $title): string
    {
        return "This comprehensive {$title} is designed to equip participants with practical skills and knowledge essential for modern agriculture. " .
            "The program combines theoretical learning with hands-on field experience, ensuring participants can immediately apply what they learn. " .
            "Our expert instructors use interactive teaching methods and provide ongoing support throughout the training period.";
    }

    /**
     * Generate program objectives
     */
    private function generateObjectives(): string
    {
        $objectives = [
            "Enhance participants' understanding of modern agricultural techniques",
            "Develop practical skills for sustainable farming practices",
            "Improve crop yield and quality through scientific methods",
            "Build capacity for problem-solving in agricultural contexts",
            "Promote adoption of climate-smart agriculture practices",
            "Strengthen knowledge of market-oriented farming",
            "Foster innovation and entrepreneurship in agriculture",
            "Create networks among farming communities",
        ];

        return implode("\n", $this->faker->randomElements($objectives, $this->faker->numberBetween(4, 6)));
    }

    /**
     * Generate curriculum content
     */
    private function generateCurriculum(): string
    {
        $topics = [
            "Introduction to modern farming techniques and technologies",
            "Soil testing and fertility management strategies",
            "Water management and efficient irrigation systems",
            "Seed selection and crop planning methodologies",
            "Integrated pest and disease management approaches",
            "Harvesting and post-harvest handling best practices",
            "Agricultural marketing and value chain development",
            "Financial planning and record keeping for farmers",
            "Environmental sustainability in agriculture",
            "Hands-on field demonstrations and practical exercises",
        ];

        return implode("\n", $this->faker->randomElements($topics, $this->faker->numberBetween(6, 8)));
    }

    /**
     * State for upcoming programs
     */
    public function upcoming(): static
    {
        $startDate = $this->faker->dateTimeBetween('now', '+6 months');
        $duration = $this->faker->numberBetween(3, 30);
        $endDate = (clone $startDate)->modify("+{$duration} days");

        return $this->state(fn(array $attributes) => [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => 'published',
        ]);
    }

    /**
     * State for ongoing programs
     */
    public function ongoing(): static
    {
        $startDate = $this->faker->dateTimeBetween('-1 month', 'now');
        $duration = $this->faker->numberBetween(7, 30);
        $endDate = (clone $startDate)->modify("+{$duration} days");

        return $this->state(fn(array $attributes) => [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => 'published',
        ]);
    }

    /**
     * State for completed programs
     */
    public function completed(): static
    {
        $endDate = $this->faker->dateTimeBetween('-6 months', '-1 week');
        $duration = $this->faker->numberBetween(3, 30);
        $startDate = (clone $endDate)->modify("-{$duration} days");

        return $this->state(fn(array $attributes) => [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => 'published',
        ]);
    }
}
