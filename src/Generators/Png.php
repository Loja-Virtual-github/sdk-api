<?php

namespace LojaVirtual\SDKPix\Generators;

use Mpdf\QrCode\QrCode;
use Mpdf\QrCode\Output;

class Png implements GeneratorInterface
{
    /**
     * @var QrCode
     */
    private $qrCode;

    /**
     * The constructor
     *
     * @param QrCode $qrCode
     */
    public function __construct(QrCode $qrCode)
    {
        $this->qrCode = $qrCode;
    }

    /**
     * Generate the png data
     *
     * @param $size
     * @return string
     */
    public function generate($size = 400)
    {
        if (!filter_var($size, FILTER_VALIDATE_INT)) {
            throw new \InvalidArgumentException("Size must be numeric.");
        }

        $png = new Output\Png();
        return $png->output($this->qrCode, $size, [255, 255, 255], [0, 0, 0]);
    }
}