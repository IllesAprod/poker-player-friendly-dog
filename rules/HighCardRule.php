<?php

require_once __DIR__ . '/Rule.php';

/**
 * Created by PhpStorm.
 * User: aprodilles
 * Date: 2017. 10. 07.
 * Time: 14:03
 */
class HighCardRule implements Rule
{
    private $value;

    public function isApplicable(Hand $hand)
    {
        $hand->sort();

        $cards = $hand->getCards();

        $this->value = end($cards);

        return true;
    }

    public function getValue()
    {
        return $this->value;
    }
}