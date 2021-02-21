<?php

namespace Tests;

use Generator;
use PHPUnit\Framework\TestCase;
use RTNRG\RevenueCalculationRule;
use RTNRG\RevenueCalculationRulesSet;

class RevenueCalculationRulesSetTest extends TestCase
{
    /**
     * @var RevenueCalculationRulesSet
     */
    private $rulesSet;

    public function setUp(): void
    {
        $this->rulesSet = new RevenueCalculationRulesSet();
    }

    /**
     * @dataProvider getRevenueDataProvider
     */
    public function testGetRevenue(
        float $expectedRevenue,
        RevenueCalculationRule ...$rules
    ) {
        foreach ($rules as $rule) {
            $this->rulesSet->addRule($rule);
        }

        $this->assertEquals($expectedRevenue, $this->rulesSet->getRevenue(10000));
    }

    public function getRevenueDataProvider(): Generator
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

    protected function getMockedRule(bool $isApplicable, float $revenue): RevenueCalculationRule
    {
        $rule = $this->createMock(RevenueCalculationRule::class);
        $rule->method('isApplicable')->willReturn($isApplicable);
        $rule->method('getRevenue')->willReturn($revenue);

        return $rule;
    }
}
