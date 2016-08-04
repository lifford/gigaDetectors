#!usr/bin/php
<?php
/* This script require php5 and php5-curl installed in Your system.

0 <------> warningTemp <-----------> criticalTemp <------------ | Value
     OK         |         WARNING          |         CRITICAL   | State

*/

include 'pluginsLib.php';

$tempFileName = "detectorsData.txt";

$tempDetectorName=$argv[1];
$warningTemp=$argv[2];
$criticalTemp=$argv[3];

/* function from external file
   will check if there is file and check if it contains valid object */
$detector = getDetector($tempFileName, $tempDetectorName);

/* Converting value to C degree */
$currentValue = $detector['currValue'] / 10;
$userFriendlyName = $detector['name'];

if ($currentValue < 0) {
  echo "Invalid value";
  exit(2);
} elseif ($currentValue < $warningTemp ) {
   echo "OK $userFriendlyName: $currentValue";
  exit(0);
} elseif ( ($currentValue >= $warningTemp) && ($currentValue < $criticalTemp) ) {
  echo "WARNING $userFriendlyName: $currentValue";
  exit(1);
} elseif ($currentValue > $criticalTemp) {
  echo "CRITICAL $userFriendlyName: $currentValue";
  exit(2);
}
