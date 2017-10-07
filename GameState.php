<?php

/**
 * Created by PhpStorm.
 * User: aprodilles
 * Date: 2017. 10. 07.
 * Time: 11:46
 */
class GameState
{
    private $gameState;

    function __construct($gameState)
    {
        $this->gameState = $gameState;
    }

    public function getHoleCards()
    {
        return $this->getInActionPlayer()['hole_cards'];
    }

    public function getInActionPlayer()
    {
        foreach ($this->gameState['players'] as $player)
        {
            if ($player['id'] == $this->gameState['in_action'])
            {
                return $player;
            }
        }
    }

    public function getCommunityCards()
    {
        return $this->gameState['community_cards'];
    }


    public function getRemainingPlayersCount()
    {
        $outPlayersCount = 0;

        foreach ($this->gameState['players'] as $player) {
            if ($player['status'] == 'out' || $player['status'] == 'folded')
            {
                $outPlayersCount++;
            }
        }

        return count($this->gameState['players'])-$outPlayersCount;
    }

    public function getBlind(){
      return $this->gameState['small_blind']*2;
    }


}
