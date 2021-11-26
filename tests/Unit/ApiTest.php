<?php

namespace Tests\Unit;

use Tests\TestCase;

class ApiTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     *
     * @dataProvider DataProvider
     */
    public function test_example(array $input, array $expectedOutput)
    {
        $response = $this->getJson("/api/date/$input[0]%20$input[1]");

        $response
            ->assertStatus($expectedOutput['status'])
            ->assertExactJson($expectedOutput[0]);
    }

    public function DataProvider()
    {
        return array(
            array(
                array('12','2021'),
                array(
                    array('workDays' =>
                        array(
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
                    ),
                    'status' => 200,
                ),
            ),
            array(
                array('32','2021'),
                array(
                    array('workDays' =>
                        array(
                            array(
                                'name' => 'vrijdag',
                                'freeDays' => 2,
                                'workHours' => 8,
                            ),
                            array(
                                'name' => 'maandag',
                                'freeDays' => 2,
                                'workHours' => 8,
                            ),
                            array(
                                'name' => 'donderdag',
                                'freeDays' => 1,
                                'workHours' => 8,
                            ),
                            array(
                                'name' => 'woensdag',
                                'freeDays' => 1,
                                'workHours' => 8,
                            ),
                        ),
                    ),
                    'status' => 200,
                ),
            ),
            array(
                array('40','2021'),
                array(
                    array('workDays' =>
                        array(
                            array(
                                'name' => 'vrijdag',
                                'freeDays' => 2,
                                'workHours' => 8,
                            ),
                            array(
                                'name' => 'maandag',
                                'freeDays' => 2,
                                'workHours' => 8,
                            ),
                            array(
                                'name' => 'donderdag',
                                'freeDays' => 1,
                                'workHours' => 8,
                            ),
                            array(
                                'name' => 'woensdag',
                                'freeDays' => 1,
                                'workHours' => 8,
                            ),
                            array(
                                'name' => 'dinsdag',
                                'freeDays' => 1,
                                'workHours' => 8,
                            ),
                        ),
                    ),
                    'status' => 200,
                ),
            ),
            array(
                array('32','2022'),
                array(
                    array('workDays' =>
                        array(
                            array(
                                'name' => 'maandag',
                                'freeDays' => 3,
                                'workHours' => 8,
                            ),
                            array(
                                'name' => 'donderdag',
                                'freeDays' => 2,
                                'workHours' => 8,
                            ),
                            array(
                                'name' => 'vrijdag',
                                'freeDays' => 1,
                                'workHours' => 8,
                            ),
                            array(
                                'name' => 'woensdag',
                                'freeDays' => 1,
                                'workHours' => 8,
                            ),
                        ),
                    ),
                    'status' => 200,
                ),
            ),
            array(
                array('32','2023'),
                array(
                    array('workDays' =>
                        array(
                            array(
                                'name' => 'maandag',
                                'freeDays' => 3,
                                'workHours' => 8,
                            ),
                            array(
                                'name' => 'vrijdag',
                                'freeDays' => 2,
                                'workHours' => 8,
                            ),
                            array(
                                'name' => 'donderdag',
                                'freeDays' => 2,
                                'workHours' => 8,
                            ),
                            array(
                                'name' => 'dinsdag',
                                'freeDays' => 1,
                                'workHours' => 8,
                            ),
                        ),
                    ),
                    'status' => 200,
                ),
            ),
            array(
                array('32','2024'),
                array(
                    array('workDays' =>
                        array(
                            array(
                                'name' => 'maandag',
                                'freeDays' => 3,
                                'workHours' => 8,
                            ),
                            array(
                                'name' => 'donderdag',
                                'freeDays' => 2,
                                'workHours' => 8,
                            ),
                            array(
                                'name' => 'vrijdag',
                                'freeDays' => 1,
                                'workHours' => 8,
                            ),
                            array(
                                'name' => 'woensdag',
                                'freeDays' => 1,
                                'workHours' => 8,
                            ),
                        ),
                    ),
                    'status' => 200,
                ),
            ),
            array(
                array('32','2025'),
                array(
                    array('workDays' =>
                        array(
                            array(
                                'name' => 'maandag',
                                'freeDays' => 3,
                                'workHours' => 8,
                            ),
                            array(
                                'name' => 'vrijdag',
                                'freeDays' => 2,
                                'workHours' => 8,
                            ),
                            array(
                                'name' => 'donderdag',
                                'freeDays' => 2,
                                'workHours' => 8,
                            ),
                            array(
                                'name' => 'woensdag',
                                'freeDays' => 1,
                                'workHours' => 8,
                            ),
                        ),
                    ),
                    'status' => 200,
                ),
            ),
        );
    }
}
