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
        return 0;
    }
}
