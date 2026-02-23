<?php

declare(strict_types=1);

namespace App\Automaton;

use App\Automaton\Exceptions\InvalidStateException;
use App\Automaton\Exceptions\InvalidSymbolException;

final class FiniteAutomaton
{
    /**
     * @param list<string> $states
     * @param list<string> $alphabet
     * @param list<string> $finalStates
     */
    public function __construct(
        private readonly array $states,
        private readonly array $alphabet,
        private readonly string $initialState,
        private readonly array $finalStates,
        private readonly TransitionTable $transitions
    ) {
        $this->assertStateExists($this->initialState);

        foreach ($this->finalStates as $final) {
            $this->assertStateExists($final);
        }
    }

    public function run(string $input): string
    {
        $current = $this->initialState;

        $len = strlen($input);
        for ($i = 0; $i < $len; $i++) {
            $symbol = $input[$i];

            if (!in_array($symbol, $this->alphabet, true)) {
                throw new InvalidSymbolException("Symbol not in alphabet: {$symbol}");
            }

            $current = $this->transitions->nextState($current, $symbol);
        }

        return $current;
    }

    public function isAccepting(string $state): bool
    {
        $this->assertStateExists($state);

        return in_array($state, $this->finalStates, true);
    }

    private function assertStateExists(string $state): void
    {
        if (!in_array($state, $this->states, true)) {
            throw new InvalidStateException("State not in Q: {$state}");
        }
    }
}