<?php

namespace Database\Factories;

use App\Models\Block;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BlockFactory extends Factory
{
    protected $model = Block::class;

    public function definition()
    {
        return [
            'name' => 'Hero Banner',
            'slug' => 'hero-banner',
            'view' => 'blocks.hero-banner.hero-banner',
            'schema' => [
                [
                    'key' => 'heading',
                    'label' => 'Heading',
                    'type' => 'text',
                    'required' => true,
                ],
                [
                    'key' => 'subheading',
                    'label' => 'Subheading',
                    'type' => 'textarea',
                ],
                [
                    'key' => 'button_text',
                    'label' => 'Button Text',
                    'type' => 'text',
                ],
                [
                    'key' => 'button_link',
                    'label' => 'Button Link',
                    'type' => 'url',
                ],
                [
                    'key' => 'background_image',
                    'label' => 'Background Image',
                    'type' => 'image',
                ],
            ],
        ];
    }

    /**
     * Hero Banner block preset
     */
    public function heroBanner()
    {
        return $this->state(fn () => [
            'name' => 'Hero Banner',
            'slug' => 'hero-banner',
            'view' => 'blocks.hero-banner.hero-banner',
        ]);
    }


    /**
     * Program Section block preset
     */
    public function programSection()
    {
        return $this->state(fn () => [
            'name' => 'Program Section',
            'slug' => 'program-section',
            'view' => 'blocks.program-section.program-section',
            'schema' => [
                [
                    'key'   => 'programs',
                    'label' => 'Programs',
                    'type'  => 'repeater',
                    'fields' => [
                        [
                            'key'   => 'title',
                            'label' => 'Program Title',
                            'type'  => 'text',
                        ],
                        [
                            'key'   => 'description',
                            'label' => 'Description',
                            'type'  => 'textarea',
                        ],
                        [
                            'key'   => 'image',
                            'label' => 'Image',
                            'type'  => 'image',
                        ],
                        [
                            'key'   => 'button_text',
                            'label' => 'Button Text',
                            'type'  => 'text',
                        ],
                        [
                            'key'   => 'button_link',
                            'label' => 'Button Link',
                            'type'  => 'url',
                        ],
                        [
                            'key'   => 'courses',
                            'label' => 'Featured Courses',
                            'type'  => 'repeater',
                            'subfields' => [
                                [
                                    'key'   => 'title',
                                    'label' => 'Course Title',
                                    'type'  => 'text',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }

    /**
     * Student Signup block preset
     */
    public function studentSignup()
    {
        return $this->state(fn () => [
            'name' => 'Student Signup',
            'slug' => 'student-signup',
            'view' => 'blocks.student-signup.student-signup',
            'schema' => [
                [
                    'key' => 'steps',
                    'label' => 'Signup Steps',
                    'type' => 'repeater',
                    'fields' => [
                        ['key' => 'title', 'label' => 'Step Title', 'type' => 'text'],
                        ['key' => 'fields', 'label' => 'Form Fields', 'type' => 'repeater', 'subfields' => [
                            ['key' => 'label', 'label' => 'Label', 'type' => 'text'],
                            ['key' => 'name', 'label' => 'Name', 'type' => 'text'],
                            ['key' => 'type', 'label' => 'Field Type', 'type' => 'select', 'options' => ['text', 'email', 'password', 'select']],
                            ['key' => 'required', 'label' => 'Required', 'type' => 'boolean'],
                        ]],
                    ],
                ],
            ],
        ]);
    }
}