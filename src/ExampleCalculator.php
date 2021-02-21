<?php

namespace RTNRG;

class ExampleCalculator extends RewardCalculator
{
    public function __construct()
    {
        $rulesSet = new RewardCalculationRulesSet();
        $rulesSet->addRule(new RewardCalculationRule(0, 10000, 10));
        $rulesSet->addRule(new RewardCalculationRule(10000, 100000, 20));

        parent::__construct($rulesSet);
    }
}
