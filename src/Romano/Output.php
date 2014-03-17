<?php

class Output 
{
  public static function csv($results, $filename = null)
  {
    $outstream = fopen("php://output", "w");

    // create filename
    if(!$filename) $filename = self::uniqueFilename() . '.csv';

    // headers for CSV
    header('Content-Type: text/csv');
    self::setheader($filename);

    // get the collum names
    fputcsv($outstream, self::makeKeys($results));

    //create collum records
    foreach($results as $key => $result) {
    	fputcsv($outstream, $result);
    }
    fclose($outstream);
    exit();
  }

  public static function xml($results, $name = 'xml', $filename = null)
  {
    if(!$filename) $filename = self::uniqueFilename() . '.xml';

    header('Content-Type: text/xml');
    self::setheader($filename);

    $xml = new XMLWriter();
    $xml->openMemory();
    $xml->startDocument('1.0', 'UTF-8');

    self::xml_parse($results, $name);
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

  public static function rss($results, $name = 'rss', $filename = null)
  {
    if(!$filename) $filename = self::uniqueFilename() . '.rss';

    // set headers
    header("Content-Type: application/xml; charset=ISO-8859-1");
    self::setheader($filename);

    $xml = new XMLWriter();
  
    date_default_timezone_set("Europe/Brussels");

    $xml->openMemory(); 
    $xml->startElement( 'rss' );
    $xml->writeAttribute( 'version', '2.0' );
    $xml->writeAttribute( 'xmlns:atom', 'http://www.w3.org/2005/Atom' );
    $xml->startElement( 'channel' );
    // $xml->writeElement( 'title', $title ); //required
    // $xml->writeElement( 'link', urlencode( $link ) ); //required
    // $xml->writeElement( 'description', $description ); //required
     $xml->writeElement( 'pubDate', date("Y-m-d H:i:s") );
    // $xml->writeElement( 'language', $language );
    // $xml->writeElement( 'copyright', $copyright );
    self::xml_parse($xml, $results, $name);
  }

  public static function json($result, $name = 'json', $filename = null)
  {
    if(!$filename) $filename = self::uniqueFilename() . '.json';

    if (is_array($result)) {
      header('Content-type: application/json');
      self::setheader($filename);
      echo json_encode($result);
    }
  }

  public static function txt($results, $name = 'txt', $filename = null)
  {
    if(!$filename) $filename = self::uniqueFilename() . '.txt';

    header('Content-Type: application/octet-stream');
    header('Content-Transfer-Encoding: binary');
    self::setheader($filename);

    // get the collum names
    $data .= 'fields = ' . implode (', ', self::makeKeys($results));
    $data .= "\n\n";

    foreach($results as $key => $result) {
      $data .= 'item '.$key . ':';
      $data .= "\n";
        foreach($result as $item_key => $item) {
          $data .= $item_key . '=' . $item;
          $data .= "\n";
        }
        $data .= "\n";
    }
    echo $data;
  }
  private static function setHeader($filename)
  {
    header('Content-Disposition: attachment; filename=' . $filename);
    header('Pragma: no-cache');
    header("Expires: 0");    
  }

  private static function xml_parse($xml, $results, $name)
  {
    $xml->startElement($name);    
    foreach($results as $result) {
        $xml->startElement($name . '_item');
        foreach($result as $item_key => $item) {
            $xml->startElement($item_key);
            //$xml->writeAttribute($item_key, $item);
            $xml->text($item);
            $xml->endElement();
        }
        $xml->endElement();
    }
    $xml->endElement();
    $xml->endDocument();
    echo $xml->outputMemory(true);
    $xml->flush();
    exit();    
  }

  public static function dump($results)
  {
    if (is_array($results)) echo dump($results);
  }
}