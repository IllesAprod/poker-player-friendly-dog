<?php

class Player
{
    const VERSION = "Default PHP folding player";

    public function betRequest($gameState)
    {
        if ($this->countActivePlayers($gameState) > 2){
            return 0;
        }

        return 10000;
    }

    public function showdown($game_state)
    {
    }

    public function countActivePlayers($gameState)
    {
        $count = 0;
        foreach ($gameState['players'] as $player){
            if ($player['status'] == 'active'){
                $count++;
            }
        }

        return $count;
    }
}
