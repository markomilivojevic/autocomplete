<?php

namespace Ducha\Autocomplete\Tests;

/**
 * Class AutocompleteTest
 * @package Ducha\Autocomplete\Tests
 */
class AutocompleteTest extends TestCase
{
    public function testAddAndGetAll()
    {
        $this->autocomplete->addTerms('countries', static::$countries);
        $this->assertCount(count(static::$countries), $this->autocomplete->all('countries'));
    }

    public function testCompleteLowercase()
    {
        $this->autocomplete->addTerms('countries', static::$countries);

        $matches = $this->autocomplete->complete('countries', 'sw');

        $expected = ["Swaziland", "Sweden", "Switzerland"];

        $this->assertEquals($expected, $matches);
    }

    public function testCompleteOriginal()
    {
        $this->autocomplete->addTerms('countries', static::$countries);

        $matches = $this->autocomplete->complete('countries', 'An');

        $expected = ['Andorra', 'Angola', 'Anguilla', 'Antarctica', 'Antigua and Barbuda'];

        $this->assertEquals($expected, $matches);
    }

    public function testCompleteFullMatch()
    {
        $this->autocomplete->addTerms('countries', static::$countries);

        $matches = $this->autocomplete->complete('countries', 'Serbia and Montenegro');

        $expected = ['Serbia and Montenegro'];

        $this->assertEquals($expected, $matches);
    }

    public function testAddTerm()
    {
        $this->autocomplete->addTerm('cities', 'Berlin');

        $matches = $this->autocomplete->complete('cities', 'Berlin');

        $this->assertEquals(['Berlin'], $matches);
    }

    public function testRemoveTerm()
    {
        $this->autocomplete->addTerms('countries', static::$countries);

        $this->autocomplete->removeTerm('countries', 'Antigua and Barbuda');

        $matches = $this->autocomplete->complete('countries', 'Antigua and Barbuda');

        $this->assertEquals([], $matches);
    }

    public function testAddWithColon()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->autocomplete->addTerm('cities', 'Berlin:Amsterdam');
    }
}