<?php
/* This script require php5 and php5-curl installed in Your system. */

/* Function will check if service server is up and if returns valid json object. */
function getDetector($serverAddress, $detectorName) {

  /* Checking if server is up
     resource fsockopen ( string $hostname [, int $port [, int &$errno [, string &$errstr [, float $timeout ]]]] )
     Variables $errno and $errstr are not used */
  $fp = @fsockopen($serverAddress, 80, $errno, $errstr, 10);
  if (!$fp) {
    echo "Can not connect to server. Check if server is up and check its address.";
    exit(3);
  }

  $curl = curl_init($serverAddress . '/json.html');
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  $json = curl_exec($curl);

  // Converting string from curl to json object
  $jsonObject = json_decode($json, true);

  if (!isset($jsonObject['analogInputs'])) {
    echo "Can not get valid json object. It can be wrong address set or service is disabled.";
    exit(3);
  }

  if (!isset($jsonObject['analogInputs'][$detectorName])) {
    echo "Can not find detector $detectorName.";
    exit(3);
  }

  return $jsonObject['analogInputs'][$detectorName];

}
