#!/usr/bin/php

<?php

/**
 * worldcup - BitBar WorldCup 2018 scores
 *
 * PHP version 7
 *
 * @author   Daniel Goldsmith <dgold@ascraeus.org>
 * @license  https://opensource.org/licenses/FPL-1.0.0 0BSD
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
$state =  "ireland";
$wht = "\033[37m";
$ylw = "\033[33m";

$icon = 'iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAQAAAAm93DmAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAAmJLR0QAAKqNIzIAAAAJcEhZcwAAFiUAABYlAUlSJPAAAAAHdElNRQfkBAITJAIfDgDcAAAEMklEQVRIx+XWWWxVVRQG4O/eThQ6UMCClaIMVRQVNHGAipVqJEgYFDVQEsQ4xOirRh8gMRJixKiEGPHBKIkDCGhEYkzEaJCkIAQ0FiEFY4lYqGBvK22lgu32oael9/b2is+u/XLWWf/699lrr+FkySzlJsrX6W/kKTderj8yOWRlsI211CiHnHAedGkTVKryW2bS9DLbdovTbBi3yKfm/le6Gg0eHdS6zDEP/xe6eRI2yh3Unm2DPyy6WLpJfnRWdUbMbdodMfli6GLWCg4YkRFVbI9gvfi/E07RKNiS8f6JeU/Q5PpUw8Ad7laGDl0puGRkcAajzR4Y3lS9EgyTpQs5rjHdFKWCZgftdsg5xBSCSmujLB1EShwQBPuVoNL7Tgn91imb3C6myG5BUGdU5giWOSoI2lR73O8RTaeEhM5Ia/aUmVoFQYNxmY/cG9UCy+03HD/YplYTRptuoalK5FuuOLqckOn7JnhNR/QdHZ60xmplSYhLveBVj2uLUH9aZ9JgdAscTIrXCTVpsiDmQceTcIctEhtI97DmJFgQJKxyeRKq3PN9kb2wWjyaSrkwDV3Pqve65a41xUPWOTwIqsUDvQeASba5Bm2+971TspW60fXyo+3arfS31YoivVOdA5p0ucQ00xTiiPnqe0lfEZz3sWoFeNp2a0x2jy90C5otlivH/U4Lun1lvqu8ZLtnUaDaR84J1vUeu8IvOq0wDOTZITjtSpR4WbdtUV3HbRWsNRITNQm+NgQM9awOja7uycMqZV7wYlS9PbucF9BihSFyIku3k970nE6EqOB60H9aI26VWQ4Ts8GOvugQt0nQFtU0Rea4Q7ZsVeZG6czNWgVb+/WkAp/7QDxumDHWO9Nn6HYIBW6N9DNKfGizzba4pG843aIYP/brSe3WK1VIqXeMSUqhWdoFu42M9Cs0CILjfTVR4htBhzuT/Eq967K4uHqJJMM+tbjZY5F+0hHwk8bozSNmYI+9SX4Jh8QY7sEBBTZPmyBhWRTVjUK/iNX4XdDh3hSvuCVGkmN6mjb7kiBo9bwxsmwVBNtkG22lhCB4VU6KV5YZPZNyrDypUuwt3YJgn9vVCoK9Zvo2ertByQCfvN7emJumK1JklRbBz5Y4HbWKGkcFrVb3pU/yufJ6/m26dKcx/2WnvYp8ZoK7QL5f7dLuGW/rTOPR3X+wpelnUVxm+63fRJnzL+O1T4amiQlcZ39Sm/rO1LS44YamXnmFG6JS75VcC9QN6HwHLUz568kzTUVv6l04asxNbtOoTjNGmOo+cxRE1mOC8dFzu8995AcJwUjXKldrb+89JMdunKVmG2WI4X2Fx68+8YbgCff2G5rNWnVq9qX3NGS6jHFmmqFCiZg2Db61U72AmApVbjVeoeCMo2rtcizZfbDbzZMn5pyzaWz5cgXn0qbO/1H+AfynnmzS4uIIAAAAJXRFWHRkYXRlOmNyZWF0ZQAyMDIwLTA0LTAyVDE5OjM1OjQ5KzAwOjAwFtdDgQAAACV0RVh0ZGF0ZTptb2RpZnkAMjAyMC0wNC0wMlQxOTozNTo0OSswMDowMGeK+z0AAAAASUVORK5CYII=';

$bb = new BitBar();

$topLine = "covid";
$line = $bb->newline();

$line
    ->setText($topLine)
    ->setImage($icon,true)
    ->show();

$json = file_get_contents("https://covid19.mathdro.id/api");
$data = json_decode($json, true);
if (!empty($data)) {
    $fig = $wht . "Global: " . number_format($data['confirmed']['value']);
    $mor = $ylw . number_format($data['deaths']['value']);
    $globLine = $fig . " : " . $mor;
} else {
    $globline = "No Data";
};

$line = $bb->newLine();
$line
    ->setText($globLine)
    ->setDropDown(true)
    ->show();

$stateJson = file_get_contents("https://covid19.mathdro.id/api/countries/" . $state);

$stateData = json_decode($stateJson, true);

if (!empty($stateData)) {
    $sfig = $wht . $state . ": " . number_format($stateData['confirmed']['value']);
    $smor = $ylw . number_format($stateData['deaths']['value']);
    $mLine = $sfig . " : " . $smor;
} else {
    $mLine = "No Data";
};

$line = $bb->newLine();
$line
    ->setText($mLine)
    ->show();

