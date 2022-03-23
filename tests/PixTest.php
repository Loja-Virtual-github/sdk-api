<?php

namespace LojaVirtual\SDKPix\Tests;

use LojaVirtual\SDKPix\Pix;

class PixTest extends BaseTesting
{
    public function testInstanceOf()
    {
        $params = array(
            "pixKey" => "teste",
            "description" => "Teste Loja Virtual",
            "merchantName" => "PABLO RAPHAEL ALVES SANCH",
            "merchantCity" => "BELO HORIZONTE",
            "txid" => 'Teste',
            "amount" => 10
        );
        $pix = new Pix($params);
        $this->assertInstanceOf('LojaVirtual\SDKPix\Pix', $pix);
    }

    public function testBuildClassNameLowerCase()
    {
        $params = array(
            "pixKey" => "teste",
            "description" => "Teste Loja Virtual",
            "merchantName" => "PABLO RAPHAEL ALVES SANCH",
            "merchantCity" => "BELO HORIZONTE",
            "txid" => 'Teste',
            "amount" => 10
        );

        $pix = new Pix($params);
        $className = self::callMethod(
            $pix,
            'buildOutputClassName',
            ['png']
        );

        $this->assertEquals('LojaVirtual\SDKPix\Generators\Svg', $className);
    }

    public function testBuildClassNameUpperCase()
    {
        $params = array(
            "pixKey" => "teste",
            "description" => "Teste Loja Virtual",
            "merchantName" => "PABLO RAPHAEL ALVES SANCH",
            "merchantCity" => "BELO HORIZONTE",
            "txid" => 'Teste',
            "amount" => 10
        );

        $pix = new Pix($params);
        $className = self::callMethod(
            $pix,
            'buildOutputClassName',
            ['PNG']
        );

        $this->assertEquals('LojaVirtual\SDKPix\Generators\Svg', $className);
    }

    public function testGenerate()
    {
        $params = array(
            "pixKey" => "teste",
            "description" => "Teste Loja Virtual",
            "merchantName" => "PABLO RAPHAEL ALVES SANCH",
            "merchantCity" => "BELO HORIZONTE",
            "txid" => 'Teste',
            "amount" => 10
        );

        $pix = new Pix($params);
        $result = $pix->generate();
        $this->assertNotEmpty($result);
        $this->assertArrayHasKey('payload', $result);
        $this->assertArrayHasKey('qrcode', $result);
    }
}