<?php

require_once __DIR__ . '/Rule.php';

/**
 * Created by PhpStorm.
 * User: aprodilles
 * Date: 2017. 10. 07.
 * Time: 15:11
 */
class FlushRule implements Rule
{
    public function isApplicable(Hand $hand)
    {
        $aggregator = new Aggregator();

        $isFlush = false;

        $aggregated = $aggregator->aggregateBySuit(        $hand->getCards());

        foreach ($aggregated as $suit) {
            if (count($suit) == 5){
                $isFlush = true;
                $this->value = end($suit);
            }
        }

        return $isFlush;

    }

    public function getValue()
    {
        return $this->value;
    }
}