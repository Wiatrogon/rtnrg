<?php

namespace RTNRG;

class RewardCalculationRulesSet
{
    /**
     * @var array|RewardCalculationRule[]
     */
    private $rules = [];

    public function addRule(RewardCalculationRule $rule)
    {
        $this->rules[] = $rule;
    }

    public function getReward(float $revenue): float
    {
        $reward = 0;

        foreach ($this->rules as $rule) {
            if ($rule->isApplicable($revenue)) {
                $reward += $rule->getReward($revenue);
            }
        }

        return $reward;
    }
}
