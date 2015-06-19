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
var_dump(play("spotify:track:4Tyv7nnNTHC6mR1pTubIrw"));
print PHP_EOL . PHP_EOL;


// sleep
sleep(30);


// play the playlist
// =====================================
// our spotify track url
var_dump(play("spotify:user:djekl:playlist:1AIZcUvQ6f8rnGx7vSGPHN"));
print PHP_EOL . PHP_EOL;
