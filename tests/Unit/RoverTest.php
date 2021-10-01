<?php

namespace Tests\Unit;

use App\Rover;
use PHPUnit\Framework\TestCase;

class RoverTest extends TestCase
{

    public function testInitMap()
    {
        $rover = new Rover(5, 10);
        $map = $rover->getMap();

        $result = sizeof($map);
        $this->assertEquals(5, $result);
        $result = sizeof($map[0]);
        $this->assertEquals(10, $result);
    }


    /**
     * @dataProvider dataRotateLeftProvider
     */
    public function testCanRorateLeft($input, $expected)
    {
        $rover = new Rover(10, 10);

        $result = $rover->execute($input);

        $this->assertEquals($expected, $result);
    }

    public function dataRotateLeftProvider(): array
    {
        return [
            ["", "0:0:N"],
            ["L", "0:0:W"],
            ["LL", "0:0:S"],
            ["LLL", "0:0:E"],
            ["LLLL", "0:0:N"],
        ];
    }

    /**
     * @dataProvider dataRotateRightProvider
     */
    public function testCanRorateRight($input, $expected)
    {
        $rover = new Rover(10, 10);

        $result = $rover->execute($input);

        $this->assertEquals($expected, $result);
    }

    public function dataRotateRightProvider(): array
    {
        return [
            ["", "0:0:N"],
            ["R", "0:0:E"],
            ["RR", "0:0:S"],
            ["RRR", "0:0:W"],
            ["RRRR", "0:0:N"],
        ];
    }

    /**
     * @dataProvider dataMoveProvider
     */
    public function testMove($input, $expected)
    {
        $rover = new Rover(10, 10);

        $result = $rover->execute($input);

        $this->assertEquals($expected, $result);
    }

    public function dataMoveProvider(): array
    {
        return [
            ["", "0:0:N"],
            ["M", "0:9:N"],
            ["MM", "0:8:N"],
            ["MLM", "9:9:W"],
            ["MLMLLM", "0:9:E"],
            ["MLMLLMRMRR", "0:0:N"],
            ["LM", "9:0:W"],
            ["RM", "1:0:E"],
        ];
    }

    /**
     * @dataProvider dataMoveWithColisionProvider
     */
    public function testMoveWithColision($input, $obstacles, $expected)
    {
        $rover = new Rover(10, 10, $obstacles);

        $result = $rover->execute($input);

        $this->assertEquals($expected, $result);
    }

    public function dataMoveWithColisionProvider(): array
    {
        return [
            ["RM", [[1,0]], "0:0:E"],
            ["RRM", [[0,1]], "0:0:S"],
            ["MLM", [[9,9]], "0:9:W"],
            ["LM", [[9,0]], "0:0:W"],
            ["M", [[0,9]], "0:0:N"],
            ["LLMMMMMRM", [[9,5]], "0:5:W"],
        ];
    }
}
