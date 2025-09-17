<?php

namespace Database\Factories;

use App\Models\RfpRfq;
use Illuminate\Database\Eloquent\Factories\Factory;

class RfpRfqFactory extends Factory
{
    protected $model = RfpRfq::class;

    public function definition(): array
    {
        $title = $this->faker->randomElement([
            'Agricultural Equipment Supply Contract',
            'Irrigation System Installation Project',
            'Greenhouse Construction Services',
            'Seeds and Fertilizers Procurement',
            'Training Materials Development',
            'Agricultural Research Consultation',
            'Farm Management Software Development',
            'Rural Infrastructure Development',
        ]);

        $deadline = $this->faker->dateTimeBetween('now', '+3 months');

        return [
            'title' => $title,
            'slug' => \Illuminate\Support\Str::slug($title . '-' . $this->faker->unique()->randomNumber(3)),
            'description' => $this->generateDescription($title),
            'file_path' => $this->generateDocumentPath(),
            'deadline' => $deadline,
            'status' => $this->faker->randomElement(['published', 'draft']),
            'published_at' => $this->faker->optional(0.8)->dateTimeBetween('-2 months', 'now'),
            'created_at' => $this->faker->dateTimeBetween('-3 months', 'now'),
        ];
    }

    private function generateDescription(string $title): string
    {
        return "Mount Agro Institution invites qualified vendors to submit proposals for {$title}. " .
            "This procurement is part of our ongoing efforts to enhance agricultural development programs. " .
            "Interested parties should review all requirements carefully and submit complete proposals by the specified deadline.";
    }


    private function generateDocumentPath(): string
    {
        $filename = $this->faker->slug(3) . '_rfp_' . time() . '.pdf';
        return "rfp-rfq/" . date('Y/m') . "/{$filename}";
    }

    public function open(): static
    {
        return $this->state(fn(array $attributes) => [
            'deadline' => $this->faker->dateTimeBetween('now', '+3 months'),
            'status' => 'published',
        ]);
    }

    public function closed(): static
    {
        return $this->state(fn(array $attributes) => [
            'deadline' => $this->faker->dateTimeBetween('-3 months', 'now'),
            'status' => 'published',
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
