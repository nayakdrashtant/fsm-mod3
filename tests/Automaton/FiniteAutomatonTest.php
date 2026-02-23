<?php

declare(strict_types=1);

namespace App\Tests\Automaton;

use App\Automaton\Exceptions\InvalidStateException;
use App\Automaton\Exceptions\InvalidSymbolException;
use App\Automaton\FiniteAutomaton;
use App\Automaton\TransitionTable;
use PHPUnit\Framework\TestCase;

final class FiniteAutomatonTest extends TestCase
{
    public function testRunReturnsFinalState(): void
    {
        $fa = new FiniteAutomaton(
            states: ['A', 'B'],
            alphabet: ['0', '1'],
            initialState: 'A',
            finalStates: ['A', 'B'],
            transitions: new TransitionTable([
                'A' => ['0' => 'A', '1' => 'B'],
                'B' => ['0' => 'B', '1' => 'A'],
            ])
        );

        self::assertSame('A', $fa->run(''));
        self::assertSame('B', $fa->run('1'));
        self::assertSame('A', $fa->run('11'));
    }

    public function testInvalidSymbolThrows(): void
    {
        $fa = new FiniteAutomaton(
            states: ['A'],
            alphabet: ['0'],
            initialState: 'A',
            finalStates: ['A'],
            transitions: new TransitionTable([
                'A' => ['0' => 'A'],
            ])
        );

        $this->expectException(InvalidSymbolException::class);
        $fa->run('1');
    }

    public function testInvalidStateInDefinitionThrows(): void
    {
        $this->expectException(InvalidStateException::class);

        new FiniteAutomaton(
            states: ['A'],
            alphabet: ['0'],
            initialState: 'B',
            finalStates: ['A'],
            transitions: new TransitionTable([
                'A' => ['0' => 'A'],
            ])
        );
    }
}