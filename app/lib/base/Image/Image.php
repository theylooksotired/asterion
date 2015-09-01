<?php
class Image {

	protected $url; 
	protected $mime;
	protected $width;
	protected $height;

	public function __construct($file) {
		if (is_file($file)) {
			$info = getimagesize($file);
			$this->url = $file;
			$this->width = $info[0];
			$this->height = $info[1];
			$this->mime = $info['mime'];
		}
	}

	public function get($item) {
		//Return an information of the image
		return (isset($this->$item)) ? $this->$item : false;
	}
	
	public function getUrl() {
		//Return the public url of the image
		return str_replace(LOCAL_FILE, LOCAL_URL, $this->get('url'));
	}

	public function getExtension() {
		//Return the image extension
		switch ($this->mime) {
			case 'image/jpg':
			case 'image/jpeg':
				return 'jpg';
			break;
			case 'image/gif':
				return 'gif';
			break;
			case 'image/png':
				return 'png';
			break;
		}
	}

	public static function getType($mime) {
		//Return the type of the image
		$type = explode('/',$mime);
		$type = $type[1];
		if ($type == 'jpg') { $type = 'jpeg'; }
		if ($type!='' && $type!='jpeg' && $type!='png' && $type!='gif') {
			throw new Exception('Cannot resize image. Mime:'.$mime);
		}
		return $type;
	}

	public function getFileName() {
		//Return the file name of the image
		$file = explode('.',basename($this->url));
		return $file[0];
	}

	public function toJpg() {
		//Convert an image into jpg
		if ($this->getExtension()!='jpg') {
			$extension = $this->getExtension();
			if ($extension != '') {
				$function = 'imagecreatefrom'.$extension;
				$image = $function($this->get('url')); 
				$fileDestinationArray = explode('.',$this->get('url'));
				$fileDestination = $fileDestinationArray[0].'.jpg';
				imagejpeg($image, $fileDestination, 100);		 
				imagedestroy($image);
				unlink($this->get('url'));
				$this->url = $fileDestination;
				$this->mime = 'image/jpeg';
			} else {
				return false;
			}
		}
		return true;
	}

	public function resize($fileDestination, $newWidth, $maxHeight, $mime) {
		//Resize an image
		$fileOrigin = $this->get('url');
		$type = $this->getType($mime);
		$function = 'imagecreatefrom'.$type;
		$image = $function($fileOrigin); 
		$widthImage = imagesx($image);
		$heightImage = imagesy($image);	 
		if ($widthImage < $newWidth) {
			if (!copy($fileOrigin, $fileDestination)) {
				throw new Exception('Cannot copy from '.$fileOrigin.' to '.$fileDestination);
			}
		} else {
			$newHeight = ceil( ( $newWidth*$heightImage ) / $widthImage );			 
			if ($newHeight > $maxHeight) {
				$newHeight = $maxHeight;
				$newWidth = ceil(($newHeight * $widthImage) / $heightImage);
			}
			$newImage	= imagecreatetruecolor($newWidth, $newHeight);
			imagecopyresampled ($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $widthImage, $heightImage);		 
			$function = 'image'.$type;
			$function($newImage, $fileDestination, 100);
			imagedestroy($newImage);
			imagedestroy($image);
		}
	}

	public function grayscale($fileDestination) {
		//Convert an image into grayscale
		$fileOrigin = $this->get('url');
		$type = $this->getType($mime);
		$function = "imagecreatefrom".$type;
		$image = $function($fileOrigin);
		$imageWidth = imagesx($image);
		$imageHeight = imagesy($image);
		for ($i=0; $i<$imageWidth; $i++) {
	        for ($j=0; $j<$imageHeight; $j++) {
                $rgb = imagecolorat($image, $i, $j);
                $rr = ($rgb >> 16) & 0xFF;
                $gg = ($rgb >> 8) & 0xFF;
                $bb = $rgb & 0xFF;
                $g = round(($rr + $gg + $bb) / 3);
                $val = imagecolorallocate($image, $g, $g, $g);
                imagesetpixel ($image, $i, $j, $val);
	        }
		}
		imagejpeg($image, $fileDestination, 100);
	}

	public function resizeSquare($fileDestination, $newSide, $mime) {
		//Resize an image an cut the borders to create a perfect square
		$fileOrigin = $this->get('url');
		$type = $this->getType($mime);
		$function = "imagecreatefrom".$type;
		$image = $function($fileOrigin); 
		$widthImage = imagesx($image);
		$heightImage = imagesy($image);
		if ($widthImage > $heightImage) {
			$relation = $heightImage / $widthImage;
			$newWidth = intval($newSide/$relation);
			$newHeight = $newSide;
			$left=intval(($newWidth-$newSide)/2);
			$top=0;
		} else {
			$relation = $widthImage / $heightImage;
			$newWidth = $newSide;
			$newHeight = intval($newSide/$relation);
			$left=0;
			$top=intval(($newHeight-$newSide)/2);
		}
		$newImage = imagecreatetruecolor($newWidth, $newHeight);
		imagecopyresized($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $widthImage, $heightImage);
		$squareImage = imagecreatetruecolor($newSide, $newSide);
		imagecopyresized($squareImage, $newImage, 0, 0, $left, $top, $newSide, $newSide, $newSide, $newSide);
		$function= "image".$type;
		$function($squareImage, $fileDestination, 100);
		imagedestroy($squareImage);
		imagedestroy($image);
	}

}
?>