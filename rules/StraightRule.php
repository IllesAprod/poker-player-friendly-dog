<?php
require_once __DIR__ . '/Rule.php';

/**
 * Created by PhpStorm.
 * User: aprodilles
 * Date: 2017. 10. 07.
 * Time: 15:11
 */
class StraightRule implements Rule
{

    public function isApplicable(Hand $hand)
    {
        $hand->sort();

        $cards = array_reverse($hand->getCards());

        $inARow = 1;

        foreach ($cards as $index => $card) {
            if ($inARow == 5){
                break;
            }

            if ($index < count($cards)-1){
                if ($card->getRank() - $cards[$index+1]->getRank() == 1){
                    if ($inARow == 1){
                        $this->value = $card;
                    }
                    $inARow++;
                } else {
                    $inARow = 1;
                }
            }
        }

        return $inARow == 5;
    }

    public function getValue()
    {
        return $this->value;
    }
}