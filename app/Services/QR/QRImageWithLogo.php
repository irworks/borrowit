<?php

namespace App\Services\QR;

use chillerlan\QRCode\Output\QRCodeOutputException;
use chillerlan\QRCode\Output\QRGdImagePNG;

class QRImageWithLogo extends QRGdImagePNG
{

    /**
     * @param string|null $file
     * @param string|null $logo
     *
     * @return string
     * @throws \chillerlan\QRCode\Output\QRCodeOutputException
     */
    public function dump(string $file = null, string $logo = null, string $subtitle = null): string
    {
        // set returnResource to true to skip further processing for now
        $this->options->returnResource = true;

        // of course, you could accept other formats too (such as resource or Imagick)
        // I'm not checking for the file type either for simplicity reasons (assuming PNG)
        if (!is_file($logo) || !is_readable($logo)) {
            throw new QRCodeOutputException('invalid logo');
        }

        // there's no need to save the result of dump() into $this->image here
        parent::dump($file);

        $im = imagecreatefrompng($logo);

        // get logo image size
        $w = imagesx($im);
        $h = imagesy($im);

        // set new logo size, leave a border of 1 module (no proportional resize/centering)
        $lw = (($this->options->logoSpaceWidth - 2) * $this->options->scale);
        $lh = (($this->options->logoSpaceHeight - 2) * $this->options->scale);

        // get the qrcode size
        $ql = ($this->matrix->getSize() * $this->options->scale);

        // scale the logo and copy it over. done!
        imagecopyresampled($this->image, $im, (($ql - $lw) / 2), (($ql - $lh) / 2), 0, 0, $lw, $lh, $w, $h);

        if (!empty($subtitle)) {
            // set subtitle textColor
            $textColor = imagecolorallocatealpha($this->image, 0, 0, 0, 0);
            $fontSize = 21;
            $marginX = 10;
            $marginY = $ql - $marginX * 2 - $fontSize * 2;
            $fontPath = resource_path('/fonts/Roboto-Black.ttf');

            do {
                $fontSize--;

                $typeSpace = imagettfbbox($fontSize, 0, $fontPath, $subtitle);
                // Determine image width and height, 10 pixels are added for 5 pixels padding:
                $maxTextWidth = abs($typeSpace[4] - $typeSpace[0]) + 10;
            } while($maxTextWidth > $ql);

            $marginX = ($ql / 2) - ($maxTextWidth / 2);
            // apply text
            imagettftext($this->image, $fontSize, 0,
                $marginX, $fontSize + $marginY,
                $textColor, $fontPath, $subtitle
            );
        }

        $imageData = $this->dumpImage();

        $this->saveToFile($imageData, $file);

        if ($this->options->outputBase64) {
            $imageData = $this->toBase64DataURI($imageData);
        }

        return $imageData;
    }
}
