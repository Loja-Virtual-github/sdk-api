<?php

namespace LojaVirtual\SDKPix\Tests\Generators;

use LojaVirtual\SDKPix\Generators\Png;
use LojaVirtual\SDKPix\Tests\BaseTesting;
use Mpdf\QrCode\QrCode;

class PngTest extends BaseTesting
{
    public function testImplementsGeneratorsInterface()
    {
        $qrCode = new QrCode('teste');
        $png = new Png($qrCode);
        $this->assertInstanceOf('LojaVirtual\SDKPix\Generators\GeneratorInterface', $png);
    }

    public function testInstanceOf()
    {
        $qrCode = new QrCode('teste');
        $png = new Png($qrCode);
        $this->assertInstanceOf('LojaVirtual\SDKPix\Generators\Png', $png);
    }

    public function testGenerate()
    {
        $qrCode = new QrCode('teste');
        $png = new Png($qrCode);
        $data = $png->generate(400);
        $this->assertNotEmpty($data);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGenerationWrongSize()
    {
        $qrCode = new QrCode('teste');
        $png = new Png($qrCode);
        $data = $png->generate('test');
        $this->assertNotEmpty($data);
    }
}