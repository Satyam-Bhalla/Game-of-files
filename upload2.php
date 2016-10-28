<?php
if(isset($_POST["submit"])){
    if($_FILES['fileToUpload']["tmp_name"] != ''){
    $file_name = $_FILES['fileToUpload']["name"];
    $array = explode(".",$file_name);
    $name= $array[0];
    $ext = $array[1];
    }
        if($ext == 'zip'){
        $path = 'C:/wamp/www/Web Jam/';
        $location = $path.$file_name;
        if(move_uploaded_file($_FILES['fileToUpload']["tmp_name"], $location)){
            $zip = new ZipArchive;
            if($zip->open($location)){
                $zip->extractTo($path);
                $zip->close();
                   error_reporting(0);
                $files = scandir($path. $name);
                 if ($zip->open($file_name) === true) {
                   for($i = 0; $i < $zip->numFiles; $i++) { 
                         $entry = $zip->getNameIndex($i);
                              if(preg_match('#\.(txt)$#i', $entry))
                              {
                                  $file = fopen($entry, "r");
                                   $text = fgets($file);
                              // $arr1 = str_split($text);
                                  $arr1 = str_split($text);
                                 foreach ($arr1 as $key => $value) {
                                  if(ctype_digit($value)){
                                     $sum +=  $value;
                                     }else {
                            "The string must consist of all numbers";
                        }
                    }
                    $arr2 = array($text , $sum );
                    echo $sum;
                    echo '<br>';
                    $file_new = fopen($entry.".csv", "w");
                     foreach($arr2 as $number){
                          fputcsv($file_new, explode(',', $number));
                       }
                       fclose($file_new);
                       fclose($file);
                    } 
            }
        }


        }
    }
}else {
    echo "Enter only zip file";
    echo "<br>This page will automatically redirect";
         header("refresh:3; url = index1.php");
         exit;
}

} else {
    echo 'wrong input';
    echo "<br>This page will automatically redirect";
         header("refresh:3; url = index1.php");
         exit;
}

?>
