<?php

class File
{
    static function xml_parse($xml, $results, $name)
    {
        $xml->startElement($name);
        foreach($results as $result) {
            $xml->startElement($name . '-item');
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
        self::view( $filename, $xml->outputMemory(true));
        $xml->flush();
    }

    static function setHeader($headers, $filename)
    {
        if (!is_array($headers)) header($headers);
        else foreach ($headers as $value) header($value);
        header('Content-Disposition: attachment; filename=' . $filename);
        header('Pragma: no-cache');
        header("Expires: 0");
    }

    static function csv($results, $path, $filename = null)
    {
        if(!$filename) $filename = self::uniqueFilename() . '.csv';

        $outstream = fopen("php://output", "w");

        self::setheader('Content-Type: text/csv', $filename);

        fputcsv($outstream, array_keys($results[0]));

        foreach($results as $key => $result) fputcsv($outstream, $result);

        fclose($outstream);
    }

    static function xml($results, $path, $filename = null, $name = 'xml')
    {
        if(!$filename) $filename = self::uniqueFilename() . '.xml';

        self::setheader('Content-Type: text/xml', $filename);

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->startDocument('1.0', 'UTF-8');
        if (empty($results[0])) foreach ($results as $key => $result) self::xml_parse($xml, $result, $key);

        else self::xml_parse($xml, $results, $name);
    }

    static function rss($results, $path, $filename = null, $name = 'rss')
    {
        if(!$filename) $filename = self::uniqueFilename() . '.rss';

        self::setheader('Content-Type: application/xml; charset=ISO-8859-1', $filename);

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
        if (empty($results[0])) {
            foreach ($results as $key => $result) self::xml_parse($xml, $result, $key);
        }
        else self::xml_parse($xml, $results, $name);
    }

    static function json($results, $path, $filename = null, $name = 'json')
    {
        if(!$filename) $filename = self::uniqueFilename() . '.json';
        self::setheader('Content-type: application/json', $filename);
        self::view( $filename, json_encode($results));
    }

    static function txt($results, $path, $filename = null, $name = 'txt')
    {
        if(!$filename) $filename = self::uniqueFilename() . '.txt';

        self::setheader(array('Content-Type: application/octet-stream', 'Content-Transfer-Encoding: binary'), $filename);

        $data = 'fields = ' . implode (', ', array_keys($results[0])) . "\n\n";

        foreach($results as $key => $result) {
            $data .= 'item '. $key . ':' . "\n";
            foreach($result as $item_key => $item) {
                $data .= $item_key . '=' . $item . "\n";
            }
            $data .= "\n";
        }
        self::view( $filename, $data);
    }
}
