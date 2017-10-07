<?php
require_once __DIR__ . '/../GameState.php';

class HandTest extends \PHPUnit\Framework\TestCase {

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

//    /** @test */
//    public function it_sorts_the_hand_cards()
//    {
//        $holeCard1 = new Card(4, 'spades');
//        $holeCard2 = new Card(11, 'hearts');
//        $communityCard1 = new Card(6, 'clubs');
//
//        $hand = new Hand([$holeCard1, $holeCard2], [$communityCard1]);
//
//        var_dump($hand->getCards());
//
//        $hand->sort();
//
//        var_dump($hand->getCards());
//    }

    /** @test */
    public function it_returns_high_card_rule()
    {
        $holeCard1 = new Card(4, 'spades');
        $holeCard2 = new Card(11, 'hearts');
        $communityCard1 = new Card(6, 'clubs');

        $hand = new Hand([$holeCard1, $holeCard2], [$communityCard1]);

        $this->assertInstanceOf(HighCardRule::class, $hand->getHighestRule());
    }

    /** @test */
    public function it_returns_highest_card()
    {
        $holeCard1 = new Card(4, 'spades');
        $holeCard2 = new Card(11, 'hearts');
        $communityCard1 = new Card(6, 'clubs');

        $hand = new Hand([$holeCard1, $holeCard2], [$communityCard1]);

        $this->assertEquals(11, $hand->getHighestRule()->getValue()->getRank());
    }
}
