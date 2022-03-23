<?php

namespace LojaVirtual\SDKPix\Tests\Generators;

use LojaVirtual\SDKPix\Generators\Svg;
use LojaVirtual\SDKPix\Tests\BaseTesting;
use Mpdf\QrCode\QrCode;

class SvgTest extends BaseTesting
{
    public function testImplementsGeneratorsInterface()
    {
        $qrCode = new QrCode('teste');
        $svg = new Svg($qrCode);
        $this->assertInstanceOf('LojaVirtual\SDKPix\Generators\GeneratorInterface', $svg);
    }

    public function testInstanceOf()
    {
        $qrCode = new QrCode('teste');
        $svg = new Svg($qrCode);
        $this->assertInstanceOf('LojaVirtual\SDKPix\Generators\Svg', $svg);
    }

    public function testGenerate()
    {
        $qrCode = new QrCode('teste');
        $svg = new Svg($qrCode);
        $data = $svg->generate(400);
        $this->assertNotEmpty($data);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGenerationWrongSize()
    {
        $qrCode = new QrCode('teste');
        $svg = new Svg($qrCode);
        $data = $svg->generate('test');
        $this->assertNotEmpty($data);
    }
}