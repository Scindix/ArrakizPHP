<?php
class Img {
	public static $img = "";
	public static function scale($x,$y)
	{
		$imagex = imagesx(self::$img);
		$imagey = imagesy(self::$img);
		$dest_imagex = $x;
		$dest_imagey = $y;
		$dest_image = imagecreatetruecolor($dest_imagex, $dest_imagey);
		$black = imagecolorallocate($dest_image, 0, 0, 0);
		// Make the background transparent
		imagesavealpha($dest_image, true);
		imagecolortransparent($dest_image, $black);
		imagecopyresampled($dest_image, self::$img, 0, 0, 0, 0, $dest_imagex, $dest_imagey, $imagex, $imagey);//imagecopyresampled imagecopyresized
		self::$img = $dest_image;
	}
	public static function scaleX($x)
	{
		Img::scale($x,imagesy(self::$img));
	}
	public static function scaleY($y)
	{
		Img::scale(imagesx(self::$img),$y);
	}
	public static function ratioScaleX($x)
	{
		Img::scale($x,$x*imagesy(self::$img)/imagesx(self::$img));
	}
	public static function ratioScaleY($y)
	{
		Img::scale($y*imagesx(self::$img)/imagesy(self::$img),$y);
	}
	public static function cut($x,$y)
	{
		$dest_image = imagecreatetruecolor($x, $y);
		$black = imagecolorallocate($dest_image, 0, 0, 0);
		// Make the background transparent
		imagecolortransparent($dest_image, $black);
		imagecopy($dest_image, self::$img, 0, 0, 0, 0, $x, $y);
		self::$img = $dest_image;
	}
	public static function map($base, $num)
	{
		$imagex = imagesx(self::$img);
		$imagey = imagesy(self::$img);
		
		//$dest_image = imagecreatetruecolor($imagex/$base, $imagey/$base);
		//imagecolortransparent($dest_image, $black);
		$x = $num % $base;
		$y = ($num - $x)/$base;
		$x *=$imagex/$base;
		$y *=$imagey/$base;
		//imagecopy($dest_image, self::$img, 0, 0, $x, $y, $imagex/$base, $imagey/$base);
		$dest_image = imagecrop(self::$img,array("x"=>$x, "y"=>$y, "width"=>$imagex/$base, "height"=>$imagey/$base));
		self::$img = $dest_image;
	}
	public static function cutX($x)
	{
		Img::cut($x,imagesy(self::$img));
	}
	public static function cutY($y)
	{
		Img::cut(imagesx(self::$img),$y);
	}
	public static function crop($x1,$y1,$x2,$y2)
	{
		$dest_image = imagecreatetruecolor($x2-$x1, $y2-$y1);
		$black = imagecolorallocate($dest_image, 0, 0, 0);
		// Make the background transparent
		imagecolortransparent($dest_image, $black);
		imagecopy($dest_image, self::$img, 0, 0, $x1, $y1, $x2, $y2);
		self::$img = $dest_image;
	}
	public static function cutSym($x,$y)
	{
		$dest_image = imagecreatetruecolor($x, $y);
		$black = imagecolorallocate($dest_image, 0, 0, 0);
		// Make the background transparent
		imagecolortransparent($dest_image, $black);
		imagecopy($dest_image, self::$img, 0, 0, intval((imagesx(self::$img)-$x)/2), intval((imagesy(self::$img)-$y)/2), intval((imagesx(self::$img)-$x)/2)+$x, intval((imagesy(self::$img)-$y)/2)+$y);
		self::$img = $dest_image;
	}
	public static function rotate($deg)
	{
		self::$img = imagerotate(self::$img, $deg, 0);
	}
	public static function setImg($i)
	{
		self::$img = $i;
	}
	public static function loadImg($i)
	{
		$arrDot = explode(".", $i);
		$ending = strtolower($arrDot[count($arrDot)-1]);
		if($ending=="gd2")
			self::$img = imagecreatefromgd($i);
		elseif($ending=="xbm")
			self::$img = imagecreatefromxbm($i);
		elseif($ending=="xpm")
			self::$img = imagecreatefromxpm($i);
		elseif($ending=="png")
			self::$img = imagecreatefrompng($i);
		elseif($ending=="gif")
			self::$img = imagecreatefromgif($i);
		elseif($ending=="gd2")
			self::$img = imagecreatefromgd2($i);
		elseif($ending=="bmp"||$ending=="wbmp")
			self::$img = imagecreatefromwbmp($i);
		elseif($ending=="jpg"||$ending=="jpeg")
			self::$img = imagecreatefromjpeg($i);
		elseif($ending=="webp")
			self::$img = imagecreatefromwebp($i);
		imagesavealpha(self::$img, true);
		ImageAlphaBlending(self::$img, true); 
	}	
	public static function returnImg()
	{
		header("Content-Type: image/png");
		imagepng(self::$img,NULL,9);
	}
}
?>
