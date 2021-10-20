<?php

namespace Database\Seeders;

use App\Models\Intent;
use Faker\Generator;
use Illuminate\Database\Seeder;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * The current Faker instance.
     *
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * Create a new seeder instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->faker = Container::getInstance()->make(Generator::class);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $draftStatus = 'draft';
        $publishedStatus = 'published';

        DB::table('intents')->insert([
            ['title' => $this->faker->sentence(), 'status' => $publishedStatus, 'created_at' => now(), 'updated_at' => now()],
            ['title' => $this->faker->sentence(), 'status' => $publishedStatus, 'created_at' => now(), 'updated_at' => now()],
            ['title' => $this->faker->sentence(), 'status' => $publishedStatus, 'created_at' => now(), 'updated_at' => now()],
            ['title' => $this->faker->sentence(), 'status' => $draftStatus, 'created_at' => now(), 'updated_at' => now()],
            ['title' => $this->faker->sentence(), 'status' => $publishedStatus, 'created_at' => now(), 'updated_at' => now()],
            ['title' => $this->faker->sentence(), 'status' => $publishedStatus, 'created_at' => now(), 'updated_at' => now()],
            ['title' => $this->faker->sentence(), 'status' => $publishedStatus, 'created_at' => now(), 'updated_at' => now()],
            ['title' => $this->faker->sentence(), 'status' => $publishedStatus, 'created_at' => now(), 'updated_at' => now()],
            ['title' => $this->faker->sentence(), 'status' => $draftStatus, 'created_at' => now(), 'updated_at' => now()],
            ['title' => $this->faker->sentence(), 'status' => $publishedStatus, 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('intents')->get()->map(function ($intent, $index) {
            $trainingPhrases = [];
            $answers = [];
            $intentsAnswerPivot = [];

            for ($i = 0; $i <= $index; $i++) {
                array_push(
                    $trainingPhrases,
                    ['intent_id' => $intent->id, 'text' => $this->faker->sentence(), 'created_at' => now(), 'updated_at' => now()]
                );

                array_push($answers, ['text' => $this->faker->sentence()]);
                array_push($intentsAnswerPivot, [
                    'intent_id' => $intent->id,
                    'answer_id' => $i + 1,
                    'position' => $i,
                ]);
            }

            DB::table('training_phrases')->insert($trainingPhrases);
            DB::table('answers')->insert($answers);
            DB::table('answers_intents')->insert($intentsAnswerPivot);
        });
    }
}
