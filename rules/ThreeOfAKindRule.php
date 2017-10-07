<?php
require_once __DIR__ . '/Rule.php';

/**
 * Created by PhpStorm.
 * User: aprodilles
 * Date: 2017. 10. 07.
 * Time: 15:11
 */
class ThreeOfAKindRule implements Rule
{

    public function isApplicable(Hand $hand)
    {
        $hand->sort();

        $cards = $hand->getCards();

        $aggregator = new Aggregator();
        $aggregated = $aggregator->aggregateByRank($cards);

        $drillCount = 0;

        foreach ($aggregated as $rank)
        {
            if (count($rank) == 3){
                $drillCount++;
                $this->value = end($rank);
            }
        }

        return $drillCount == 1;
    }

    public function getValue()
    {
        // TODO: Implement getValue() method.
    }
}