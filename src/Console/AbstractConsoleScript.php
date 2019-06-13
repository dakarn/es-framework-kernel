<?php

namespace ES\Kernel\Console;

abstract class AbstractConsoleScript
{
    abstract public function execute(InputStream $inputStream, OutputStream $outputStream): OutputStream;
}