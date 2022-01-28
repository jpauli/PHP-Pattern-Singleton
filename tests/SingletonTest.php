<?php
require __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Singleton\Singleton;
use Singleton\SingletonInheritence;

class MySingletonTest extends TestCase
{
    public function testSameInstance()
    {
        $this->assertSame(MySingleton::getInstance('baz'), MySingleton::getInstance());
    }

    public function testChildSingleton()
    {
        $this->assertSame(MyChildSingleton::getInstance('baz', 'foo'), MyChildSingleton::getInstance());
    }

    public function testCannotConstructByHand()
    {
        $this->expectError();
        new MySingleton;
    }

    public function testConstructorArg()
    {
        $object = MySingleton::getInstance('fuz');
        $this->assertSame('fuz', $object->bar);

        $object = MyChildSingleton::getInstance('foobar', 'barfoo');
        $this->assertSame('foobar', $object->bar);
        $this->assertSame('barfoo', $object->foo);
    }

    public function tearDown(): void
    {
        MySingleton::resetInstance();
        MyChildSingleton::resetInstance();
    }
}

class MySingleton
{
    public readonly string $bar;
    use Singleton;

    protected function init(string $value)
    {
        $this->bar = $value;
    }
}

class MyChildSingleton extends MySingleton
{
    protected static ?self $instance = null;
    public readonly ?string $foo;

    protected function init(string $parent, ?string $child = null)
    {
        parent::init($parent);
        $this->foo = $child;
    }
}