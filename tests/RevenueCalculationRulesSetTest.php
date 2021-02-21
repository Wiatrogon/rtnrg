<?php

namespace Tests;

use Generator;
use PHPUnit\Framework\TestCase;
use RTNRG\RewardCalculationRule;
use RTNRG\RewardCalculationRulesSet;

class RevenueCalculationRulesSetTest extends TestCase
{
    /**
     * @var RewardCalculationRulesSet
     */
    private $rulesSet;

    public function setUp(): void
    {
        $this->rulesSet = new RewardCalculationRulesSet();
    }

    /**
     * @dataProvider getRewardDataProvider
     */
    public function testGetReward(
        float $expectedReward,
        RewardCalculationRule ...$rules
    ) {
        foreach ($rules as $rule) {
            $this->rulesSet->addRule($rule);
        }

        $this->assertEquals($expectedReward, $this->rulesSet->getReward(10000));
    }

    public function getRewardDataProvider(): Generator
    {
        yield [
            0,
            $this->getMockedRule(false, 100),
        ];

        yield [
            100.0,
            $this->getMockedRule(true, 100.0),
        ];

        yield [
            100.0,
            $this->getMockedRule(true, 100.0),
            $this->getMockedRule(false, 200.0),
        ];

        yield [
            200.0,
            $this->getMockedRule(false, 100.0),
            $this->getMockedRule(true, 200.0),
        ];

        yield [
            300.0,
            $this->getMockedRule(true, 100.0),
            $this->getMockedRule(true, 200.0),
        ];
    }

    protected function getMockedRule(bool $isApplicable, float $reward): RewardCalculationRule
    {
        $rule = $this->createMock(RewardCalculationRule::class);
        $rule->method('isApplicable')->willReturn($isApplicable);
        $rule->method('getReward')->willReturn($reward);

        return $rule;
    }
}
