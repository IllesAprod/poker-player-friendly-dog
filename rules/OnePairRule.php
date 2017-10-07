<?php
require_once __DIR__ . '/Rule.php';
require_once __DIR__ . '/../Aggregator.php';


/**
 * Created by PhpStorm.
 * User: aprodilles
 * Date: 2017. 10. 07.
 * Time: 15:10
 */
class OnePairRule implements Rule
{
    private $value;

    public function isApplicable(Hand $hand)
    {
        $hand->sort();

        $cards = $hand->getCards();

        $aggregator = new Aggregator();
        $aggregated = $aggregator->aggregateByRank($cards);

        $pairCount = 0;

        foreach ($aggregated as $rank)
        {
            if (count($rank) == 2){
                $pairCount++;
                $this->value = end($rank);
            }
        }

        return $pairCount == 1;
    }

    public function getValue()
    {
        return $this->value;
    }
}