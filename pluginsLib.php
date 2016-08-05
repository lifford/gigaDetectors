<?php

/* Function will check if there is detector data file in correct place and if containd correct data. */
function getDetector($fileName, $detectorName) {

  $safeFileAge = '-6 min';

  $file = @fopen($fileName, 'r');
  if (!$file) {
    echo "Can not find file $fileName.";
    exit(3);
  }

  if (filemtime($fileName) < strtotime(date('Y-m-d H:i:s', strtotime($safeFileAge)))) {
    echo "Latest update is older than $safeFileAge.";
    exit(3);
  }

  $json = stream_get_contents($file);

  fclose($file);

  // Converting string from curl to json object
  $jsonObject = json_decode($json, true);

  if (!isset($jsonObject['analogInputs'])) {
    echo "Can not get valid json object.";
    exit(3);
  }

  if (!isset($jsonObject['analogInputs'][$detectorName])) {
    echo "Can not find detector $detectorName.";
    exit(3);
  }

  $detector = $jsonObject['analogInputs'][$detectorName];

  if (!isset($detector['limitLoLo']) ||
      !isset($detector['limitLo']) ||
      !isset($detector['currValue']) ||
      !isset($detector['limitHi']) ||
      !isset($detector['limitHiHi']) ) {
    echo "Can not find required data for detector $detectorName.";
    exit(3);
  }

  return $detector;

}
