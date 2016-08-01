#!usr/bin/php
<?php
/* This script require php5 and php5-curl installed in Your system.

0 <------> warningHum <-----------> criticalHum <------------ | Value
     OK         |        WARNING          |        CRITICAL   | State

*/

include 'pluginsLib.php';

$humServerAddress = "10.13.13.101";

$humDetectorName=$argv[1];
$warningHum=$argv[2];
$criticalHum=$argv[3];

/* function from external file
   will check if there is connection to server and check if if returns valid object */
$detector = getDetector($humServerAddress, $humDetectorName);

/* Converting value to C degree */
$currentValue = $detector['currValue'] / 10;
$userFriendlyName = $detector['name'];

if ($currentValue < 0) {
  echo "Invalid value";
  exit(2);
} elseif ($currentValue < $warningHum ) {
   echo "OK $userFriendlyName: $currentValue%";
  exit(0);
} elseif ( ($currentValue >= $warningHum) && ($currentValue < $criticalHum) ) {
  echo "WARNING $userFriendlyName: $currentValue%";
  exit(1);
} elseif ($currentValue > $criticalHum) {
  echo "CRITICAL $userFriendlyName: $currentValue%";
  exit(2);
}
