<?php

require __DIR__ . '/../player.php';

class PlayerTest extends \PHPUnit\Framework\TestCase {

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
              "id": 1,
              "name": "Chuck",
              "status": "out",
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

    /** @test */
    public function it_returns_an_integer()
    {
        $player = new \Player();

        $response = $this->betRequest($player, $this->gameState);

        var_dump($response);

        $this->assertTrue(is_integer($response));
    }

    /** @test */
    public function it_folds_if_more_than_2_players_in_the_table()
    {
        $player = new \Player();

        $response = $this->betRequest($player, $this->gameState);

        $this->assertTrue($response == 0);
    }

    private function betRequest(Player $player, $gameState)
    {
        $player->betRequest(json_decode($gameState, true));
    }

    /** @test */
    public function it_parses_json()
    {
        $json = json_decode($this->gameState, true);

        $this->assertTrue(is_array());
    }
}
