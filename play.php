<?php declare(strict_types=1);

use MagicPush\GoGame\Board;

require_once __DIR__ . '/vendor/autoload.php';

try {
    $args = $argv;
    array_shift($args);

    $board = new Board();
    foreach ($args as $move) {
        $board->move($move);
    }

    $board->show();
} catch (Exception $e) {
    echo $e->getMessage() . "\n";

    exit(1);
}
