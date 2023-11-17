<?php 

class Utils {
    public static function getRandomNbr($nbrMin, $nbrMax) {
        return rand($nbrMin, $nbrMax);
    }
}

class Game {
    public function __construct($difficulty, $characters, $enemies) {
        $turns = $difficulty[Utils::getRandomNbr(0, 2)];
        echo "Nombre de tours dans le jeu: " . $turns . "<br>";
        $player = $characters[Utils::getRandomNbr(0, 2)];
        echo "Personnage pour le jeu: " . $player->getName() . "<br>";
        echo "Caractéristiques du personnage: " . $player->getNbrMarbles() . " billes, - " . $player->getPenalty() . " billes par partie perdue et + " . $player->getBonus() . " par partie gagnée" . "<br>";
        $this->confrontations($turns, $enemies, $player);
        echo "<br>";
        echo "<br>";

        if ($player->getNbrMarbles() > 0 ) {
            echo "Bravo t pas mort";
        } else {
            echo "t mort";
        }
    }

    function confrontations($turns, $enemies, $player) {
        $currentTurn = 0;
        for ($currentTurn; $currentTurn < $turns; $currentTurn++) {
            $enemy = $enemies[$currentTurn];
            echo "<br> Tour: " . $currentTurn + 1 . "<br>";
            echo "Vous affrontez " . $enemy->getName() . ", " . $enemy->getAge() . " ans" . "<br>";
            echo "Vous avez " . $player->getNbrMarbles() . " billes <br>";

            $confrontationResult = Utils::getRandomNbr(0, 1);

            if ($enemy->getAge() > 70 && Utils::getRandomNbr(0, 1) == 0) {
                echo "L'adversaire possède " . $enemy->getNbrMarbles() . " billes <br>";
                echo "Vous volez ses billes <br>";
                $player->setNbrMarbles($player->getNbrMarbles() + $enemy->getNbrMarbles());
            } else {

                $playerGuess = $this->getPlayerGuess($confrontationResult);
                $gameResult = $this->getGameResult($playerGuess, $enemy->getNbrMarbles());

                $this->applyGameResult($enemy, $player, $gameResult);

                if ($player->getNbrMarbles() <= 0) {
                    break;
                }
            }
            echo "Vous avez " . $player->getNbrMarbles() . " billes <br>";
        }
    }

    private function getPlayerGuess($confrontationResult)
    {
        if ($confrontationResult == 0) {
            $playerGuess = "odd";
            echo "Vous devinez que l'adversaire possède un nombre impair de billes <br>";
        } else if ($confrontationResult == 1) {
            $playerGuess = "even";
            echo "Vous devinez que l'adversaire possède un nombre pair de billes <br>";
        }
        return $playerGuess;
    }

    private function getGameResult($playerGuess, $enemyMarbles)
    {
        if ($playerGuess == "even" && $enemyMarbles % 2 == 0 || $playerGuess == "odd" && $enemyMarbles % 2 != 0) {
            $gameResult = "win";
        } else {
            $gameResult = "lose";
        }

        return $gameResult;
    }

    private function applyGameResult($enemy, $player, $gameResult)
    {
        echo "L'adversaire possède " . $enemy->getNbrMarbles() . " billes <br>";

        if ($gameResult == "win") {
            echo "Win <br>";
            if ($player->getWarCry() != "none") {
                echo $player->getWarCry() . "<br>";
            }
            echo "Bonus de " . $player->getBonus() . " billes <br>";
            $player->setNbrMarbles($player->getNbrMarbles() + $enemy->getNbrMarbles());
            $reward = $player->getBonus();
        } else {
            echo "Lose <br>";
            echo "Malus de " . $player->getPenalty() . " billes <br>";
            $player->setNbrMarbles($player->getNbrMarbles() - $enemy->getNbrMarbles());
            $reward = -$player->getPenalty();
        }
        $player->setNbrMarbles($player->getNbrMarbles() + $reward);
    }
}

class Person {
    protected $name;
    protected $nbrMarbles;

    public function getName() {
        return $this->name;
    }

