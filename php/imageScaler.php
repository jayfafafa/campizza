<?php
// Image Scaling and Centering developed by benshimmin on Github
require("fpdf/fpdf.php");
class PDF extends FPDF {
    const DPI = 150;
    const MM_IN_INCH = 25.4;
    const A4_HEIGHT = 210;
    const A4_WIDTH = 297;
    // tweak these values (in pixels)
    const MAX_WIDTH = 1150;
    const MAX_HEIGHT = 1650;
	
    function pixelsToMM($val) {
        return $val * self::MM_IN_INCH / self::DPI;
    }
	
    function resizeToFit($imgFilename) {
        list($width, $height) = getimagesize($imgFilename);
        $widthScale = self::MAX_WIDTH / $width;
        $heightScale = self::MAX_HEIGHT / $height;
        $scale = min($widthScale, $heightScale);
        return array(
            round($this->pixelsToMM($scale * $width)),
            round($this->pixelsToMM($scale * $height))
        );
    }
	
    function centreImage($img) {
        list($width, $height) = $this->resizeToFit($img);
        // you will probably want to swap the width/height
        // around depending on the page's orientation
        $this->Image(
            $img, (self::A4_HEIGHT - $width) / 2,
            (self::A4_WIDTH - $height) / 2,
            $width,
            $height
        );
    }
}
?>