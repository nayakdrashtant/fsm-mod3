<?php

declare(strict_types=1);

namespace App\Automaton;

use App\Automaton\Exceptions\InvalidStateException;
use App\Automaton\Exceptions\InvalidSymbolException;

final class TransitionTable
{
    /**
     * @var array<string, array<string, string>>
     */
    private array $table;

    /**
     * @param array<string, array<string, string>> $table
     */
    public function __construct(array $table)
    {
        $this->table = $table;
    }

    public function nextState(string $state, string $symbol): string
    {
        if (!array_key_exists($state, $this->table)) {
            throw new InvalidStateException("Unknown state: {$state}");
        }

        if (!array_key_exists($symbol, $this->table[$state])) {
            throw new InvalidSymbolException("No transition for symbol {$symbol} from state {$state}");
        }

        return $this->table[$state][$symbol];
    }
}