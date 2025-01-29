<?php
    $img = $_POST['base64image'];
    $folderPath = "upload/";
    $image_parts = explode(";base64,", $img);
    $image_type_aux = explode("image/", $image_parts[0]);
    $image_type = $image_type_aux[1];
    $image_base64 = base64_decode($image_parts[1]);
    $fileName = uniqid() . '.png';
    $file = $folderPath . $fileName;
    file_put_contents($file, $image_base64);
    print_r($fileName);
   

   /* $img = $_POST['base64image'];
    $img = str_replace('data:image/jpeg;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);
    $file = 'image.png';
    $success = file_put_contents($file, $data);*/
?>