<?php

namespace Tests;

use Generator;
use PHPUnit\Framework\TestCase;
use RTNRG\RevenueCalculationRule;

class RevenueCalculationRuleTest extends TestCase
{
    /**
     * @dataProvider ruleIsApplicableDataProvider
     */
    public function testRuleIsApplicable(
        float $lowerThreshold,
        float $upperThreshold,
        float $amount
    ) {
        $rule = new RevenueCalculationRule($lowerThreshold, $upperThreshold, 100);
        $this->assertTrue($rule->isApplicable($amount));
    }

    public function ruleIsApplicableDataProvider(): Generator
    {
        yield [0, 100, 10];
        yield [0, 100, 100];

        yield [0, 100, -10];

        yield [0, 100, -100];

        yield [100, 1000, 500];
        yield [100, 1000, -500];
        yield [100, 1000, 1000];
    }

    /**
     * @dataProvider ruleIsNotApplicableDataProvider
     */
    public function testRuleInNotApplicable(
        float $lowerThreshold,
        float $upperThreshold,
        float $amount
    ) {
        $rule = new RevenueCalculationRule($lowerThreshold, $upperThreshold, 100);
        $this->assertFalse($rule->isApplicable($amount));
    }

    public function ruleIsNotApplicableDataProvider(): Generator
    {
        yield [100, 1000, 10];
        yield [100, 1000, -10];
    }

    /**
     * @dataProvider noRevenueDataProvider
     */
    public function testNoRevenue(
        RevenueCalculationRule $rule,
        float $amount
    ) {
        $this->assertEquals(0, $rule->getRevenue($amount));
    }

    public function noRevenueDataProvider(): Generator
    {
        yield [
            new RevenueCalculationRule(0, 100, 100),
            0,
        ];

        yield [
            new RevenueCalculationRule(100, 1000, 20),
            100,
            0,
        ];

        yield [
            new RevenueCalculationRule(100, 1000, 20),
            -100,
            0,
        ];
    }

    /**
     * @dataProvider getRevenueDataProvider
     */
    public function testGetRevenue(
        RevenueCalculationRule $rule,
        float $amount,
        float $expectedRevenue
    ) {
        $this->assertEquals($expectedRevenue, $rule->getRevenue($amount));
    }

    public function getRevenueDataProvider(): Generator
    {
        yield [
            new RevenueCalculationRule(0, 10000, 10),
            9000,
            900.0
        ];

        yield [
            new RevenueCalculationRule(0, 10000, 10),
            11000,
            1000.0
        ];

        yield [
            new RevenueCalculationRule(10000, 100000, 20),
            11000,
            200.0
        ];

        yield [
            new RevenueCalculationRule(0, 10000, 10),
            -120000,
            -1000
        ];

        yield [
            new RevenueCalculationRule(10000, 100000, 20),
            -120000,
            -20000
        ];
    }
}
