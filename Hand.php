<?php

require_once __DIR__ . '/Card.php';
require_once __DIR__ . '/Hand.php';
require_once __DIR__ . '/GameState.php';
require_once __DIR__ . '/rules/HighCardRule.php';

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
    private $cards;

    function __construct($holeCards, $communityCards)
    {
        $this->holeCards = $holeCards;
        $this->communityCards = $communityCards;
        $this->cards = array_merge($holeCards, $communityCards);
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

    public function getHighestRule()
    {
        $rules = [
            new HighCardRule(),
        ];

        foreach ($rules as $rule) {
            if ($rule->isApplicable($this)){
                return $rule;
            }
        }

        throw new Exception('Baj van: 1');
    }

    public function sort()
    {
        $sorting = function($cardA, $cardB){
            return $cardA->compare($cardB);
        };

        usort($this->cards, $sorting);
    }

    public function getCards()
    {
        return $this->cards;
    }


}
