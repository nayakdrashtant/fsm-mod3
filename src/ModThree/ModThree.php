<?php

declare(strict_types=1);

namespace App\ModThree;

use App\Automaton\FiniteAutomaton;
use App\Automaton\TransitionTable;

final class ModThree
{
    public function remainder(string $binary): int
    {
        $fsm = $this->buildAutomaton();
        $finalState = $fsm->run($binary);

        return match ($finalState) {
            'S0' => 0,
            'S1' => 1,
            'S2' => 2,
            default => throw new \LogicException("Unexpected final state: {$finalState}"),
        };
    }

    private function buildAutomaton(): FiniteAutomaton
    {
        $states = ['S0', 'S1', 'S2'];
        $alphabet = ['0', '1'];
        $initial = 'S0';
        $finals = ['S0', 'S1', 'S2'];

        $transitions = new TransitionTable([
            'S0' => ['0' => 'S0', '1' => 'S1'],
            'S1' => ['0' => 'S2', '1' => 'S0'],
            'S2' => ['0' => 'S1', '1' => 'S2'],
        ]);

        return new FiniteAutomaton($states, $alphabet, $initial, $finals, $transitions);
    }
}