<?php

class Output 
{
  public static function Csv($results, $name = NULL)
  {
    $outstream = fopen("php://output", "w");

    // create filename
    if(!$name) $name = self::uniqueFilename() . '.csv';

    // headers for CSV
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename='. $name);
    header('Pragma: no-cache');
    header("Expires: 0");

    fputcsv($outstream, self::makeKeys($results));

    //create collum records
    foreach($results as $key => $result) {
    	fputcsv($outstream, $result);
    }
    fclose($outstream);
  }

  public static function uniqueFilename()
  {
  	return md5(uniqid() . microtime(TRUE) . mt_rand());
  }

  public static function makeKeys($results)
  {
  	//create collum names
    foreach ($results[0] as $key => $result) {
    	$keys[] = $key;
    }
    return $keys;
  }

  public static function Rss()
  {
  	header("Content-Type: application/xml; charset=ISO-8859-1");
  }

  public static function Json($result)
  {
    if ($result) return json_encode($result);
  }
}