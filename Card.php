<?php

require_once __DIR__ . '/Card.php';
require_once __DIR__ . '/Hand.php';
require_once __DIR__ . '/GameState.php';

/**
 * Created by PhpStorm.
 * User: aprodilles
 * Date: 2017. 10. 07.
 * Time: 11:41
 */
class Card
{

    private $rank;
    private $suit;

    function __construct($rank, $suit)
    {
        $this->rank = $rank;
        $this->suit = $suit;
    }

    /**
     * @return mixed
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * @return mixed
     */
    public function getSuit()
    {
        return $this->suit;
    }

}