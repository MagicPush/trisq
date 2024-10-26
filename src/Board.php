<?php declare(strict_types=1);

namespace MagicPush\GoGame;

class Board {
    public function move($move) {}

    public function show() {
        $symbolEmpty    = '·';
        $symbolTriangle = '▲';
        $symbolSquare   = '□';

        echo ' ';
        for ($x = 'a'; $x <= 'n'; $x++) {
            echo "  {$x}";
        }
        echo PHP_EOL;

        srand(1);
        for ($y = 13; $y >= 1; $y--) {
            echo sprintf('%2d', $y);

            for ($x = 'a'; $x <= 'n'; $x++) {
                $random = rand(0, 2);
                if ($random === 1) {
                    $pointState = $symbolTriangle;
                } elseif ($random === 2) {
                    $pointState = $symbolSquare;
                } else {
                    $pointState = $symbolEmpty;
                }

                echo " {$pointState} ";
            }

            echo PHP_EOL;
        }
    }
}