    public function getNbrMarbles() {
        return $this->nbrMarbles;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setNbrMarbles($nbrMarbles) {
        $this->nbrMarbles = $nbrMarbles;
    }
}

class Character extends Person {
    private $penalty;
    private $bonus;
    private $warCry;

    public function __construct($name, $nbrMarbles, $penalty, $bonus, $warCry = "none") {
        $this->name = $name;
        $this->nbrMarbles = $nbrMarbles;
        $this->penalty = $penalty;
        $this->bonus = $bonus;
        $this->warCry = $warCry;    
    }

    public function getPenalty() {
        return $this->penalty;
    }

    public function getBonus() {
        return $this->bonus;
    }

    public function getWarCry() {
        return $this->warCry;
    }

    public function setPenalty($penalty) {
        $this->penalty = $penalty;
    }

    public function setBonus($bonus) {
        $this->bonus = $bonus;
    }

    public function setWarCry($warCry) {
        $this->warCry = $warCry;
    }
};

class Enemy extends Person {
    private $age;

    public function __construct($name, $nbrMarbles, $age) {
        $this->name = $name;
        $this->nbrMarbles = $nbrMarbles;
        $this->age = $age;   
    }

    public function getAge() {
        return $this->age;
    }

    public function setAge($age) {
        $this->name = $age;
    }
}


$difficulty = [5, 10, 20];

$characters = [
    new Character("Seong Gi-hun", "15", "2", "1", "ez"),
    new Character("Kang Sae-byeok", "25", "1", "2", "wawawawawwawawawawa"),
    new Character("Cho Sang-woo", "35", "0", "3")
];


$enemies = [
    new Enemy("Name1", Utils::getRandomNbr(1, 20), Utils::getRandomNbr(20, 100)),
    new Enemy("Name2", Utils::getRandomNbr(1, 20), Utils::getRandomNbr(20, 100)),
    new Enemy("Name3", Utils::getRandomNbr(1, 20), Utils::getRandomNbr(20, 100)),
    new Enemy("Name4", Utils::getRandomNbr(1, 20), Utils::getRandomNbr(20, 100)),
    new Enemy("Name5", Utils::getRandomNbr(1, 20), Utils::getRandomNbr(20, 100)),
    new Enemy("Name6", Utils::getRandomNbr(1, 20), Utils::getRandomNbr(20, 100)),
    new Enemy("Name7", Utils::getRandomNbr(1, 20), Utils::getRandomNbr(20, 100)),
    new Enemy("Name8", Utils::getRandomNbr(1, 20), Utils::getRandomNbr(20, 100)),
    new Enemy("Name9", Utils::getRandomNbr(1, 20), Utils::getRandomNbr(20, 100)),
    new Enemy("Name10", Utils::getRandomNbr(1, 20), Utils::getRandomNbr(20, 100)),
    new Enemy("Name11", Utils::getRandomNbr(1, 20), Utils::getRandomNbr(20, 100)),
    new Enemy("Name12", Utils::getRandomNbr(1, 20), Utils::getRandomNbr(20, 100)),
    new Enemy("Name13", Utils::getRandomNbr(1, 20), Utils::getRandomNbr(20, 100)),
    new Enemy("Name14", Utils::getRandomNbr(1, 20), Utils::getRandomNbr(20, 100)),
    new Enemy("Name15", Utils::getRandomNbr(1, 20), Utils::getRandomNbr(20, 100)),
    new Enemy("Name16", Utils::getRandomNbr(1, 20), Utils::getRandomNbr(20, 100)),
    new Enemy("Name17", Utils::getRandomNbr(1, 20), Utils::getRandomNbr(20, 100)),
    new Enemy("Name18", Utils::getRandomNbr(1, 20), Utils::getRandomNbr(20, 100)),
    new Enemy("Name19", Utils::getRandomNbr(1, 20), Utils::getRandomNbr(20, 100)),
    new Enemy("Name20", Utils::getRandomNbr(1, 20), Utils::getRandomNbr(20, 100)),
];
shuffle($enemies);

new Game($difficulty, $characters, $enemies);