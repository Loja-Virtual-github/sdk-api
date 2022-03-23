<?php

namespace LojaVirtual\SDKPix;

use Mpdf\QrCode\QrCode;

class Pix
{
    /**
     * @var string svg|png
     */
    private $output_format;

    /**
     * Payload instance
     *
     * @throws \InvalidArgumentException
     * @var Payload
     */
    private $payload;

    /**
     * The constructor
     *
     * @param array $params
     * @param string $output_format (svg|png)
     */
    public function __construct(array $params, $output_format = 'svg')
    {
        $this->payload = new Payload($params);
        $this->output_format = $output_format;
    }

    /**
     * Returns the qrCode and payload
     *
     * @param $size
     * @return mixed
     */
    public function generate($size = 400)
    {
        $payload = $this->payload->getPayload();
        $qrCode = new QrCode($payload);

        $buildOutputClass = $this->buildOutputClassName();
        $outputFormat = new $buildOutputClass($qrCode);
        $qrCodeData = $outputFormat->generate($size);

        return array(
            'qrcode' => $qrCodeData,
            'payload' => $payload
        );
    }

    /**
     * Build the output class name
     *
     * @return string
     */
    private function buildOutputClassName()
    {
        $className = trim($this->output_format);
        $className = ucfirst($className);
        $className = __NAMESPACE__ . "\\Generators\\{$className}";

        if (!class_exists($className)) {
            throw new \DomainException("Invalid output format $this->output_format.");
        }

        return $className;
    }
}