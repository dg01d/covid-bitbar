#!/usr/bin/php

<?php

/**
 * worldcup - BitBar WorldCup 2018 scores
 *
 * PHP version 7
 *
 * @author   Daniel Goldsmith <dgold@ascraeus.org>
 * @license  MIT
 * @link     https://github.com/dg01d/covid-bitbar
 * @category Utility
 * @version  1
 * <bitbar.title>Covid</bitbar.title>
 * <bitbar.version>v1.0</bitbar.version>
 * <bitbar.author>Daniel Goldsmith</bitbar.author>
 * <bitbar.author.github>dg01d</bitbar.author.github>
 * <bitbar.desc>Shows global and national covid confirmed and mortality totals. Needs Steve Edson's bitbar-php: https://github.com/SteveEdson/bitbar-php </bitbar.desc>
 * <bitbar.dependencies>php,bitbar-php</bitbar.dependencies>
 * <bitbar.abouturl>https://github.com/dg01d/covid-bitbar</bitbar.abouturl>
 * Instructions: Install bitbar-php following the instructions on that project's github page.
 * Set your local country using the reference implementation on https://covid2019-api.herokuapp.com.
 * Figures are not presented actively, but behind dropdown. I wish I didn't
 * have cause to write this.
 */

require ".bitbar/vendor/autoload.php";

use SteveEdson\BitBar;
$state =  "france";
$wht = "\033[37m";
$ylw = "\033[33m";

$bb = new BitBar();

$topLine = "☣️";
$line = $bb->newline();

$line
    ->setText($topLine)
    ->show();

$json = file_get_contents("https://covid2019-api.herokuapp.com/v2/total");
$data = json_decode($json, true);
if (!empty($data)) {
    $fig = $wht . number_format($data['data']['confirmed']);
    $mor = $ylw . number_format($data['data']['deaths']);
    $globLine = $fig . " : " . $mor;
} else {
    $globline = "No Data";
};

$line = $bb->newLine();
$line
    ->setText($globLine)
    ->setDropDown(true)
    ->show();

$stateJson = file_get_contents("https://covid2019-api.herokuapp.com/v2/country/" . $state);

$stateData = json_decode($stateJson, true);

if (!empty($stateData)) {
    $sfig = $wht . number_format($stateData['data']['confirmed']);
    $smor = $ylw . number_format($stateData['data']['deaths']);
    $mLine = $sfig . " : " . $smor;
} else {
    $mLine = "No Data";
};

$line = $bb->newLine();
$line
    ->setText($mLine)
    ->show();

