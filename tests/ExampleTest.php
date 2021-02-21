<?php

namespace Tests;

use Generator;
use PHPUnit\Framework\TestCase;
use RTNRG\RewardCalculationRule;
use RTNRG\RewardCalculationRulesSet;
use RTNRG\RewardCalculator;

class ExampleTest extends TestCase
{
    /**
     * @var RewardCalculator
     */
    private $rewardCalculator;

    public function setUp(): void
    {
        $set = new RewardCalculationRulesSet();
        $set->addRule(new RewardCalculationRule(0, 10000, 10));
        $set->addRule(new RewardCalculationRule(10000, 100000, 20));

        $this->rewardCalculator = new RewardCalculator($set);
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
