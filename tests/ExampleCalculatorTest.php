<?php

namespace Tests;

use Generator;
use PHPUnit\Framework\TestCase;
use RTNRG\ExampleCalculator;
use RTNRG\RewardCalculationRule;
use RTNRG\RewardCalculationRulesSet;
use RTNRG\RewardCalculator;

class ExampleCalculatorTest extends TestCase
{
    /**
     * @var RewardCalculator
     */
    private $rewardCalculator;

    public function setUp(): void
    {
        $this->rewardCalculator = new ExampleCalculator();
    }

    /**
     * @dataProvider exampleDataProvider
     */
    public function testExample(array $dataSet)
    {
        foreach ($dataSet as [$revenue, $expectedReward]) {
            $this->assertEquals(
                $expectedReward,
                $this->rewardCalculator->calculateReward($revenue)
            );
        }
    }

    public function exampleDataProvider(): Generator
    {
        yield [
            [
                [9000, 900],
                [2000, 300],
                [-3000, -400]
            ],
            [
                [9500, 950],
                [2340.6, 418.12],
                [-3256.12, -509.67],
                [-120000, -19858.44],
                [231415.52, 38000],
            ]
        ];
    }
}
