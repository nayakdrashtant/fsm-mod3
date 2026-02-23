````md
# FSM Modulo Three – Advanced Version

## Overview

This project implements a small, reusable finite state machine in PHP and uses it to solve the modulo three problem for binary strings.

Given a binary string, the program reads it from most significant bit to least significant bit and returns the remainder when the number is divided by 3. Instead of hard-coding the logic, the solution is built on top of a generic finite automaton so it can be reused for other problems.

The focus was to keep the implementation clean, extensible, and well tested.

---

## Structure

The solution is structured in two layers.

### Finite Automaton Module

A generic `FiniteAutomaton` class that:

- Accepts a set of states  
- Accepts an alphabet  
- Accepts a transition table  
- Processes input step by step  
- Returns the final state  

This module is independent of the modulo three problem and can be reused to model other deterministic finite state machines.

### Modulo Three Implementation

The `ModThree` class defines:

- States: S0, S1, S2  
- Alphabet: 0, 1  
- Initial state: S0  
- Transition rules as defined in the exercise  

After running the automaton, the final state is mapped to its corresponding remainder value.

---

## Requirements

- PHP 8.4  
- Composer  

---

## Setup

Install dependencies:

```bash
composer install
````

Run the test suite:

```bash
composer test
```

---

## Testing

The project uses PHPUnit and includes tests for both:

* The generic finite automaton
* The modulo three implementation

Test coverage includes:

* Standard valid inputs
* Known example cases
* Empty string handling
* Leading zeros
* Larger inputs
* Invalid character handling

You can also run PHPUnit directly:

```bash
vendor/bin/phpunit
```

---

## Example

```php
require 'vendor/autoload.php';

use App\ModThree\ModThree;

$mod = new ModThree();

echo $mod->remainder('110');   // 0
echo $mod->remainder('1010');  // 1
```

---

## Notes

The main goal was to keep responsibilities clearly separated and make the finite automaton reusable rather than tightly coupling it to a single problem. Automated tests were included to ensure correctness and make future changes safer.
