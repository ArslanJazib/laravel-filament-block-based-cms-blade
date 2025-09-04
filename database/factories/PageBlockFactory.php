<?php

namespace Database\Factories;

use App\Models\PageBlock;
use App\Models\Page;
use App\Models\Block;
use Illuminate\Database\Eloquent\Factories\Factory;

class PageBlockFactory extends Factory
{
    protected $model = PageBlock::class;

    public function definition(): array
    {
        return [
            'page_id'    => Page::factory(),
            'block_id'   => Block::factory(),
            'content'    => [],
            'sort_order' => 0,
        ];
    }

    /**
     * Hero Banner block
     */
    public function heroBanner(): self
    {
        return $this->state(fn () => [
            'block_id' => Block::factory()->heroBanner(),
            'content'  => [
                [
                    'type' => 'hero-banner',
                    'data' => [
                        'heading'          => 'Transform Your Life with KANDOR',
                        'subheading'       => 'A platform designed to help you break through personal and professional challenges, unlocking your full potential across Mind, Body, Soul, and Entrepreneurship.',
                        'button_text'      => 'Get Started',
                        'button_link'      => null,
                        'background_image' => '01K44MJ9RRHSQR059VN2JWM9RS.jpg',
                    ],
                ],
            ],
        ]);
    }

    /**
     * Program Section block
     */
    public function programSection(): self
    {
        return $this->state(fn () => [
            'block_id' => Block::factory()->programSection(),
            'content'  => [
                [
                    'type' => 'program-section',
                    'data' => [
                        'programs' => [
                            [
                                'title'       => 'Sharpen Your Mind',
                                'description' => 'Unlock mental clarity and resilience with guided practices that strengthen your focus and productivity.',
                                'image'       => '01K44MJ9S6BFFZACW7BF607WCR.jpg',
                                'button_text' => 'Explore Mind',
                                'button_link' => null,
                                'courses'     => [
                                    ['title' => 'Focus Mastery'],
                                    ['title' => 'Productivity Boost'],
                                    ['title' => 'Mind Clarity'],
                                ],
                            ],
                            [
                                'title'       => 'Nourish Your Soul',
                                'description' => 'Find peace, purpose, and connection through mindfulness, gratitude, and soulful living practices.',
                                'image'       => '01K44MJ9S9NGPZQ7MDRKPVHZBT.jpg',
                                'button_text' => 'Explore Soul',
                                'button_link' => null,
                                'courses'     => [
                                    ['title' => 'Mindfulness Meditation'],
                                    ['title' => 'Gratitude Journaling'],
                                    ['title' => 'Spiritual Growth'],
                                    ['title' => 'Inner Peace Practices'],
                                ],
                            ],
                            [
                                'title'       => 'Strengthen Your Body',
                                'description' => 'Boost your physical vitality with routines and nutrition practices that fuel energy and resilience.',
                                'image'       => '01K44MJ9SDWD00DNJ37JYQT2QM.jpg',
                                'button_text' => 'Explore Body',
                                'button_link' => null,
                                'courses'     => [
                                    ['title' => 'Fitness Fundamentals'],
                                    ['title' => 'Strength Training'],
                                    ['title' => 'Nutrition Balance'],
                                    ['title' => 'Recovery & Rest'],
                                ],
                            ],
                            [
                                'title'       => 'Ignite Entrepreneurship',
                                'description' => 'Master innovation, leadership, and strategy to thrive in the modern business world.',
                                'image'       => '01K44MJ9SJY1B6G493M1HAH4JD.jpg',
                                'button_text' => 'Explore Entrepreneurship',
                                'button_link' => null,
                                'courses'     => [
                                    ['title' => 'Startup Blueprint'],
                                    ['title' => 'Leadership Lab'],
                                    ['title' => 'Marketing Mastery'],
                                    ['title' => 'Scaling Strategies'],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }

    /**
     * Student Signup block
     */
    public function studentSignup(): self
    {
        return $this->state(fn () => [
            'block_id' => Block::factory()->studentSignup(),
            'content'  => [
                [
                    'type' => 'student-signup',
                    'data' => [
                        'steps' => [
                            [
                                'title'  => 'Account',
                                'fields' => [
                                    ['name' => 'first_name', 'type' => '0', 'label' => 'First Name'],
                                    ['name' => 'last_name', 'type' => '0', 'label' => 'Last Name'],
                                ],
                            ],
                            [
                                'title'  => 'Security',
                                'fields' => [
                                    ['name' => 'password', 'type' => '2', 'label' => 'Password'],
                                ],
                            ],
                            [
                                'title'  => 'Contact',
                                'fields' => [
                                    ['name' => 'email', 'type' => '1', 'label' => 'Email'],
                                    ['name' => 'phone', 'type' => '0', 'label' => 'Phone'],
                                ],
                            ],
                            [
                                'title'  => 'Business',
                                'fields' => [
                                    ['name' => 'company_name', 'type' => '0', 'label' => 'Company Name'],
                                ],
                            ],
                            [
                                'title'  => 'Confirm',
                                'fields' => [],
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }
}