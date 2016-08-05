#!usr/bin/php
<?php
/* This script require php5 and php5-curl installed in Your system.

0 <------> warningHum <-----------> criticalHum <------------ | Value
     OK         |        WARNING          |        CRITICAL   | State

*/

include 'pluginsLib.php';

$humFileName = "detectorsData.txt";

$humDetectorName=$argv[1];

/* function from external file
   will check if there is file and check if it contains valid object */
$detector = getDetector($humFileName, $humDetectorName);

/* Converting value to % */
$userFriendlyValue = $detector['currValue'] / 10;

$currentValue = $detector['currValue'];
$userFriendlyName = $detector['name'];

if ($currentValue < 0) {
  echo "Invalid value";
  exit(2);
} elseif ($currentValue < $detector['limitLoLo']) {
  echo "CRITICAL $userFriendlyName: $userFriendlyValue%";
  exit(2);
} elseif ($currentValue < $detector['limitLo']) {
  echo "WARNING $userFriendlyName: $userFriendlyValue%";
  exit(1);
} elseif ($currentValue < $detector['limitHi']) {
  echo "OK $userFriendlyName: $userFriendlyValue%";
  exit(0);
} elseif ($currentValue < $detector['limitHiHi']) {
  echo "WARNING $userFriendlyName: $userFriendlyValue%";
  exit(1);
} elseif ($currentValue >= $detector['limitHiHi']) {
  echo "CRITICAL $userFriendlyName: $userFriendlyValue%";
  exit(2);
}
