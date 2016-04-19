<?php
class Image_File{

  static public function saveImageUrl($url, $objectName, $uploadName) {
    //Save an image from a url
    return Image_File::saveFileImage($url, $uploadName, STOCK_FILE.$objectName, true);
  }

  static public function saveImage($objectName, $name, $fileName) {
    //Save an image from an input file
    if (isset($_FILES[$name]) && $_FILES[$name]['tmp_name']!='') {
      $fileImage = $_FILES[$name]['tmp_name'];
      return Image_File::saveFileImage($fileImage, $fileName, STOCK_FILE.$objectName);
    }
    return false;
  }
  
  static private function saveFileImage($fileImage, $fileName, $mainFolder, $copy=false) {
    //Save the image and create versions of itself
    $localFolder = Text::simpleUrlFileBase($fileName);
    $folder = $mainFolder.'/'.$localFolder;
    if (is_dir($folder)) {
      File::deleteDirectory($folder);
    }
    File::createDirectory($mainFolder);
    File::createDirectory($folder);
    $saveImage = true;
    if ($copy) {
      $fileDestination = $localFolder;
      $destination = $folder."/".$fileDestination.'.'.strtolower(substr($fileImage, -3));
      if (!@copy(str_replace(STOCK_URL, STOCK_FILE, $fileImage), $destination)) {
        $saveImage = false;
      }
    } else {
      $tmpImage = new Image($fileImage);
      $destination = $folder."/".$localFolder.'.'.$tmpImage->getExtension();
      if (!@move_uploaded_file($fileImage, $destination)) {
        $saveImage = false;
      }
    }
    if ($saveImage) {
      @chmod($destination, 0777);
      $image = new Image($destination);
      if ($image->toJpg()) {
        $fileHuge = $folder."/".$image->getFileName()."_huge.jpg";
        $image->resize($fileHuge, WIDTH_HUGE, HEIGHT_MAX_HUGE, $image->get('mime'));
        $fileWeb = $folder."/".$image->getFileName()."_web.jpg";
        $image->resize($fileWeb, WIDTH_WEB, HEIGHT_MAX_WEB, $image->get('mime'));
        $fileSmall = $folder."/".$image->getFileName()."_small.jpg";
        $image->resize($fileSmall, WIDTH_SMALL, HEIGHT_MAX_SMALL, $image->get('mime'));
        $fileThumb = $folder."/".$image->getFileName()."_thumb.jpg";
        $image->resize($fileThumb, WIDTH_THUMB, HEIGHT_MAX_THUMB, $image->get('mime'));
        $fileSquare = $folder."/".$image->getFileName()."_square.jpg";
        $image->resizeSquare($fileSquare, WIDTH_SQUARE, $image->get('mime'));
        @chmod($fileHuge, 0777);
        @chmod($fileWeb, 0777);
        @chmod($fileSmall, 0777);
        @chmod($fileThumb, 0777);
        @chmod($fileSquare, 0777);
        //unset($image);
        return true;
      }
    }
    return false;
  }

  public static function deleteImage($objectName, $name) {
    //Delete an entire image folder
    $directory = STOCK_FILE.$objectName.'/'.$name.'/';
    rrmdir($directory);
  }

}
?>