<?php

/**
 * Created by PhpStorm.
 * User: aprodilles
 * Date: 2017. 10. 07.
 * Time: 15:39
 */
class Aggregator
{
    public function aggregateByRank($cards)
    {
        $aggregated = [];

        foreach ($cards as $card){
            $aggregated[$card->getRank()][] = $card;
        }

        return $aggregated;
    }

    public function aggregateBySuit($cards)
    {
        $aggregated = [];

        foreach ($cards as $card){
            $aggregated[$card->getSuit()][] = $card;
        }

        return $aggregated;
    }
}