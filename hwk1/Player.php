<?php 
class Player { 
    private $name;
    private $team; 
    private $gamesPlayed;
    private $freeThrowPct;
    private $pointsPerGame;
    private $threePtPct;
    
    public function __construct($name, $team, $gamesPlayed, $freeThrowPct, $pointsPerGame, $threePointPct) {
        $this->name = $name;
        $this->team = $team;
        $this->gamesPlayed = $gamesPlayed;
        $this->freeThrowPct = $freeThrowPct;
        $this->pointsPerGame = $pointsPerGame;
        $this->threePointPct = $threePointPct;
    }

    public function getName() { 
        return $this->name;
    }

    public function getTeam() {
        return $this->team;
    }

    public function getGamesPlayed() {
        return $this->gamesPlayed;
    } 

    public function getFreeThrowPct() {
        return $this->freeThrowPct;
    }

    public function getPointsPerGame() {
        return $this->pointsPerGame;
    }

    public function getThreePointPct() {
        return $this->threePointPct;
    }

    public static function printPlayer($player) {
        echo 'Player: ' . $player->getName() . '</br>';
    }
} 
?> 