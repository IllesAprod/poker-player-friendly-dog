<?php

class Player
{
    const VERSION = "Default PHP folding player";

    public function betRequest($game_state)
    {
        if (count($game_state["players"]) > 2){
            return 0;
        }

        return 10000;
    }

    public function showdown($game_state)
    {
    }
}
