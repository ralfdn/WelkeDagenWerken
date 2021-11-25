<?php

namespace Tests\Unit;

use Tests\TestCase;

use function PHPUnit\Framework\assertCount;

class ApiTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->getJson('/api/date/12%202021');

        $response
            ->assertStatus(200)
            ->assertJson([
                'workDays' => true,
            ])
            ->assertJsonCount(2, 'workDays');

        $data = array(
            'workDays' => array(
                array(
                    'name' => 'vrijdag',
                    'freeDays' => 2,
                    'workHours' => 8,
                ),
                array(
                    'name' => 'maandag',
                    'freeDays' => 2,
                    'workHours' => 4,
                ),
            ),
        );

        $response->assertExactJson($data);
    }
}
