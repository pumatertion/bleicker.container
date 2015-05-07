<?php

namespace Tests\Bleicker\Container\Unit;

use Tests\Bleicker\Container\Unit\Fixtures\InheritContainer;
use Tests\Bleicker\Container\Unit\Fixtures\OtherContainer;
use Tests\Bleicker\Container\Unit\Fixtures\TestContainer;
use Tests\Bleicker\Container\UnitTestCase;

/**
 * Class ContainerTest
 *
 * @package Tests\Bleicker\Container\Unit
 */
class ContainerTest extends UnitTestCase {

	protected function setUp() {
		parent::setUp();
		TestContainer::prune();
		OtherContainer::prune();
		InheritContainer::prune();
	}

	/**
	 * @test
	 */
	public function hasTest() {
		$this->assertFalse(TestContainer::has('foo'));
		TestContainer::add('foo', 'bar');
		$this->assertTrue(TestContainer::has('foo'));
	}

	/**
	 * @test
	 */
	public function addTest() {
		TestContainer::add('foo', 'bar');
		$this->assertEquals('bar', TestContainer::get('foo'));
		$this->assertTrue(TestContainer::has('foo'));
	}

	/**
	 * @test
	 */
	public function removeTest() {
		TestContainer::add('foo', 'bar');
		TestContainer::remove('foo');
		$this->assertFalse(TestContainer::has('foo'));
	}

	/**
	 * @test
	 */
	public function getTest() {
		TestContainer::add('foo', 'bar');
		$this->assertEquals('bar', TestContainer::get('foo'));
	}

	public function multipleAddTest() {
		$testContainer = new TestContainer();
		TestContainer::add('foo', 'bar')->add('bar', 'baz')->add('la', 'ba')->remove('la')->add('lala', 'bubu');
		$this->assertTrue($testContainer->has('foo'));
		$this->assertTrue($testContainer->has('bar'));
		$this->assertTrue($testContainer->has('lala'));
		$this->assertFalse($testContainer->has('la'));
	}

	/**
	 * @test
	 */
	public function storageTest() {
		$storage = TestContainer::storage();
		$storage['abc'] = 'xyz';
		TestContainer::has('abc');
	}

	/**
	 * @test
	 */
	public function inheritanceTest() {
		TestContainer::add('foo', 'TestContainer');
		OtherContainer::add('foo', 'OtherContainer');
		InheritContainer::add('foo', 'InheritContainer');

		$this->assertEquals('TestContainer', TestContainer::get('foo'));
		$this->assertEquals('OtherContainer', OtherContainer::get('foo'));
		$this->assertEquals('InheritContainer', InheritContainer::get('foo'));
	}

	/**
	 * @test
	 * @expectedException \Bleicker\Container\Exception\AliasAlreadyExistsException
	 */
	public function noDefaultOverwriteOfAlias(){
		TestContainer::add('foo', 'bar');
		TestContainer::add('foo', 'baz');
	}
}
