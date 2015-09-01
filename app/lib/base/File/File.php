<?php
class File {

	static public function uploadUrl($url, $objectName, $uploadName) {
		//Upload a file using the field name
		if (url_exists($url)) {
			$mainFolder = STOCK_FILE.$objectName.'Files';
			File::createDirectory($mainFolder);
			$fileDestination = $mainFolder.'/'.$uploadName;
			if (copy($url, $fileDestination)) {
				@chmod($fileDestination, 0777);
				return true;
			}
		}
		return false;
	}	

	static public function upload($objectName, $name, $uploadName='') {
		//Upload a file using the field name
		if (isset($_FILES[$name]) && $_FILES[$name]['tmp_name']!='') {
			$mainFolder = STOCK_FILE.$objectName.'Files';
			File::createDirectory($mainFolder);
			$uploadName = ($uploadName!='') ? $uploadName : Text::simpleUrlFile($_FILES[$name]['name']);
			$fileOrigin = $_FILES[$name]['tmp_name'];
			$fileDestination = $mainFolder.'/'.$uploadName;
			return move_uploaded_file($fileOrigin, $fileDestination);
		}
		return false;
	}

	static public function saveFile($file, $content, $tiny=false) {
		//Save content to a file
		@touch($file);
		if (file_exists($file)) {
			if ($tiny==true) {
				$content = str_replace('\"','"',$content);
				$content = str_replace('&quot;','"',$content);
				$content = str_replace("\'","'",$content);
				$content = str_replace("\'","'",$content);
				$content = str_replace("&#39","SS",$content);
			}
			$fhandle = fopen($file,"w");
			fwrite($fhandle,$content);
			fclose($fhandle);
		}
	}
	
	static public function copyDirectory($source, $destination, $permissions=0755) {
		//Copy an entire directory and its files
	    if (is_link($source)) {
	        return symlink(readlink($source), $destination);
	    }
	    if (is_file($source)) {
	        return copy($source, $destination);
	    }
	    if (!is_dir($destination)) {
	        mkdir($destination, $permissions);
	    }
	    $dir = dir($source);
	    while (false !== $entry = $dir->read()) {
	        if ($entry == '.' || $entry == '..') {
	            continue;
	        }
	        File::copyDirectory("$source/$entry", "$destination/$entry");
	    }
	    $dir->close();
	    return true;
	}

	static public function chmodDirectory($path, $fileMode, $dirMode) {
		//Change the permissions of an entire directory an its files
	    if (is_dir($path) ) {
	        if (!chmod($path, $dirMode)) {
	            $dirMode_str=decoct($dirMode);
	            return;
	        }
	        $directoryHead = opendir($path);
	        while (($file = readdir($directoryHead)) !== false) {
	            if($file != '.' && $file != '..') {
	                $fullPath = $path.'/'.$file;
	                File::chmodDirectory($fullPath, $fileMode, $dirMode);
	            }
	        }
	        closedir($directoryHead);
	    } else {
	        if (is_link($path)) {
	            return;
	        }
	        if (!chmod($path, $fileMode)) {
	            $fileMode_str=decoct($fileMode);
	            return;
	        }
	    }
	} 

	static public function download($file, $options=array()) {
		//Change headers and force a file download
		$content = (isset($options['content'])) ? $options['content'] : '';
		$contentType = (isset($options['contentType'])) ? $options['contentType'] : '';
		header('Cache-Control: public');
		header('Content-Description: File Transfer');
		header('Content-Disposition: attachment; filename='.File::basename($file));
		header('Content-Type: '.$contentType);
		header('Content-Transfer-Encoding: binary');
		if ($content!='') {
			echo $content;
		} else {
			readfile($file);
		}
	}
	
	static public function basename($file) {
		//Get the basename of a file
		$info = pathinfo($file);
		return (isset($info['basename'])) ? $info['basename'] : '';
	}

	static public function filename($file) {
		//Get the basename of a file
		$info = pathinfo($file);
		return (isset($info['filename'])) ? $info['filename'] : '';
	}

	static public function createDirectory($dirname) {
		if (!is_dir($dirname)) {
			if (!mkdir($dirname)) {
				throw new Exception('Could not create folder '.$dirname);
			}
		}
		@chmod($dirname, 0777);
	}

	static public function deleteDirectory($dirname) {
		//Delete a directory and all files and subdirectories in it
		if (is_dir($dirname)) {
			$handle = opendir($dirname);	
			if (!$handle) {				
				return false;
			}
			while($file = readdir($handle)) {
				if ($file != "." && $file != "..") {
					if (!is_dir($dirname."/".$file)) {
						unlink($dirname."/".$file);
					} else {						
						File::deleteDirectory($dirname.'/'.$file);          
					}
				}
			}
		}
		closedir($handle);
		rmdir($dirname);
		return true;
	}

	static public function urlExtension($url) {
		if (url_exists($url)) {
			$urlComponents = parse_url($url);
			$urlPath = $urlComponents['path'];
			return pathinfo($urlPath, PATHINFO_EXTENSION);
		}
	}

}
?>