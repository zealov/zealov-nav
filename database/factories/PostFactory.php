<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Module\Blog\Models\Post;

class PostFactory extends Factory
{
    /**
     * 工厂对应的 model 名称
     *
     * @var string
     */
    protected $model = Post::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'name' => $this->faker->title,
            'sub_name' => $this->faker->name,
            'author' => $this->faker->name,
            'from' => $this->faker->address,
            'view' => $this->faker->randomNumber(5),
            'thumbnail' => $this->faker->imageUrl(640, 480, 'cats', true, 'Faker'),
            'description' => $this->faker->text(200),
            'content' => $this->faker->text(500),
            'image_path' => $this->faker->imageUrl(640, 480, 'cats', true, 'Faker'),
            'sort' => $this->faker->randomNumber(5),
            'redirect' => $this->faker->url,
        ];
    }
}
