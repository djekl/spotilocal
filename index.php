<?php

require_once __DIR__ . "/helpers.php";

// pause the track
// =====================================
var_dump(pause());
print PHP_EOL . PHP_EOL;


// sleep
sleep(3);


// resume the track
// =====================================
var_dump(resume());
print PHP_EOL . PHP_EOL;


// sleep
sleep(3);


// play the track
// =====================================
// our spotify track url
$track = "spotify:track:4Tyv7nnNTHC6mR1pTubIrw";
var_dump(play($track));
print PHP_EOL . PHP_EOL;
