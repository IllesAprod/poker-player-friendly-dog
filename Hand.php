<?php

/**
 * Created by PhpStorm.
 * User: aprodilles
 * Date: 2017. 10. 07.
 * Time: 11:43
 */
class Hand
{
    private $holeCards;
    private $communityCards;

    function __construct($holeCards, $communityCards)
    {
        $this->holeCards = $holeCards;
        $this->communityCards = $communityCards;
    }

    /**
     * @return mixed
     */
    public function getCommunityCards()
    {
        return $this->communityCards;
    }

    /**
     * @return mixed
     */
    public function getHoleCards()
    {
        return $this->holeCards;
    }


}