<?php declare(strict_types=1);

namespace MagicPush\GoGame\Tests;

use Exception;
use PHPUnit\Framework\TestCase;

abstract class TestCaseAbstract extends TestCase {
    protected function testFile($filePath, $extraMessage = '') {
        if (!file_exists($filePath)) {
            throw new Exception("File '{$filePath}' does not exist");
        }

        $expectedOutput = file($filePath, FILE_IGNORE_NEW_LINES);
        if (!$expectedOutput) {
            throw new Exception("Unable to read '{$filePath}' or the file is empty");
        }

        $movesLine        = trim(array_shift($expectedOutput));
        $movesDescription = $movesLine ?: '(no moves)';

        $isErrorExpected = trim($expectedOutput[0]) === 'error';

        $consoleRedColor   = '';
        $consoleResetColor = '';
        if (function_exists('posix_isatty') && posix_isatty(STDOUT)) {
            $consoleRedColor   = "\033[31m";
            $consoleResetColor = "\033[m";
        }

        $newLine = PHP_EOL;

        if ($extraMessage) {
            $extraMessage = "{$newLine}{$extraMessage}";
        }

        exec("php play.php {$movesLine}", $actualOutput, $resultCode);
        if ($isErrorExpected) {
            static::assertNotSame(
                0,
                $resultCode,
                "{$consoleRedColor}There should be an error, but the program does not detect that:{$newLine}{$movesDescription}{$extraMessage}{$consoleResetColor}{$newLine}",
            );

            return;
        }

        static::assertSame(
            0,
            $resultCode,
            "{$consoleRedColor}Moves are correct, but the program detects an error:{$newLine}{$movesDescription}{$extraMessage}{$consoleResetColor}{$newLine}",
        );
        static::assertSame($expectedOutput, $actualOutput, "{$consoleRedColor}Invalid board state after moves:{$newLine}{$movesDescription}{$extraMessage}{$consoleResetColor}{$newLine}");
    }
}
