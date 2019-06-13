<?php

$scriptCLass = $_SERVER['argv'][1] ?? null;

if (empty($scriptClass)) {
    die('Arguments not contains element with php class.');
}

try {
    $runnerScript = new \ES\Kernel\Console\RunnerScript($scriptCLass);
    $runnerScript->run();
    $runnerScript->outputResponse();
} catch (\Throwable $e) {
    echo $e->getMessage() . \PHP_EOL . \PHP_EOL . $e->getTraceAsString();
}
