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

    /** @var StartingHandRanker */
    private $startingHandRanker;

    /** @var config */
    private $config;

    private $logger;

    function __construct()
    {
        $this->logger = new Logger();
    }

    public function getStack(){
      return $this->gameState->getInActionPlayer()['stack'];
    }

    public function getRelativeStack(){
      return $this->getStack()/$this->gameState->getBlind();
    }
    
    public function betRequest($gameState)
    {
        $this->logger->log('Bet request called');

        $this->init($gameState);

        if ($this->gameState->getRemainingPlayersCount() > 2){
            return 0;
        }
        $strHand = $this->hand->getHoleCardsAsString();
        $this->logger->log("Starting hand: ".$strHand);
        $rank = $this->startingHandRanker->getStrength($strHand);
        $this->logger->log("Starting hand rank: ".$rank);

        $relativeStack = $this->getRelativeStack();

        if($relativeStack > 25){
          if($rank == 1){
            return 10000;
          }else{
            return 0;
          }
        } else if($relativeStack > 15){
          if($rank < 3){
            return 10000;
          }else{
            return 0;
          }
        } else if($relativeStack > 10){
          if($rank < 5){
            return 10000;
          }else{
            return 0;
          }
        } else {
          return 10000;
        }
    }

    public function showdown($gameState)
    {
    }

    private function init($gameState)
    {
        $init = new Init($gameState);

        $this->config = parse_ini_file("config.ini");
        $objects = $init->init();
        $this->gameState = $objects['gameState'];
        $this->hand = $objects['hand'];
        $this->startingHandRanker = $objects['startingHandRanker'];
    }
}
