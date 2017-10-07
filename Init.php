<?php

require __DIR__ . '/Card.php';
require __DIR__ . '/Hand.php';

/**
 * Created by PhpStorm.
 * User: aprodilles
 * Date: 2017. 10. 07.
 * Time: 12:01
 */
class Init
{
    private $gameState;

    function __construct($gameState)
    {
        $this->gameState = $gameState;
    }

    private function convertCardsJsonToObjects($cards)
    {
        $objects = [];

        foreach ($cards as $card)
        {
            $objects[] = new Card($card['rank'], $card['suit']);
        }

        return $objects;
    }

    public function init()
    {
        $gameStateObject = new GameState($this->gameState);
        $holeCards = $this->convertCardsJsonToObjects($gameStateObject->getHoleCards());
        $communityCards = $this->convertCardsJsonToObjects($gameStateObject->getCommunityCards());

        $hand = new Hand($holeCards, $communityCards);

        return [
            'gameState' => $gameStateObject,
            'hand' => $hand,
        ];
    }



}