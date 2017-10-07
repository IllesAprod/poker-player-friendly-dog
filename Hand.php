<?php

require_once __DIR__ . '/Card.php';
require_once __DIR__ . '/Hand.php';
require_once __DIR__ . '/GameState.php';

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

    public function getHoleCardsAsString(){
      $rank1 = $this->holeCards[0]->getRank();
      $rank2 = $this->holeCards[1]->getRank();

      $suitStr = 's';
      if(($rank1 != $rank2) && $this->holeCards[0]->getSuit() != $this->holeCards[1]->getSuit()){
        $suitStr = 'o';
      }

      return $rank1.$rank2.$suitStr;
    }


}
