<?php
namespace Singleton;

trait Singleton
{
    protected static ?self $instance = null;

    final private function __construct(... $args)
    {
        $this->init(...$args);
    }

    private function __clone() { }
    public function __unserialize(array $a) { throw new \RuntimeException('Cannot unserialize() a Singleton'); }
    public function __serialize() { throw new \RuntimeException('Cannot serialize() a Singleton'); }

    public static function getInstance(...$args) : static
    {
        return static::$instance ?? static::$instance = new static(...$args);
    }

    public static function resetInstance() : void
    {
        static::$instance = null;
    }

    protected function init() { }
}