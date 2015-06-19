<?php

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    return $randomString;
}

// get oAuth token
// =====================================
function getToken() {
    $token = file_get_contents("http://open.spotify.com/token");
    $token = json_decode($token);

    return $token->t;
}

// get CSRF token
// =====================================
function getCsrf() {
    $base_url = generateRandomString() . ".spotilocal.com:4380";

    $ch  = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => "{$base_url}/simplecsrf/token.json",
        CURLOPT_HTTPHEADER => [
            "Origin: https://open.spotify.com",
        ],
        CURLOPT_RETURNTRANSFER => true,
    ]);

    $result = curl_exec($ch);
    $result = json_decode($result);
    curl_close($ch);

    if (!empty($result->error->message)) {
        die(PHP_EOL . "=========================" . PHP_EOL . $result->error->message . PHP_EOL . "=========================" . PHP_EOL . PHP_EOL);
    }

    return $result->token;
}

// play this track
// =====================================
function play($track) {
    $base_url = generateRandomString() . ".spotilocal.com:4380";

    $ch  = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => "{$base_url}/remote/play.json?" . http_build_query([
            "csrf"    => getCsrf($base_url),
            "oauth"   => getToken(),
            "uri"     => $track,
            "context" => $track,
            "ref"     => "https://developer.spotify.com/technologies/widgetds/spotify-play-button",
            "cors"    => "",
        ]),
        CURLOPT_HTTPHEADER => [
            "Origin: https://open.spotify.com",
        ],
        CURLOPT_RETURNTRANSFER => true,
    ]);

    $result   = curl_exec($ch);
    $result   = json_decode($result);
    curl_close($ch);

    return $result;
}

// pause the track
// =====================================
function pause() {
    $base_url = generateRandomString() . ".spotilocal.com:4380";

    $ch  = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => "{$base_url}/remote/pause.json?" . http_build_query([
            "pause" => "true",
            "csrf"  => getCsrf($base_url),
            "oauth" => getToken(),
            "ref"   => "https://developer.spotify.com/technologies/widgetds/spotify-play-button",
            "cors"  => "",
        ]),
        CURLOPT_HTTPHEADER => [
            "Origin: https://open.spotify.com",
        ],
        CURLOPT_RETURNTRANSFER => true,
    ]);

    $result   = curl_exec($ch);
    $result   = json_decode($result);
    curl_close($ch);

    return $result;
}

// resume the track
// =====================================
function resume() {
    $base_url = generateRandomString() . ".spotilocal.com:4380";

    $ch  = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => "{$base_url}/remote/pause.json?" . http_build_query([
            "pause" => "false",
            "csrf"  => getCsrf($base_url),
            "oauth" => getToken(),
            "ref"   => "https://developer.spotify.com/technologies/widgetds/spotify-play-button",
            "cors"  => "",
        ]),
        CURLOPT_HTTPHEADER => [
            "Origin: https://open.spotify.com",
        ],
        CURLOPT_RETURNTRANSFER => true,
    ]);

    $result   = curl_exec($ch);
    $result   = json_decode($result);
    curl_close($ch);

    return $result;
}

// get version
// =====================================
function getVersion() {
    $base_url = generateRandomString() . ".spotilocal.com:4380";

    $ch  = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => "{$base_url}/service/version.json?service=remote",
        CURLOPT_HTTPHEADER => [
            "Origin: https://open.spotify.com",
        ],
        CURLOPT_RETURNTRANSFER => true,
    ]);

    $result   = curl_exec($ch);
    $result   = json_decode($result);
    curl_close($ch);

    return $result;
}

// get the current status
// =====================================
function getStatus($returnafter = 30) {
    $base_url = generateRandomString() . ".spotilocal.com:4380";

    $ch  = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => "{$base_url}/remote/status.json?" . http_build_query([
            "csrf" => getCsrf($base_url),
            "oauth" => getToken(),
            "returnon" => implode(",", [
                "login",
                "logout",
                "play",
                "pause",
                "error",
                "ap",
            ]),
            "returnafter" => $returnafter,
            "ref" => "https://developer.spotify.com/technologies/widgetds/spotify-play-button",
            "cors" => "",
        ]),
        CURLOPT_HTTPHEADER => [
            "Origin: https://open.spotify.com",
        ],
        CURLOPT_RETURNTRANSFER => true,
    ]);

    $result   = curl_exec($ch);
    $result   = json_decode($result);
    curl_close($ch);

    return $result;
}
