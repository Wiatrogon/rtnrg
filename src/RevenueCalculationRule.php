<?php

namespace RTNRG;

class RevenueCalculationRule
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

    public function isApplicable(float $amount): bool
    {
        return $amount > 0
            ? $amount > $this->lowerThreshold
            : -$amount > $this->lowerThreshold;
    }

    public function getRevenue(float $amount): float
    {
        return $this->isApplicable($amount)
            ? $this->calculateRevenue($amount)
            : 0;
    }

    protected function calculateRevenue(float $amount): float
    {
        return $this->getRevenueBase($amount) * $this->percent / 100;
    }

    protected function getRevenueBase(float $amount): float
    {
        return $amount > 0
            ? min($amount - $this->lowerThreshold, $this->upperThreshold)
            : max($amount + $this->lowerThreshold, -$this->upperThreshold);
    }
}
