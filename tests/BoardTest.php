<?php declare(strict_types=1);

namespace MagicPush\GoGame\Tests;

class BoardTest extends TestCaseAbstract {
    /**
     * @group task1
     */
    public function testSimpleInput() {
        $this->testFile(__DIR__ . '/dataSets/ok-simple-input.txt');
    }

    /**
     * @group task1
     */
    public function testCanNotPlaceAFigureOnTopOfAnotherFigure() {
        $this->testFile(__DIR__ . '/dataSets/error-figure-on-top-of-figure.txt');
    }

    /**
     * @group task2
     */
    public function testCaptureTriangle() {
        $this->testFile(
            __DIR__ . '/dataSets/capture-triangle.txt',
            '1 triangle must be captured: h3',
        );
    }

    /**
     * @group task2
     */
    public function testCaptureSquareCornered() {
        $this->testFile(
            __DIR__ . '/dataSets/capture-square-cornered.txt',
            '1 square must be captured: n2',
        );
    }

    /**
     * @group task2
     */
    public function testNoRepetitionMergedStars() {
        $this->testFile(__DIR__ . '/dataSets/error-no-repetition-merged-stars.txt');
    }

    /**
     * @group task2
     */
    public function testNoRepetitionRuleCornered() {
        $this->testFile(__DIR__ . '/dataSets/error-no-repetition-cornered.txt');
    }

    /**
     * @group task2
     */
    public function testNoSuicideSquareCornered() {
        $this->testFile(__DIR__ . '/dataSets/error-suicide-square-cornered.txt');
    }
}
