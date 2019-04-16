<?php

use PHPUnit\Framework\TestCase;

class ObjectMapperTest extends TestCase
{
    public function testObjectToArray()
    {
        $class = new class() implements ObjectMapper\ClassToMappingInterface {

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

    public function testArrayToObject()
    {
        $class = new class() implements ObjectMapper\ClassToMappingInterface {

            private $name;

            public function getName(): string
            {
                return $this->name;
            }

            public function setName(string $name): void
            {
                $this->name = $name;
            }
        };

        $array = ['name' => 'Test'];

        $this->assertNotEmpty(ObjectMapper\ObjectMapper::create()->arrayToObject($array, $class)->getName());
    }
}