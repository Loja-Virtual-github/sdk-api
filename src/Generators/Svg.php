<?php

namespace LojaVirtual\SDKPix\Generators;

use Mpdf\QrCode\QrCode;
use Mpdf\QrCode\Output;

class Svg implements GeneratorInterface
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
     * Generate the Svg data
     *
     * @param $size
     * @throws \InvalidArgumentException
     * @return string
     */
    public function generate($size = 400)
    {
        if (!filter_var($size, FILTER_VALIDATE_INT)) {
            throw new \InvalidArgumentException("Size must be numeric.");
        }

        $svg = new Output\Svg();
        return $svg->output($this->qrCode, $size, 'white', 'black');
    }
}