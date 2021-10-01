<?php

namespace App;

use PHPUnit\Util\Exception;

class Rover
{
    const COMMANDS = "NESW";
    private $direction = 0;
    private $x = 0;
    private $y = 0;
    private $map;
    private $obstacles = [];

    public function getMap(): array
    {
        return $this->map;
    }

    public function __construct(int $rows, int $columns, $obstacles = [])
    {
        $this->map = array_fill(0, $rows, array_fill(0, $columns, null));
        $this->obstacles = $obstacles;
    }

    public function execute($commands)
    {
        for ($i = 0; $i < strlen($commands); $i++) {
            $this->move($commands[$i]);
        }

        return $this->x . ':' . $this->y . ':' . Rover::COMMANDS[$this->direction];
    }

    private function move($command)
    {
        if ($command === "L" || $command === "R") {
            $this->rotate($command);
        } else if ($command === "M") {
            $this->walk();
        } else {
            throw new Exception("Bad command!");
        }
    }

    private function rotate($command)
    {
        if ($command === "L") {
            $this->direction - 1 == -1 ? $this->direction = 3 : $this->direction -= 1;
        }
        if ($command === "R") {
            $this->direction + 1 === 4 ? $this->direction = 0 : $this->direction += 1;
        }
    }

    private function walk()
    {
        $dir = Rover::COMMANDS[$this->direction];
        if (!$this->checkColision($dir)) {
            if ($dir === "N") {
                $this->y - 1 === -1 ? $this->y = sizeof($this->map) - 1 : $this->y -= 1;
            }
            if ($dir === "S") {
                $this->y + 1 === sizeof($this->map) ? $this->y = 0 : $this->y += 1;
            }
            if ($dir === "W") {
                $this->x - 1 === -1 ? $this->x = sizeof($this->map[0]) - 1 : $this->x -= 1;
            }
            if ($dir === "E") {
                $this->x + 1 === sizeof($this->map[0]) ? $this->x = 0 : $this->x += 1;
            }
        }
    }

    private function checkColision($dir)
    {
        foreach ($this->obstacles as $obstacle) {
            $x = $this->x;
            $y = $this->y;

            if ($dir === "N") {
                $y = $this->y - 1 < 0 ? sizeof($this->map) - 1 : $this->y - 1;
            }
            if ($dir === "S") {
                $y = $this->y + 1 === sizeof($this->map) ? 0 : $this->y + 1;
            }
            if ($dir === "W") {
                $x = $this->x - 1 < 0 ? sizeof($this->map[0]) - 1 : $this->x - 1;
            }
            if ($dir === "E") {
                $x = $this->x + 1 === sizeof($this->map[0]) ? 0 : $this->x + 1;
            }

            if ($x === $obstacle[0] && $y === $obstacle[1]) {
                return true;
            }
        }

        return false;
    }
}
