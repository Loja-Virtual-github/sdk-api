<?php

namespace LojaVirtual\SDKPix\Tests;

use LojaVirtual\SDKPix\Payload;
use Mpdf\QrCode\QrCode;
use Mpdf\QrCode\Output;

class PayloadTest extends BaseTesting
{
    public function testInitialize()
    {
        $params = array(
            "pixKey" => "teste",
            "description" => "Teste",
            "merchantName" => "Teste da Silva Sauro",
            "merchantCity" => "Belo Horizonte",
            "txid" => 'Teste',
            "amount" => 10
        );

        $params2 = array(
            "pixKey" => "alterado",
            "description" => "alterado",
            "merchantName" => "alterado",
            "merchantCity" => "alterado",
            "txid" => 'alterado',
            "amount" => 5
        );

        $payload = new Payload($params);
        self::callMethod(
            $payload,
            'initialize',
            [$params2]
        );

        $this->assertEquals($params2, $payload->getParams());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInitializeWithInvalidParams()
    {
        $params = array();
        $Payload = new Payload($params);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInitializeWithoutParams()
    {
        $Payload = new Payload();
    }

    public function testGetPayload()
    {
        $params = array(
            "pixKey" => "teste",
            "description" => "Teste",
            "merchantName" => "Teste da Silva Sauro",
            "merchantCity" => "Belo Horizonte",
            "txid" => 'Teste',
            "amount" => 10
        );

        $payload = new Payload($params);
        $pixCode = $payload->getPayload();

        $this->assertNotEmpty($pixCode);
    }

    public function testGetParams()
    {
        $params = array(
            "pixKey" => "teste",
            "description" => "Teste",
            "merchantName" => "Teste da Silva Sauro",
            "merchantCity" => "Belo Horizonte",
            "txid" => 'Teste',
            "amount" => 10
        );

        $payload = new Payload($params);
        $this->assertNotEmpty($payload->getParams());
    }

    public function testGetParam()
    {
        $params = array(
            "pixKey" => "teste",
            "description" => "Teste",
            "merchantName" => "Teste da Silva Sauro",
            "merchantCity" => "Belo Horizonte",
            "txid" => 'Teste',
            "amount" => 10
        );

        $payload = new Payload($params);
        $this->assertEquals($params['pixKey'], $payload->getParam('pixKey'));
        $this->assertEquals($params['description'], $payload->getParam('description'));
        $this->assertEquals($params['merchantName'], $payload->getParam('merchantName'));
        $this->assertEquals($params['merchantCity'], $payload->getParam('merchantCity'));
        $this->assertEquals($params['txid'], $payload->getParam('txid'));
        $this->assertEquals($params['amount'], $payload->getParam('amount'));
    }

    public function testIsValidParams()
    {
        $params = array(
            "pixKey" => "teste",
            "description" => "Teste",
            "merchantName" => "Teste da Silva Sauro",
            "merchantCity" => "Belo Horizonte",
            "txid" => 'Teste',
            "amount" => 10
        );

        $payload = new Payload($params);
        $isValid = self::callMethod(
            $payload,
            'isValidParams',
            [$params]
        );

        $this->assertTrue($isValid);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidParams()
    {
        $params = array(
            "pixKey" => "",
            "description" => "Teste",
            "merchantName" => "Teste da Silva Sauro",
            "merchantCity" => "Belo Horizonte",
            "txid" => 'Teste',
            "amount" => 10
        );

        $payload = new Payload($params);
        $isValid = self::callMethod(
            $payload,
            'isValidParams',
            [$params]
        );

        $this->assertTrue($isValid);
    }

    public function testGetOptionalFields()
    {
        $params = array(
            "pixKey" => "teste",
            "description" => "Teste",
            "merchantName" => "Teste da Silva Sauro",
            "merchantCity" => "Belo Horizonte",
            "txid" => 'Teste',
            "amount" => 10
        );

        $payload = new Payload($params);
        $optionalFields = self::callMethod(
            $payload,
            'getOptionalFields',
            []
        );
        $this->assertNotEmpty($optionalFields);
    }

    public function testRemoveSpecialChars()
    {
        $params = array(
            "pixKey" => "teste",
            "description" => "Teste",
            "merchantName" => "Teste da Silva Sauro",
            "merchantCity" => "Belo Horizonte",
            "txid" => 'Teste',
            "amount" => 10
        );

        $payload = new Payload($params);
        $string = self::callMethod(
            $payload,
            'removeSpecialChars',
            ['Ração Para cachorro']
        );

        $this->assertEquals('Racao Para cachorro', $string);
    }

    public function testGetValue()
    {
        $params = array(
            "pixKey" => "teste",
            "description" => "Teste",
            "merchantName" => "Teste da Silva Sauro",
            "merchantCity" => "Belo Horizonte",
            "txid" => 'Teste',
            "amount" => 10
        );

        $payload = new Payload($params);
        $string = self::callMethod(
            $payload,
            'getValue',
            ['00', 'teste']
        );

        $this->assertEquals('0005teste', $string);
    }

    public function testGetMerchantAccountInformation()
    {
        $params = array(
            "pixKey" => "teste",
            "description" => "Teste",
            "merchantName" => "Teste da Silva Sauro",
            "merchantCity" => "Belo Horizonte",
            "txid" => 'Teste',
            "amount" => 10
        );

        $payload = new Payload($params);
        $string = self::callMethod(
            $payload,
            'getMerchantAccountInformation',
            []
        );

        $this->assertEquals('26360014br.gov.bcb.pix0105teste0205Teste', $string);
    }

    public function testGetCategoryCode()
    {
        $params = array(
            "pixKey" => "teste",
            "description" => "Teste",
            "merchantName" => "Teste da Silva Sauro",
            "merchantCity" => "Belo Horizonte",
            "txid" => 'Teste',
            "amount" => 10
        );

        $payload = new Payload($params);
        $string = self::callMethod(
            $payload,
            'getCategoryCode',
            []
        );

        $this->assertEquals('52040000', $string);
    }

    public function testGetPayloadHeader()
    {
        $params = array(
            "pixKey" => "teste",
            "description" => "Teste",
            "merchantName" => "Teste da Silva Sauro",
            "merchantCity" => "Belo Horizonte",
            "txid" => 'Teste',
            "amount" => 10
        );

        $payload = new Payload($params);
        $string = self::callMethod(
            $payload,
            'getPayloadHeader',
            []
        );

        $this->assertEquals('000201', $string);
    }

    public function testGetCurrencyCode()
    {
        $params = array(
            "pixKey" => "teste",
            "description" => "Teste",
            "merchantName" => "Teste da Silva Sauro",
            "merchantCity" => "Belo Horizonte",
            "txid" => 'Teste',
            "amount" => 10
        );

        $payload = new Payload($params);
        $string = self::callMethod(
            $payload,
            'getCurrencyCode',
            []
        );

        $this->assertEquals('5303986', $string);
    }

    public function testGetAmmount()
    {
        $params = array(
            "pixKey" => "teste",
            "description" => "Teste",
            "merchantName" => "Teste da Silva Sauro",
            "merchantCity" => "Belo Horizonte",
            "txid" => 'Teste',
            "amount" => 10
        );

        $payload = new Payload($params);
        $string = self::callMethod(
            $payload,
            'getAmmount',
            []
        );

        $this->assertEquals('540210', $string);
    }

    public function testGetCountryCode()
    {
        $params = array(
            "pixKey" => "teste",
            "description" => "Teste",
            "merchantName" => "Teste da Silva Sauro",
            "merchantCity" => "Belo Horizonte",
            "txid" => 'Teste',
            "amount" => 10
        );

        $payload = new Payload($params);
        $string = self::callMethod(
            $payload,
            'getCountryCode',
            []
        );

        $this->assertEquals('5802BR', $string);
    }

    public function testGetMerchantName()
    {
        $params = array(
            "pixKey" => "teste",
            "description" => "Teste",
            "merchantName" => "Teste da Silva Sauro",
            "merchantCity" => "Belo Horizonte",
            "txid" => 'Teste',
            "amount" => 10
        );

        $payload = new Payload($params);
        $string = self::callMethod(
            $payload,
            'getMerchantName',
            []
        );

        $this->assertEquals('5920Teste da Silva Sauro', $string);
    }

    public function testGetMerchantCity()
    {
        $params = array(
            "pixKey" => "teste",
            "description" => "Teste",
            "merchantName" => "Teste da Silva Sauro",
            "merchantCity" => "Belo Horizonte",
            "txid" => 'Teste',
            "amount" => 10
        );

        $payload = new Payload($params);
        $string = self::callMethod(
            $payload,
            'getMerchantCity',
            []
        );

        $this->assertEquals('6014BELO HORIZONTE', $string);
    }

    public function testGetAdditionalDataFieldTemplate()
    {
        $params = array(
            "pixKey" => "teste",
            "description" => "Teste",
            "merchantName" => "Teste da Silva Sauro",
            "merchantCity" => "Belo Horizonte",
            "txid" => 'Teste',
            "amount" => 10
        );

        $payload = new Payload($params);
        $string = self::callMethod(
            $payload,
            'getAdditionalDataFieldTemplate',
            []
        );

        $this->assertEquals('62090505Teste', $string);
    }

    public function testGetCRC16()
    {
        $params = array(
            "pixKey" => "teste",
            "description" => "Teste",
            "merchantName" => "Teste da Silva Sauro",
            "merchantCity" => "Belo Horizonte",
            "txid" => 'Teste',
            "amount" => 10
        );

        $payload = new Payload($params);
        $string = self::callMethod(
            $payload,
            'getCRC16',
            [$payload->getPayload()]
        );

        $this->assertEquals('63046F4C', $string);
    }
}