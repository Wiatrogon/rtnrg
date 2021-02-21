<?php

namespace RTNRG;

class RewardCalculationRule
{
    /**
     * @var float
     */
    private $lowerThreshold;

    /**
     * @var float
     */
    private $upperThreshold;

    /**
     * @var int
     */
    private $percent;

    public function __construct(
        float $lowerThreshold,
        float $upperThreshold,
        int $percent
    ) {

        $this->lowerThreshold = $lowerThreshold;
        $this->upperThreshold = $upperThreshold;
        $this->percent = $percent;
    }

    public function isApplicable(float $revenue): bool
    {
        return $revenue > 0
            ? $revenue > $this->lowerThreshold
            : -$revenue > $this->lowerThreshold;
    }

    public function getReward(float $revenue): float
    {
        return $this->isApplicable($revenue)
            ? $this->calculateReward($revenue)
            : 0;
    }

    protected function calculateReward(float $revenue): float
    {
        return $this->getRewardBase($revenue) * $this->percent / 100;
    }

    protected function getRewardBase(float $revenue): float
    {
        return $revenue > 0
            ? min($revenue - $this->lowerThreshold, $this->upperThreshold)
            : max($revenue + $this->lowerThreshold, -$this->upperThreshold);
    }
}
