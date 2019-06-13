<?php

namespace ES\Kernel\Console;

class RunnerScript
{
    /**
     * @var AbstractConsoleScript
     */
    private $consoleScript;

    /**
     * @var InputStream
     */
    private $inputStream;
    /**
     * @var OutputStream
     */
    private $outputStream;

    /**
     * RunnerScript constructor.
     * @param $consoleFile
     */
    public function __construct($consoleFile)
    {
        $this->inputStream  = new InputStream();
        $this->outputStream = new OutputStream();

        $consoleClass        = \basename($consoleFile);
        $this->consoleScript = new $consoleClass();
    }

    /**
     *
     */
    public function run()
    {
        $this->consoleScript->execute($this->inputStream, $this->outputStream);
    }

    /**
     *
     */
    public function outputResponse()
    {
        $this->outputStream->output();
    }
}