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

    /** @var blind*/
    private $blind;

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
      return $this->getStack()/$this->blind;
    }

    public function betRequest($gameState)
    {
        $this->logger->log('Bet request called');

        $this->init($gameState);

        if ($this->gameState->getRemainingPlayersCount() > 2){
            return 0;
        }

        return $this->playWithRelativeStack();
    }

    public function playWithRelativeStack(){
      $strHand = $this->hand->getHoleCardsAsString();
      $this->logger->log("Starting hand: ".$strHand);
      $rank = $this->startingHandRanker->getStrength($strHand);
      $this->logger->log("Starting hand rank: ".$rank);

      $relativeStack = $this->getRelativeStack();

      if($relativeStack > $this->config['relative_phase_one_limit']){
        return $this->handleRelativeFirstPhase($rank);
      } else if($relativeStack > $this->config['relative_phase_two_limit']){
        return $this->handleRelativeSecondPhase($rank);
      } else if($relativeStack > $this->config['relative_phase_three_limit']){
        return $this->handleRelativeThirdPhase($rank);
      } else {
        return $this->handleRelativeFourthPhase($rank);
      }
    }

    public function handleRelativeFirstPhase($rank){
      $raised = $this->gameState->isSomeBodyRaised();
      $call = $this->gameState->shouldCallAmount();
        if($rank == 1){
            if($raised){
              return max($call, 10000);
            }else{
              return $this->blind*3;
            }
        } else if ($rank == 2){
              if($raised){
                return max($this->blind*10, $call); //MAx shouldCallAmount
              }else{
                return $this->blind*2;
              }
        } else if($rank == 3){
              if($raised){
                return max($this->blind*5, $call); // MAX
              }else{
                return $this->gameState->shouldCallAmount();
              }
        } else if($rank == 4){
            return max($this->blind, $call); //MAX
        } else {
          return 0;
        }
    }

    public function handleRelativeSecondPhase($rank){
      if($rank <= $this->config['relative_phase_two_rank_limit']){
        return 10000;
      }else{
        return 0;
      }
    }

    public function handleRelativeThirdPhase($rank){
      if($rank <= $this->config['relative_phase_three_rank_limit']){
        return 10000;
      }else{
        return 0;
      }
    }

    public function handleRelativeFourthPhase($rank){
      return 10000;
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
        $this->blind = $this->gameState->getBlind();
        $this->hand = $objects['hand'];
        $this->startingHandRanker = $objects['startingHandRanker'];
    }
}
