<?php
	class Picupload {
		private $picToUpload;
	    private $timeStamp;
	    public $error;
		public $imageFileType;
		private $myTempImage;
		private $myNewImage;
		public $fileName;
	    private $fileSizeLimit;
	
		
		function __construct($picToUpload, $fileSizeLimit){
			  $this->error = null;//1 - pole pildifail, 2 - liiga suur, pole lubatud tüüp
			  $this->picToUpload = $picToUpload;
			  $this->fileSizeLimit = $fileSizeLimit;
			  $this->timeStamp = microtime(1) * 10000;
			  $this->checkImageForUpload();
		  }
		  
		function __destruct(){
			if(isset($this->myTempImage)){
				imagedestroy($this->myTempImage);
			  }
		  }
		  
		private function checkImageForUpload(){
			  //kas on pilt
			  $check = getimagesize($this->picToUpload["tmp_name"]);
			  if($check == false){
				  $this->error = 1;
			  }
			  //failitüüp
			  if($check["mime"] == "image/jpeg"){
				  $this->imageFileType = "jpg";
			  }
			  if($check["mime"] == "image/png"){
				  $this->imageFileType = "png";
			  }
			  if($check["mime"] == "image/gif"){
				  $this->imageFileType = "gif";
			  }
			  //kas sobiv suurus
			  if ($this->error == null and $this->picToUpload["size"] > $this->fileSizeLimit) {
				  $this->error = 2;
			  }
			  //kas lubatud tüüp
			  if($this->imageFileType != "jpg" and $this->imageFileType != "png" and $this->imageFileType != "gif" ) {
				  $this->error = 3;
			  }
			  
			  //kui kõik sobib, teeme vajaliku pildiobjekti
			  if($this->error == null){
				  $this->myTempImage = $this->createImageFromFile($this->picToUpload["tmp_name"], $this->imageFileType);
			  }
		  
	  }//checkImageForUpload lõpp
	  
		private function createImageFromFile($imageFile, $fileType){
			if($fileType == "jpg" or $fileType == "jpeg"){
				$image = imagecreatefromjpeg($imageFile);
			}
			if($fileType == "png"){
				$image = imagecreatefrompng($imageFile);
			}
			if($fileType == "gif"){
				$image = imagecreatefromgif($imageFile);
			}
			return $image;
		  }//createImageFromFile lõppeb
		  
		public function createFileName($prefix){
			  $this->fileName = $prefix .$this->timeStamp ."." .$this->imageFileType;
		  }
		
		public function resizeImage($maxPicW, $maxPicH){
			//teeme kindlaks pildi suuruse
			$imageW = imagesx($this->myTempImage);
			$imageH = imagesy($this->myTempImage);
			//kui pilt ületab maks väärtuse siis muudame suurust

			if($imageW > $maxPicW or $imageH > $maxPicH){
				if($maxPicW == $maxPicH){
					//kui nõutakse ruutu
					$imageNewW = $maxPicW;
					$imageNewH = $maxPicH;
				} else {
					if($imageW / $maxPicW > $imageH / $maxPicH){
						$picSizeRatio = $imageW / $maxPicW;
					} else {
						$picSizeRatio = $imageH / $maxPicH;
					}
					$imageNewW = round($imageW / $picSizeRatio, 0);
					$imageNewH = round($imageH / $picSizeRatio, 0);
				}
				$this->myNewImage = $this->setPicSize($this->myTempImage, $imageW, $imageH, $imageNewW, $imageNewH);
			} else {
				//kui pole piisavalt suur, et vähendada, teeme originaalsuuruses
				$this->myNewImage = $this->createImageFromFile($this->picToUpload["tmp_name"], $this->imageFileType);
			}
		  }//resizeImage lõppeb
		  
		private function setPicSize($myTempImage, $imageW, $imageH, $imageNewW, $imageNewH){
			$myNewImage = imagecreatetruecolor($imageNewW, $imageNewH);
			//kui on läbipaistvusega png pildid, siis on vaja säilitada läbipaistvusega
			imagesavealpha($myNewImage, true);
			$transColor = imagecolorallocatealpha($myNewImage, 0, 0, 0, 127);
			imagefill($myNewImage, 0, 0, $transColor);
			$cutX = 0;
			$cutY = 0;
			$cutW = $imageW;
			$cutH = $imageH;
			//kui ruudukujuline pilt, siis vaja kärpida ehk õigest kohast lõigata
			if($imageNewW == $imageNewH){
				//kui pilt on "landscape"
				if($imageW > $imageH){
					$cutX = round(($imageW - $imageH) / 2, 0);
					$cutY = 0;
					$cutW = $imageH;
				} else {
					$cutX = 0;
					$cutY = round(($imageH - $imageW) / 2, 0);
					$cutH = $imageW;
				}
			}
			//nüüd lisame tegeliku pildiinfo
			imagecopyresampled($myNewImage, $myTempImage, 0, 0, $cutX, $cutY, $imageNewW, $imageNewH, $cutW, $cutH);
			//imagecopyresampled($myNewImage, $myTempImage, 0, 0, 0, 0, $imageNewW, $imageNewH, $imageW, $imageH);
			return $myNewImage;
		  }//setPicSize lõppeb
  
		public function addWatermark($wmFile, $wmLocation, $fromEdge){
			  $wmFileType = strtolower(pathinfo($wmFile,PATHINFO_EXTENSION));
			  //$waterMark = imagecreatefrompng($wmFile);
			  $waterMark = $this->createImageFromFile($wmFile, $wmFileType);
			  $waterMarkW = imagesx($waterMark);
			  $waterMarkH = imagesy($waterMark);
			  if($wmLocation == 1 or $wmLocation == 4){
				  $waterMarkX = $fromEdge;
			  }
			  if($wmLocation == 2 or $wmLocation == 3){
				  $waterMarkX = imagesx($this->myNewImage) - $waterMarkW - $fromEdge;
			  }
			  if($wmLocation == 1 or $wmLocation == 2){
				  $waterMarkY = $fromEdge;
			  }
			  if($wmLocation == 3 or $wmLocation == 4){
				  $waterMarkY = imagesy($this->myNewImage) - $waterMarkH - $fromEdge;
			  }
			  if($wmLocation == 5){
				  $waterMarkX = round((imagesx($this->myNewImage) - $waterMarkW) / 2, 0);
				  $waterMarkY = round((imagesy($this->myNewImage) - $waterMarkH) / 2, 0);
			  }
			  imagecopy($this->myNewImage, $waterMark, $waterMarkX, $waterMarkY, 0, 0, $waterMarkW, $waterMarkH);
		  }//addWatermark lõppeb
		
  
	    public function savePicFile($targetFile){
		    $notice = null;
		    if($this->imageFileType == "jpg" or $this->imageFileType == "jpeg"){
			    if(imagejpeg($this->myNewImage, $targetFile, 90)){
				    $notice = "Vähendatud pilt edukalt salvestatud";
			    } else {
				    $notice = "Vähendatud pildi salvestamine ebaõnnestus!";
			  }
		  }

		    if($this->imageFileType == "png"){
			    if(imagepng($this->myNewImage, $targetFile, 6)){
				    $notice = "Vähendatud pilt edukalt salvestatud";
			    } else {
				    $notice = "Vähendatud pildi salvestamine ebaõnnestus!";
			  }

		  }
		    if($this->imageFileType == "gif"){
			    if(imagegif($this->myNewImage, $targetFile)){
				    $notice = "Vähendatud pilt edukalt salvestatud";
			    } else {
				    $notice = "Vähendatud pildi salvestamine ebaõnnestus!";
			  }
			  	
				imagedestroy($this->myNewImage);

		  }
		    return $notice;
	  }
	  
	  	public function saveOriginal($target){
		  $notice = null;
		  if (move_uploaded_file($this->picToUpload["tmp_name"], $target)) {
				$notice = "Originaalfaili salvestamine õnnestus!";
			} else {
				$notice = "Originaalfaili salvestamine ei õnnestunud!";
			}
			return $notice;
	  }
 
		
	}//class lõppeb