<?php

require_once __DIR__ . '/../StartingHandRanker.php';

class StartingHandRankerTest extends \PHPUnit\Framework\TestCase {
/*
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
              "id": 2,
              "name": "Bob",
              "status": "active",
              "version": "Default random player",
              "stack": 1590,
              "bet": 80,
              "hole_cards": [
                  {
                      "rank": "A",
                      "suit": "spades"
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

    public function it_returns_6Ko()
    {
        $startingHand = new StartingHandRanker();

        $response = $startingHand->getHoleCardsAsString($this->parse($this->gameState));

        var_dump($response);

        $this->assertTrue($response == '6Ko');
    }

    public function it_returns_AKs()
    {
        $startingHand = new StartingHandRanker();

        $response = $startingHand->getHoleCardsAsString($this->parse($this->gameState2));

        var_dump($response);

        $this->assertTrue($response == 'AKs');
    }
*/
    /** @test */
    public function it_returns_rank_for_AKs()
        {
            $startingHand = new StartingHandRanker();

            $response = $startingHand->getStrength('AKs');

            var_dump($response);

            $this->assertTrue($response == 1);
        }

        /** @test */
        public function it_returns_rank_for_32o()
            {
                $startingHand = new StartingHandRanker();

                $response = $startingHand->getStrength('32o');

                var_dump($response);

                $this->assertTrue($response == 8);
            }

            public function it_returns_rank_for_3Ks()
                {
                    $startingHand = new StartingHandRanker();

                    $response = $startingHand->getStrength('3Ko');

                    var_dump($response);

                    $this->assertTrue($response == 8);
                }

    private function parse($gameState)
    {
        return json_decode($gameState, true);
    }

}
