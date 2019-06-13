<?php

namespace ES\Kernel\Console;

use ES\Kernel\Exception\ObjectException;

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
     * @param $consoleClass
     * @throws ObjectException
     */
    public function __construct($consoleClass)
    {
        if (!\class_exists($consoleClass)) {
            throw ObjectException::notFound(['Class "' . $consoleClass . '"" not exist']);
        }

        if (!$consoleClass instanceof AbstractConsoleScript) {
            throw new ObjectException('The class is not children of "' . AbstractConsoleScript::class . '"');
        }

        $this->inputStream  = new InputStream();
        $this->outputStream = new OutputStream();


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