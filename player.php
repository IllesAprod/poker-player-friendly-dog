<?php

require __DIR__ . '/Init.php';
require __DIR__. '/Logger.php';

class Player
{
    const VERSION = "Default PHP folding player";

    /** @var  GameState */
    private $gameState;

    /** @var  Hand */
    private $hand;

    private $logger;

    function __construct()
    {
        $this->logger = new Logger();
    }

    public function betRequest($gameState)
    {
        $this->logger->log('Bet request called');

        $this->init($gameState);

        if ($this->gameState->getRemainingPlayersCount() > 2){
            return 0;
        }

        return 10000;
    }

    public function showdown($gameState)
    {
    }

    private function init($gameState)
    {
        $init = new Init($gameState);
        $objects = $init->init();
        $this->gameState = $objects['gameState'];
        $this->hand = $objects['hand'];
    }
}
