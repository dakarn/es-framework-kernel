<?php

$script = $_SERVER['argv'][1] ?? null;

if (empty($script)) {
    die('Arguments do not contains element with php class.');
}

$runnerScript = new \ES\Kernel\Console\RunnerScript($script);
$runnerScript->run();
$runnerScript->outputResponse();