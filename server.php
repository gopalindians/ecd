<?php
require_once './vendor/autoload.php';

use Symfony\Component\Process\Process;

define('SERVER', 'localhost');
define('PORT', '8001');
$initEnvModTime = filemtime('.env');
$process = new Process(['php', '-S', SERVER . ':' . PORT]);
$process->start();
echo 'SERVER RUNNING on '. SERVER . ':' . PORT;
while ($process->isRunning()) {
    clearstatcache(false, '.env');
    if (filemtime('.env') > $initEnvModTime) {
        $initEnvModTime = filemtime('.env');
        echo "\nENV file modified";
        echo "\nSERVER RUNNING on ". SERVER . ':' . PORT;
        $process->stop(5);
        $process = $process->restart();
    }
    usleep(500 * 1000);
    // waiting for process to finish
}
echo $process->getOutput();
