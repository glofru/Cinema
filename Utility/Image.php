<?php

class Image
{
    private $image;
    private $width;
    private $height;
    private $imageResized;


    function __construct($fileName)
    {
        $this->image = $this->openImage($fileName);
        $this->width  = imagesx($this->image);
        $this->height = imagesy($this->image);
    }

    private function openImage($file)
    {
        $estensione = strtolower(strrchr($file, '.'));

        switch($estensione)
        {
            case '.jpg':
            case '.jpeg':
                $img = @imagecreatefromjpeg($file);
                break;
            case '.gif':
                $img = @imagecreatefromgif($file);
                break;
            case '.png':
                $img = @imagecreatefrompng($file);
                break;
            default:
                $img = false;
                break;
        }
        return $img;
    }
    public function resizeImage($newWidth, $newHeight, $option="auto")
    {

        // Lunghezza e Altezza ottimale
        $dimott = $this->getDimensions($newWidth, $newHeight, strtolower($option));

        $ottWidth  = $dimott['optimalWidth'];
        $ottHeight = $dimott['optimalHeight'];

        // Immagine simile
        $this->imageResized = imagecreatetruecolor($ottWidth, $ottHeight);
        imagecopyresampled($this->imageResized, $this->image, 0, 0, 0, 0, $ottWidth, $ottHeight, $this->width, $this->height);

        //ritaglia
        if ($option == 'crop') {
            $this->crop($ottWidth, $ottHeight, $newWidth, $newHeight);
        }
    }
    private function getDimensions($newWidth, $newHeight, $option)
    {

        switch ($option)
        {
            case 'esatto':
                $ottWidth = $newWidth;
                $ottHeight= $newHeight;
                break;
            case 'ritratto':
                $ottWidth = $this->byHeight($newHeight);
                $ottHeight= $newHeight;
                break;
            case 'panorama':
                $ottWidth = $newWidth;
                $ottHeight= $this->byWidth($newWidth);
                break;
            case 'automatico':
                $optionArray = $this->dimAuto($newWidth, $newHeight);
                $ottWidth = $optionArray['optimalWidth'];
                $ottHeight = $optionArray['optimalHeight'];
                break;
            case 'crop':
                $optionArray = $this->OttCrop($newWidth, $newHeight);
                $ottWidth = $optionArray['optimalWidth'];
                $ottHeight = $optionArray['optimalHeight'];
                break;
        }
        return array('optimalWidth' => $ottWidth, 'optimalHeight' => $ottHeight);
    }
    private function byHeight($newHeight)
    {
        $ratio = $this->width / $this->height;
        $newWidth = $newHeight * $ratio;
        return $newWidth;
    }

    private function byWidth($newWidth)
    {
        $ratio = $this->height / $this->width;
        $newHeight = $newWidth * $ratio;
        return $newHeight;
    }

    private function dimAuto($newWidth, $newHeight)
    {
        if ($this->height < $this->width)
            // panorama
        {
            $ottWidth = $newWidth;
            $ottHeight= $this->byWidth($newWidth);
        }
        elseif ($this->height > $this->width)
            // profilo
        {
            $ottWidth = $this->byHeight($newHeight);
            $ottHeight= $newHeight;
        }
        else
            // quadrato
        {
            if ($newHeight < $newWidth) {
                $ottWidth = $newWidth;
                $ottHeight= $this->byWidth($newWidth);
            } else if ($newHeight > $newWidth) {
                $ottWidth = $this->byHeight($newHeight);
                $ottHeight= $newHeight;
            } else {
                $ottWidth = $newWidth;
                $ottHeight= $newHeight;
            }
        }

        return array('optimalWidth' => $ottWidth, 'optimalHeight' => $ottHeight);
    }

    private function ottCrop($newWidth, $newHeight)
    {

        $heightRatio = $this->height / $newHeight;
        $widthRatio  = $this->width /  $newWidth;

        if ($heightRatio < $widthRatio) {
            $optimalRatio = $heightRatio;
        } else {
            $optimalRatio = $widthRatio;
        }

        $ottHeight = $this->height / $optimalRatio;
        $ottWidth  = $this->width  / $optimalRatio;

        return array('optimalWidth' => $ottWidth, 'optimalHeight' => $ottHeight);
    }
    private function crop($ottWidth, $ottHeight, $newWidth, $newHeight)
    {
        //centro
        $cropStartX = ( $ottWidth / 2) - ( $newWidth /2 );
        $cropStartY = ( $ottHeight/ 2) - ( $newHeight/2 );

        $crop = $this->imageResized;
        // ritaglia dal centro
        $this->imageResized = imagecreatetruecolor($newWidth , $newHeight);
        imagecopyresampled($this->imageResized, $crop , 0, 0, $cropStartX, $cropStartY, $newWidth, $newHeight , $newWidth, $newHeight);
    }




    /*
    public function saveImage($savePath, $imageQuality="100")
    {
        $extension = strrchr($savePath, '.');
        $extension = strtolower($extension);

        switch($extension)
        {
            case '.jpg':
            case '.jpeg':
                if (imagetypes() & IMG_JPG) {
                    imagejpeg($this->imageResized, $savePath, $imageQuality);
                }
                break;

            case '.gif':
                if (imagetypes() & IMG_GIF) {
                    imagegif($this->imageResized, $savePath);
                }
                break;

            case '.png':
                // scala la qualità da 0-100 a 0-9
                $scaleQuality = round(($imageQuality/100) * 9);

                //
                $invertScaleQuality = 9 - $scaleQuality;

                if (imagetypes() & IMG_PNG) {
                    imagepng($this->imageResized, $savePath, $invertScaleQuality);
                }
                break;
            default:
                //nessun salvataggio
                break;
        }

        imagedestroy($this->imageResized);
    }*/

}
?>
