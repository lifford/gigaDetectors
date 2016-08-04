<?php

/* Function will check if there is detector data file in correct place and if containd correct data. */
function getDetector($fileName, $detectorName) {

  $file = @fopen($fileName, 'r');
  if (!$file) {
    echo "Can not find file $fileName.";
    exit(3);
  }

  $json = stream_get_contents($file);

  fclose($file);

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
