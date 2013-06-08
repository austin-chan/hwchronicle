<?php

include('connect.php');



function imagecreatefromfile( $filename, $ext ) {
    if (!file_exists($filename)) {
        throw new InvalidArgumentException('File "'.$filename.'" not found.');
    }
    switch ( $ext ) {
        case 'jpeg':
        case 'jpg':
            return imagecreatefromjpeg($filename);
        break;

        case 'png':
            return imagecreatefrompng($filename);
        break;

        case 'gif':
            return imagecreatefromgif($filename);
        break;

        default:
            throw new InvalidArgumentException('File "'.$filename.'" is not valid jpg, png or gif image.');
        break;
    }
}




$valid_formats = array('jpg', 'png', 'gif', 'bmp', 'jpeg');
if(isset($_POST) && $_SERVER['REQUEST_METHOD'] == 'POST'){
	$name = $_FILES['photoimg']['name'];
	$size = $_FILES['photoimg']['size'];
}
if(strlen($name)){
	list($txt, $ext) = explode(".", $name);
	if(in_array($ext, $valid_formats)){
		$rand = "ok";
		do{
			$rand = substr(uniqid ('', true), -8);
			$result = mysql_query("SELECT messageid FROM justincarrimages WHERE image='$rand'");
		}while(mysql_num_rows($result) != 0);

		$actual_image_name = $rand.".".$ext;
		$actual_image_file = "upload/".$actual_image_name;
		$tmp = $_FILES['photoimg']['tmp_name'];
		
		//------------
		
		$originalimageobject = imagecreatefromfile( $tmp, $ext );
		list($originalWidth, $originalHeight) = getimagesize($tmp);
		
		
		$targetWidth  = 500;
		$targetHeight = 400;
		
		$source_aspect_ratio = $originalWidth / $originalHeight;
		$target_aspect_ratio = $targetWidth / $targetHeight;
		
		if($originalWidth < $targetWidth && $originalHeight < $targetHeight){
			$targetHeight = $originalHeight;
			$targetWidth = $originalWidth;
		}else{
			if ( $target_aspect_ratio < $source_aspect_ratio )
			{
			  // if target is wider compared to source then
			  // we retain ideal width and constrain height
			  $targetHeight = ( int ) ( $targetWidth / $source_aspect_ratio );
			}
			else
			{
			  // if target is taller (or has same aspect-ratio) compared to source then
			  // we retain ideal height and constrain width
			  $targetWidth = ( int ) ( $targetHeight * $source_aspect_ratio );
			}	
		}
		
		$srcWidth = $originalWidth;
		$srcHeight = $originalHeight;
		$srcX = $srcY = 0;

		$targetImage = imagecreatetruecolor($targetWidth, $targetHeight);
		imagecopyresampled($targetImage, $originalimageobject, 0, 0, $srcX, $srcY, $targetWidth, $targetHeight, $srcWidth, $srcHeight);
		
		imagejpeg($targetImage, $actual_image_file, 99);
		
		//------------		
	
/* 		if(move_uploaded_file($tmp, "upload/".$actual_image_name)){ */
			echo $rand.".".$ext;
/*
		}else{
			echo 'nope';
		}
*/
	}
}




?>