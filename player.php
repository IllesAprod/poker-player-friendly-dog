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

        if ($this->gameState->isPostFlop()){
            return $this->playPostFlopStrategy();
        } else {
            return $this->playWithRelativeStack();
        }
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
              return min($call, 10000);
            }else{
              return $this->blind*3;
            }
        } else if ($rank == 2){
              if($raised){
                return min($this->blind*10, $call); //MAx shouldCallAmount
              }else{
                return $this->blind*2;
              }
        } else if($rank == 3){
              if($raised){
                return min($this->blind*5, $call); // MAX
              }else{
                return $this->gameState->shouldCallAmount();
              }
        } else if($rank == 4){
            return min($this->blind, $call); //MAX
        } else {
          return 0;
        }
    }

    public function handleRelativeSecondPhase($rank){
        $raised = $this->gameState->isSomeBodyRaised();
        $call = $this->gameState->shouldCallAmount();
      if($rank == 1){
          if($raised){
            return min($call, 10000);
          }else{
            return $this->blind*5;
          }
      } else if ($rank == 2){
            if($raised){
              return min(10000, $call); //MAx shouldCallAmount
            }else{
              return $this->blind*3;
            }
      } else if($rank == 3){
            if($raised){
              return min($this->blind*10, $call); // MAX
            }else{
              return $this->blind*2;
            }
      } else if($rank == 4){
        if($raised){
          return min($this->blind*5, $call); // MAX
        }else{
          return $this->gameState->shouldCallAmount();
        }
      } else if($rank == 5){
          return min($this->blind, $call); //MAX
      } else {
        return 0;
      }
    }

    public function handleRelativeThirdPhase($rank){
      $raised = $this->gameState->isSomeBodyRaised();
      $call = $this->gameState->shouldCallAmount();
      if($rank == 1){
            return 10000;
      } else if ($rank == 2){
            if($raised){
              return min(10000, $call); //MAx shouldCallAmount
            }else{
              return $this->blind*5;
            }
      } else if($rank == 3){
            if($raised){
              return min(10000, $call); // MAX
            }else{
              return $this->blind*3;
            }
      } else if($rank == 4){
        if($raised){
          return min(10000, $call); // MAX
        }else{
          return $this->gameState->shouldCallAmount();
        }
      } else if($rank == 5){
        if($raised){
            return min($this->blind*5, $call); //MAX
        }else{
          return $this->gameState->shouldCallAmount();
        }
      } else if($rank == 6){
        if($raised){
            return min($this->blind, $call); //MAX
        }else{
          return $this->gameState->shouldCallAmount();
        }
      } else {
        return 0;
      }
    }

    public function handleRelativeFourthPhase($rank){
      if($rank >= 7){
        return 0;
      }else{
        return 10000;
      }
    }

    public function showdown($gameState)
    {
      // NEVER EVER, FORGET IT
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

    public function playPostFlopStrategy()
    {
        $highestRule = $this->hand->getHighestRule();

        if ($highestRule instanceof HighCardRule)
        {
            $this->logger->log('HighCardRule: ' . $highestRule->getValue()->getRank());
            if ($this->gameState->getRemainingPlayersCount() > 1)
            {
                return 0;
            }
        }

        if ($highestRule instanceof OnePairRule)
        {
            $this->logger->log('OnePairRule: ' . $highestRule->getValue()->getRank());

            if ($this->gameState->getRemainingPlayersCount() > 1)
            {
                return 0;
            }
        }

        if ($highestRule instanceof TwoPairRule)
        {
            $this->logger->log('TwoPairRule: ' . $highestRule->getValue()->getRank());

            if ($this->gameState->getRemainingPlayersCount() > 1)
            {
                return 0;
            }
        }

        if ($highestRule instanceof ThreeOfAKindRule)
        {
            $this->logger->log('ThreeOfAKindRule: ' . $highestRule->getValue()->getRank());

            if ($this->gameState->getRemainingPlayersCount() > 1)
            {
                return 10000;
            } else {
                $this->gameState->shouldCallAmount();
            }
        }

        if ($highestRule instanceof StraightRule)
        {
            $this->logger->log('StraightRule: ' . $highestRule->getValue()->getRank());

            return 10000;
        }

        if ($highestRule instanceof FlushRule)
        {
            $this->logger->log('FlushRule: ' . $highestRule->getValue()->getRank());

            return 10000;
        }
    }
}
