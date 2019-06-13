<?php

namespace ES\Kernel\Console;

class InputStream
{
    private $argv = [];
    private $argc;

    public function __construct()
    {
        $this->argv = $_SERVER['argv'];
        $this->argc = $_SERVER['argc'];
    }

    public function getArgvItem(string $argvItem): ?string
    {
        return $this->argv[$argvItem] ?? null;
    }

    public function getArgc(): int
    {
        return $this->argc;
    }
}