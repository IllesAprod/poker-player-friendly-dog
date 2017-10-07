<?php
require __DIR__ . '/../GameState.php';

class GameStateTest extends \PHPUnit\Framework\TestCase {

    private $gameState = <<<EOL
  {
      "tournament_id":"550d1d68cd7bd10003000003",
      "game_id":"550da1cb2d909006e90004b1",
      "round":0,
      "bet_index":0,
      "small_blind": 10,
      "current_buy_in": 320,
      "pot": 400,
      "minimum_raise": 240,
      "dealer": 1,
      "orbits": 7,
      "in_action": 2,

      "players": [
        {
              "id": 0,
              "name": "Albert",
              "status": "active",
              "version": "Default random player",
              "stack": 1010,
              "bet": 320
          },
          {
              "id": 1,
              "name": "Chuck",
              "status": "active",
              "version": "Default random player",
              "stack": 0,
              "bet": 0
          },
          {
              "id": 2,
              "name": "Bob",
              "status": "active",
              "version": "Default random player",
              "stack": 1590,
              "bet": 80,
              "hole_cards": [
                  {
                      "rank": "6",
                      "suit": "hearts"
                  },
                  {
                      "rank": "K",
                      "suit": "spades"
                  }
              ]
          }
      ],
      "community_cards": [
          {
              "rank": "4",
              "suit": "spades"
          },
          {
              "rank": "A",
              "suit": "hearts"
          },
          {
              "rank": "6",
              "suit": "clubs"
          }
      ]
  }
EOL;

    private $gameState2 = <<<EOL
  {
      "tournament_id":"550d1d68cd7bd10003000003",
      "game_id":"550da1cb2d909006e90004b1",
      "round":0,
      "bet_index":0,
      "small_blind": 10,
      "current_buy_in": 320,
      "pot": 400,
      "minimum_raise": 240,
      "dealer": 1,
      "orbits": 7,
      "in_action": 1,

      "players": [
        {
              "id": 0,
              "name": "Albert",
              "status": "active",
              "version": "Default random player",
              "stack": 1010,
              "bet": 320
          },
          {
              "id": 2,
              "name": "Bob",
              "status": "active",
              "version": "Default random player",
              "stack": 1590,
              "bet": 80,
              "hole_cards": [
                  {
                      "rank": "6",
                      "suit": "hearts"
                  },
                  {
                      "rank": "K",
                      "suit": "spades"
                  }
              ]
          }
      ],
      "community_cards": [
          {
              "rank": "4",
              "suit": "spades"
          },
          {
              "rank": "A",
              "suit": "hearts"
          },
          {
              "rank": "6",
              "suit": "clubs"
          }
      ]
  }
EOL;

    /** @test */
    public function it_returns_the_in_action_player()
    {
        $gameStateJson = $this->parse($this->gameState);

        $gameState = new GameState($gameStateJson);

        $this->assertEquals($gameState->getInActionPlayer(),$gameStateJson['players'][2]);
    }

    /** @test */
    public function it_returns_the_in_hole_cards()
    {
        $gameStateJson = $this->parse($this->gameState);

        $gameState = new GameState($gameStateJson);

        $this->assertEquals($gameState->getHoleCards(),$gameStateJson['players'][2]['hole_cards']);
    }

    /** @test */
    public function it_returns_the_community_cards()
    {
        $gameStateJson = $this->parse($this->gameState);

        $gameState = new GameState($gameStateJson);

        $this->assertEquals($gameState->getCommunityCards(),$gameStateJson['community_cards']);
    }

    /** @test */
    public function it_counts_the_remaining_players()
    {
        $gameStateJson = $this->parse($this->gameState);

        $gameState = new GameState($gameStateJson);

        $this->assertEquals($gameState->getRemainingPlayersCount(),3);
    }

    private function parse($gameState)
    {
        return json_decode($gameState, true);
    }
}
