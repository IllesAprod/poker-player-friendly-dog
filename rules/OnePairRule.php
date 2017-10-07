<?php
require_once __DIR__ . '/Rule.php';

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

        $hasPair = false;

        foreach ($cards as $index => $card){
            if ($index < count($cards) - 2){
                if ($cards[$index + 1]->getRank() == $card->getRank()){
                    $hasPair = true;
                    $this->value = $cards[$index + 1];
                }
            }
        }

        return $hasPair;
    }

    public function getValue()
    {
        return $this->value;
    }
}