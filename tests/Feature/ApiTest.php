<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class ApiTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        // We seed the database before each test
        $this->seed();
    }

    /**
     * @test
     *
     * We are testing the default behaviour of the API. It should return:
     * - A JSON response
     * - A 200 status code
     * - A paginated list of intents (by 4) ordered by title
     */
    public function it_gets_the_paginated_intents_ordered_by_default_by_title()
    {
        $response = $this->postJson('/api/intents');
        $intents = $response->json();
        $dbIntents = DB::table('intents')->limit(4)->orderBy('title')->get();

        $response->assertStatus(200);
        $this->assertCount(4, $response->json());
        $dbIntents->map(fn ($dbIntent, $index) => $this->assertEquals($dbIntent->id, $intents[$index]['id']));
    }

    /**
     * @test
     *
     * Here we add an 'orderBy' parameter. The API should return:
     * - A JSON response
     * - A 200 status code
     * - A paginated list of intents (by 4) ordered by answers count
     */
    public function it_gets_the_paginated_intents_ordered_by_answers_count()
    {
        $response = $this->postJson('/api/intents', [
            'orderBy' => ['answers_count']
        ]);
        $intents = $response->json();
        $dbIntents = DB::table('answers_intents')
            ->selectRaw('intent_id, count(intent_id) as answers_count')
            ->groupBy('intent_id')
            ->limit(4)
            ->orderBy('answers_count', 'desc')
            ->get();

        $response->assertStatus(200);
        $this->assertCount(4, $response->json());
        $dbIntents->map(fn ($dbIntent, $index) => $this->assertEquals($dbIntent->intent_id, $intents[$index]['id']));
    }

    /**
     * @test
     *
     * Here, we want the intents to be ordered in the following order:
     * 1. The "draft" intents,
     * 2. The intents by answers count
     */
    public function it_orders_the_paginated_intents_by_status_first_and_then_by_answers_count()
    {   
        $response = $this->postJson('/api/intents', [
            'orderBy' => ['draft', 'answers_count']
        ]);
        $intents = $response->json();
        $dbIntents = DB::table('intents')
            ->select(DB::raw('intents.id, intents.status, COUNT(*) as answers_count'))
            ->join('answers_intents', 'intents.id', 'answers_intents.intent_id')
            ->groupBy('intents.id')
            ->limit(4)
            ->orderByRaw('intents.status, answers_count DESC')
            ->toSql();

        $response = $this->get('/api/intents');
        $response->assertStatus(200);
        $dbIntents->map(fn ($dbIntent, $index) => $this->assertEquals($dbIntent->intent_id, $intents[$index]['id']));
    }
}
