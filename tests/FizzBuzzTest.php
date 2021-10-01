<?php

namespace Tests\Unit;

use App\FizzBuzz;
use PHPUnit\Framework\TestCase;

class FizzBuzzTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function test($input, $expected)
    {
        $fb = new FizzBuzz();
        $result = $fb->execute($input);

        $this->assertEquals($result, $expected);
    }

    public function dataProvider(): array
    {
        return [
            [1, "1"],
            [2, "2"],
            [3, "Fizz"],
            [4, "4"],
            [5, "Buzz"],
            [6, "Fizz"],
            [10, "Buzz"],
            [15, "FizzBuzz"],
            [20, "Buzz"],
            [30, "FizzBuzz"],
        ];
    }
}
