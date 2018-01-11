<?php
 
 
$folder = 'C:\xampp\htdocs\animales\imagenes';
$extList = array();
$extList['gif'] = 'image/gif';
$extList['jpg'] = 'image/jpeg';
$extList['jpeg'] = 'image/jpeg';
$extList['png'] = 'image/png';
 
$img = null;
 
if (substr($folder,-1) != '/') {
    $folder = $folder.'/';
}
 
if (isset($_GET['img'])) {
    $imageInfo = pathinfo($_GET['img']);
    if (
        isset( $extList[ strtolower( $imageInfo['extension'] ) ] ) &&
        file_exists( $folder.$imageInfo['basename'] )
    ) {
        $img = $folder.$imageInfo['basename'];
    }
} else {
    $fileList = array();
    $handle = opendir($folder);
    while ( false !== ( $file = readdir($handle) ) ) {
        $file_info = pathinfo($file);
        if (
            isset( $extList[ strtolower( $file_info['extension'] ) ] )
        ) {
            $fileList[] = $file;
        }
    }
    closedir($handle);
 
    $ntotal = count($fileList);
    if ($ntotal > 0) {
        $imageNumber = rand(0,$ntotal-1);
        $img = $folder.$fileList[$imageNumber];
    }
}
 
if ($img!=null) {
    $imageInfo = pathinfo($img);
    $contentType = 'Content-type: '.$extList[ $imageInfo['extension'] ];
    header ($contentType);
    readfile($img);

} else {
    if ( function_exists('imagecreate') ) {
        header ("Content-type: image/png");
        $im = @imagecreate (300, 100)
            or die ("HUBO UN ERROR AL PROCESAR LA IMAGEN .:. MYOKRAM");
        $background_color = imagecolorallocate ($im, 255, 255, 255);
        $text_color = imagecolorallocate ($im, 0,0,0);
        imagestring ($im, 2, 5, 5,  "HUBO UN ERROR AL PROCESAR LA IMAGEN .:. MYOKRAM", $text_color);
        imagepng ($im);
        imagedestroy($im);
    }
}

?>