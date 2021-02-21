<?php

namespace RTNRG;

class RewardCalculator
{
    /**
     * @var RewardCalculationRulesSet
     */
    private $rewardCalculationRulesSet;

    /**
     * @var float
     */
    private $totalRevenue;

    /**
     * @var float
     */
    private $currentReward;

    public function __construct(
        RewardCalculationRulesSet $rewardCalculationRulesSet,
        float $initialRevenue = 0.0,
        float $initialReward = 0.0
    ) {

        $this->rewardCalculationRulesSet = $rewardCalculationRulesSet;
        $this->totalRevenue = $initialRevenue;
        $this->currentReward = $initialReward;
    }

    public function calculateReward(float $revenue): float
    {
        $this->totalRevenue += $revenue;
        $totalReward = $this->getTotalReward();
        $reward = $totalReward - $this->currentReward;
        $this->currentReward = $totalReward;

        return $reward;
    }

    /**
     * @return float
     */
    public function getTotalRevenue(): float
    {
        return $this->totalRevenue;
    }

    public function getTotalReward(): float
    {
        return $this->rewardCalculationRulesSet->getReward($this->totalRevenue);
    }
}
