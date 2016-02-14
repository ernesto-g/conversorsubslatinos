<?php
/*
	Conversor de Subtitulos latino
    Copyright (C) <2014>  Ernesto Gigliotti <ernestogigliotti@gmail.com>

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/	
session_start();
Class Captcha{
//Send a generated image to the browser


function create_image($string_captcha,$width=130,$height=35)
{
    //Let's generate a totally random string using md5
//    $md5_hash = md5(rand(0,999));
    //We don't need a 32 character long string so we trim it down to 5
//    $security_code = substr($md5_hash, 15, 5);
    $security_code = $string_captcha;


/* ********************************************
   Use this part if you need to Set the session 
   to store the security code                */
    $_SESSION['security_code'] = $security_code;


$CodeInd=0;
$arrSecCode=array();
$chars = preg_split('//', $security_code); 

$security_code=implode(" ",$chars);
    //Set the image width and height
    //$width = 130;
    //$height = 35;

    //Create the image resource
    $image = ImageCreate($width, $height); 

    //We are making three colors, white, black and gray
    $arrB=array(0,255,129,10,48,200,186);
    $arrR=array(0,255,129,111,48,210,126);
    $arrG=array(0,205,139,110,48,5,186);
    $black = ImageColorAllocate($image, $arrR[rand(0,6)], $arrG[rand(0,6)], $arrB[rand(0,6)]);
    $white = ImageColorAllocate($image, 255, 255, 255);
    $grey = ImageColorAllocate($image, 175, 253, 253);

    //Make the background black
    ImageFill($image, 0, 0, $black);

     $font=5;

$arrSel=array(1,2,3,4);
$selectedNum=$arrSel[rand(0,3)];


    ImageString($image, $font, 10, 10, $security_code, $white);

    //Throw in some lines to make it a little bit harder for any bots to break

    ImageRectangle($image,0,0,$width-1,$height-1,$grey);

if($selectedNum == 1 ){
imageline($image, 0, $height/2, $width, $height/5, $grey);
imageline($image, $width/2, 0, $width/3, $height/5, $grey);
imageline($image, $width/2, 0, $width/10, $height, $grey);
imageline($image, $width/2, 0, $width/10, $height/6, $grey);
}

if($selectedNum == 2 ){
imageline($image, $width/1, 0, $width/6, $height, $grey);
imageline($image, 0, $height/5, $width, $height/8, $grey);
imageline($image, 0, $height/5, $width/5, $height/8, $grey);
imageline($image, 0, $height/3, $width, $height, $grey);
}

if($selectedNum == 3 ){
imageline($image, 0, $height, $width, 0, $grey);
imageline($image, 0, 0, $height, $height, $grey);
imageline($image, $width/5, 0, $width/6, $height, $grey);
imageline($image, $width/4, 0, $width/4, $height, $grey);
}

   
    //Tell the browser what kind of file is come in
    header("Content-Type: image/jpeg");

    //Output the newly created image in jpeg format
    ImageJpeg($image);
  
    //Free up resources
    ImageDestroy($image);
}



			function generateAlphaNumericString($nLength=6){
			$strAlphaNumeric="6j4e3s2u5s1";
			if( $nLength > 0){
			$arrStr= array();
			$nChk=rand(1,3);
            $capitalLetterArray=array("A","B","C","D","E","G","H","K","M","N","P","Q","R","S","T","X","Y","Z");
            $smallLetterArray=array("a","b","c","d","e","g","h","k","m","n","p","q","r","s","t","x","y","z");
           //			$arrStr[0]=($nChk==2)?chr(rand(97,122)):($nChk==1)?chr(rand(65,90)):rand(1,9);
           $arrStr[0]=($nChk==2)?$smallLetterArray[rand(0,17)]:($nChk==1)?$capitalLetterArray[rand(0,17)]:rand(1,9);
				for($i=1;$i<$nLength; $i++){
					$nInd=$i+1;
					if( $nInd%2 == 0){
					$arrStr[$i]=rand(1,9);
					}else{
						$chk=rand(1,2);
						if($chk==1){
							//$arrStr[$i]=chr(rand(65,90)); //to get all Capital alphabets
                             $arrStr[$i]=$capitalLetterArray[rand(0,17)];
						}else{
							//$arrStr[$i]=chr(rand(97,122)); //to get all Small alphabets
                             $arrStr[$i]=$smallLetterArray[rand(0,17)];
						}     
					}
				}
			$strAlphaNumeric=implode("",$arrStr);
			}
			return $strAlphaNumeric;
			}


function CaptchaSecurityImages($width,$height,$string_captcha) {
      $security_code=$string_captcha;
    $_SESSION['security_code'] = $security_code;
$CodeInd=0;
$arrSecCode=array();
$chars = preg_split('//', $security_code); 

$code=implode(" ",$chars);
$code="JESUS";
      /* font size will be 75% of the image height */
      $font_size = $height * 0.75;
      $image = imagecreate($width, $height) or die('Cannot initialize new GD image stream');
      /* set the colours */
      $background_color = imagecolorallocate($image, 255, 255, 255);
      $text_color = imagecolorallocate($image, 20, 40, 100);
      $noise_color = imagecolorallocate($image, 100, 120, 180);
      /* generate random dots in background */
      for( $i=0; $i<($width*$height)/3; $i++ ) {
         imagefilledellipse($image, mt_rand(0,$width), mt_rand(0,$height), 1, 1, $noise_color);
      }
      /* generate random lines in background */
      for( $i=0; $i<($width*$height)/150; $i++ ) {
         imageline($image, mt_rand(0,$width), mt_rand(0,$height), mt_rand(0,$width), mt_rand(0,$height), $noise_color);
      }
      /* create textbox and add text */
      $textbox = imagettfbbox($font_size, 0, $this->font, $code) or die('Error in imagettfbbox function');
      $x = ($width - $textbox[4])/2;
      $y = ($height - $textbox[5])/2;
      imagettftext($image, $font_size, 0, $x, $y, $text_color, $this->font , $code) or die('Error in imagettftext function');
      /* output captcha image to browser */
      header('Content-Type: image/jpeg');
      imagejpeg($image);
      imagedestroy($image);

   }
}
$obj=new Captcha;
//CaptchaSecurityImages(130,40,$obj->generateAlphaNumericString(6));
$secCode="";
if( isset( $_GET['code'] ) ) $secCode=trim($_GET['code']);

if( $secCode == "" ){
  $secCode=$obj->generateAlphaNumericString(5);
   if( $secCode == "" ) $secCode="JeSuS"; 
}

//Usage of function
//$obj->create_image(SecurityCodeText,WidthOfImage,heightOfImage);

$obj->create_image($secCode,130,35);

exit();

//How to use this class?
// Simply call this file imagecaptcha.php as  source of an image tag 
//eg: <img src=imagecaptcha.php?code=2422 />  parameter code is optional
// el code esta en $_SESSION['security_code']
?>
