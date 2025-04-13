<?php

use parallel\Runtime;
use parallel\Future;

// Define a function to run in parallel
function longTask($name, $sleepTime) {
    sleep($sleepTime);
    return "Task $name finished after $sleepTime seconds\n";
}

// Create runtimes (workers)
$runtime1 = new Runtime();
$runtime2 = new Runtime();
$runtime3 = new Runtime();

// Run tasks in parallel
$future1 = $runtime1->run(function () {
    sleep(2);
    return "Task 1 done";
});

$future2 = $runtime2->run(function () {
    sleep(3);
    return "Task 2 done";
});

$future3 = $runtime3->run(function () {
    sleep(1);
    return "Task 3 done";
});

// Wait and get results
echo $future1->value() . PHP_EOL;
echo $future2->value() . PHP_EOL;
echo $future3->value() . PHP_EOL;

?>
