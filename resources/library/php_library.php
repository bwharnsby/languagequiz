<?php
class PHP_Library {

    /*
    * br() is a function used to create line breaks in HTML.
    */
    static public function br() { return "<br>"; }

    /*
    * hr() is a function used to create horziontal line breaks in HTML.
    */
    static public function hr() { return "<hr>"; }

    /*
    * dump() is a function used print out variables. used in debugging/testing.
    */
    static public function dump($v) { echo var_dump($v); }
    
    /**
     * 
     * @param type $imgLink
     * @param type $style
     * @param type $alt
     * @return type
     */
    static public function generateImage($imgLink, $style = "", $alt = "") {
        return "<img src='$imgLink' alt='$alt' style='$style' /> ";
    }
    
    /**
     * 
     * @param type $href
     * @param type $text
     * @param type $target
     * @return type
     */
    static public function generateLink($href, $text, $class = "btn", $target = "") {
        return "<a class='$class' href='$href' target='$target'>$text</a>";
    }
    
    /**
     * 
     * @param type $format
     * @param type $time
     * @return type
     */
    static public function convertToReadableDate($format, $time) {
        $dateObj = new DateTime();
        $dateObj->setTimestamp($time); 
        return $dateObj->format($format);
    }
    
    /**
     * 
     * @param type $time
     * @return type
     */
    static public function convertToHumanReadableDate($time) {
        return PHP_Library::convertToReadableDate('F j, Y, g:i a', $time);
    }

    /*
    * readFromFile() is a function used to read the contents of a CSV file.
    */
    static public function readFromFile($filename) {
        $contents = [];
        $file = fopen($filename, "r") or die("file not found.");
        while(!feof($file)) {
            if(substr($filename, -3) == "csv") {
                $csvBlock = fgetcsv($file);
                if($csvBlock != null) {
                    $contents[] = $csvBlock;
                }
            }
            else if(substr($filename, -3) == "txt") {
                $contents[] = trim(fgets($file));
            }
            else if(substr($filename, -4) == "html") {
                $contents[] = trim(fgets($file));
            }
        }
        fclose($file);
        return $contents;
    }

    /*
    * writeToFile() is a function used to write contents to a file.
    * $contents must be a 2D array.
    */
    static public function writeToFile($filename, $contents, $mode = "w") {
        $file = fopen($filename, $mode) or die("file not found.");
        if(PHP_Library::isAssoc($contents)) {
            //associative arrays...
            foreach($contents as $k => $v) {
                //for now, just make a new array and put the key in first, followed by all values.
                if(substr($filename, -3) == "csv") {
                    if($k != "") {
                        $newArr = [$k];
                        foreach($v as $d) {
                            if($d != "") {
                                $newArr[] = $d;
                            }
                        }
                        fputcsv($file, $newArr);
                    }
                }
            }
        }
        else {
            //non associative arrays...
            foreach($contents as $c) {
                if(substr($filename, -3) == "csv") {
                    fputcsv($file, $c);
                }
                else if(substr($filename, -3) == "txt") {
                    fwrite($file, $c);
                }
                else if(substr($filename, -4) == "html") {
                    fwrite($file, $c);
                }
            }
        }
        fclose($file);
    }
    
    /**
     * Build a table using headers and data and give it an id.
     * @param type $id
     * @param type $headers
     * @param type $data
     * @return string
     */
    static public function makeTable($id, $headers, $data, $options = []) {
        $str = "";
        if(sizeof($data) == 0) {
            $str .= "No data found.";
        }
        else {
            $str .= "<table id='$id' class='table'><thead><tr>";
            foreach($headers as $h) {
                $str .= "<th>$h</th>";
            }
            $str .= "</tr></thead><tbody>";
            foreach($data as $r) {
                if(sizeof($options) > 0) {
                    //contains options..
                    if($options[0] === "Colour rows" && stristr($r[1] ,date("F j, Y"))) {
                        $str .= "<tr class='success'>";
                    }
                }
                else {
                    $str .= "<tr>";
                }
                foreach($r as $d) {
                    $str .= "<td>$d</td>";
                }
                $str .= "</tr>";
            }
            $str .= "</tbody></table>";
        }
        return $str;
    }

    /**
    * Given a URL, scrape all html.
    */
    static public function getHTML($url) {
        $url = trim($url);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); 
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);
        curl_setopt($curl, CURLOPT_REFERER, 'https://www.google.co.uk'); 
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; '
                        . 'Win64; x64; rv:25.0) Gecko/20100101 Firefox/25.0');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($curl);
        if(curl_error($curl)) {
            echo 'error: '.curl_error($curl)." for ".$url.PHP_Library::br();
        }
        curl_close($curl);

        return $result;
    }
};
?>