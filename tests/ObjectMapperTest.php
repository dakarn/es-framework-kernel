<?php

use PHPUnit\Framework\TestCase;

class ObjectMapperTest extends TestCase
{
    public function testObjectToArray()
    {
        $class = new class {

            private $name = 'Test';

            public function getName(): string
            {
                return $this->name;
            }

            public function setName(string $name): void
            {
                $this->name = $name;
            }
        };

        $this->assertArrayHasKey('name', ObjectMapper\ObjectMapper::create()->objectToArray($class));
    }
}