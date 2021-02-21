<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use RTNRG\RewardCalculationRulesSet;
use RTNRG\RewardCalculator;

class RewardCalculatorTest extends TestCase
{
    /**
     * @var RewardCalculator
     */
    private $rewardCalculator;

    public function setUp(): void
    {
        $rewardCalculationRulesSet = $this->createMock(RewardCalculationRulesSet::class);
        $rewardCalculationRulesSet->method('getReward')->willReturn(100.0);

        $this->rewardCalculator = new RewardCalculator($rewardCalculationRulesSet);
    }

    public function testAddRevenue()
    {
        $this->rewardCalculator->addRevenue(1000);
        $this->assertEquals(1000.0, $this->rewardCalculator->getTotalRevenue());

        $this->rewardCalculator->addRevenue(1000);
        $this->assertEquals(2000.0, $this->rewardCalculator->getTotalRevenue());
    }
}
