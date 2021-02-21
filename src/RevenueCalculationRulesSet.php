<?php

namespace RTNRG;

class RevenueCalculationRulesSet
{
    /**
     * @var array|RevenueCalculationRule[]
     */
    private $rules = [];

    public function addRule(RevenueCalculationRule $rule)
    {
        $this->rules[] = $rule;
    }

    public function getRevenue(float $amount): float
    {
        $revenue = 0;

        foreach ($this->rules as $rule) {
            if ($rule->isApplicable($amount)) {
                $revenue += $rule->getRevenue($amount);
            }
        }

        return $revenue;
    }
}
