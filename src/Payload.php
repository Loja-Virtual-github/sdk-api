<?php

namespace LojaVirtual\SDKPix;

use \InvalidArgumentException;
use Money\Currency;
use Money\Money;

class Payload
{
    const PIX_DOMAIN = 'BR.GOV.BCB.PIX';
    const ID_PAYLOAD_FORMAT_INDICATOR = '00';
    const ID_MERCHANT_ACCOUNT_INFORMATION = '26';
    const ID_MERCHANT_ACCOUNT_INFORMATION_GUI = '00';
    const ID_MERCHANT_ACCOUNT_INFORMATION_KEY = '01';
    const ID_MERCHANT_ACCOUNT_INFORMATION_DESCRIPTION = '02';
    const ID_MERCHANT_CATEGORY_CODE = '52';
    const ID_TRANSACTION_CURRENCY = '53';
    const ID_TRANSACTION_AMOUNT = '54';
    const ID_COUNTRY_CODE = '58';
    const ID_MERCHANT_NAME = '59';
    const ID_MERCHANT_CITY = '60';
    const ID_ADDITIONAL_DATA_FIELD_TEMPLATE = '62';
    const ID_ADDITIONAL_DATA_FIELD_TEMPLATE_TXID = '05';
    const ID_CRC16 = '63';
    const BRL_CURRENCY_CODE = 986;
    const BRL_COUNTRY_CODE = 'BR';
    const CATEGORY_CODE = '0000';

    /**
     * Default parameters
     * @var array
     */
    private $default_params = array(
        "pixKey" => "",
        "description" => "",
        "merchantName" => "",
        "merchantCity" => "",
        "txid" => '',
        "amount" => null
    );

    private $optional_fields = ['description'];

    /**
     * The constructor
     * @param array $defaultParams
     */
    public function __construct(array $defaultParams = null)
    {
        if (empty($defaultParams)) {
            throw new \InvalidArgumentException("Invalid params");
        }

        $this->initialize($defaultParams);
    }

    /**
     * Returns all arguments
     * @return array
     */
    public function getParams()
    {
        return $this->default_params;
    }

    /**
     * Returns specific param
     *
     * @param $key
     * @return mixed
     */
    public function getParam($key)
    {
        return $this->default_params[$key];
    }

    /**
     * Initialize the object parsing by the default params
     * @param array $params
     * @throws InvalidArgumentException
     * @return void
     */
    private function initialize(array $params)
    {
        /**
         * @throws InvalidArgumentException
         */
        $this->isValidParams($params);

        $defaultParams = array_keys($this->default_params);
        foreach ($defaultParams as $key) {
            if (array_key_exists($key, $params)) {
                $this->default_params[$key] = $params[$key];
            }
        }
    }

    /**
     * Validate if the params is valid
     * @param array $params
     * @throws \InvalidArgumentException
     * @return bool
     */
    private function isValidParams(array $params)
    {
        if (empty($params)) {
            throw new InvalidArgumentException('Invalid params');
        }

        $paramsKey = array_keys($this->default_params);
        foreach ($paramsKey as $key) {
            if (empty($params[$key])) {
                if (!in_array($key, $this->getOptionalFields())) {
                    throw new InvalidArgumentException("Param $key is required");
                }
            }
        }

        return true;
    }

    /**
     * Returns all optional fields
     *
     * @return string
     */
    private function getOptionalFields()
    {
        return $this->optional_fields;
    }

    /**
     * Remove all special chars
     *
     * @param string $str
     * @return string
     */
    private function removeSpecialChars($str)
    {
        $str = preg_replace('/[áàãâä]/ui', 'a', $str);
        $str = preg_replace('/[éèêë]/ui', 'e', $str);
        $str = preg_replace('/[íìîï]/ui', 'i', $str);
        $str = preg_replace('/[óòõôö]/ui', 'o', $str);
        $str = preg_replace('/[úùûü]/ui', 'u', $str);
        $str = preg_replace('/[ç]/ui', 'c', $str);

        return $str;
    }

    /**
     * Returns entire value of a payload object
     *
     * @param string $id
     * @param string $value
     * @return string
     */
    private function getValue($id, $value)
    {
        $length = strlen($value);
        $size = str_pad($length, 2, '0', STR_PAD_LEFT);
        return sprintf("%s%s%s", $id, $size, $value);
    }

    /**
     * Returns full account information
     *
     * @return string
     */
    private function getMerchantAccountInformation()
    {
        // Bank domain
        $gui = $this->getValue(self::ID_MERCHANT_ACCOUNT_INFORMATION_GUI, self::PIX_DOMAIN);

        // Pix Key
        $key = $this->getValue(self::ID_MERCHANT_ACCOUNT_INFORMATION_KEY, $this->getParam('pixKey'));

        // Payment description
        $description = !empty($this->getParams('description'))
            ? $this->getValue(self::ID_MERCHANT_ACCOUNT_INFORMATION_DESCRIPTION, $this->getParam('description'))
            : '';
        $description = '';

        return $this->getValue(
            self::ID_MERCHANT_ACCOUNT_INFORMATION,
            sprintf("%s%s%s", $gui, $key, $description)
        );
    }

    private function getCategoryCode()
    {
        return $this->getValue(self::ID_MERCHANT_CATEGORY_CODE, self::CATEGORY_CODE);
    }

    /**
     * Return the payload header
     *
     * @return string
     */
    private function getPayloadHeader()
    {
        return $this->getValue(self::ID_PAYLOAD_FORMAT_INDICATOR, '01');
    }

    /**
     * Returns the currency code
     *
     * @return string
     */
    private function getCurrencyCode()
    {
        return $this->getValue(self::ID_TRANSACTION_CURRENCY, self::BRL_CURRENCY_CODE);
    }

    /**
     * Get ammount
     *
     * @return string
     */
    private function getAmmount()
    {
        $amount = $this->getParam('amount');
        $amount = number_format($amount, 2, '.', '');
        return $this->getValue(self::ID_TRANSACTION_AMOUNT, $amount);
    }

    /**
     * Return the country code
     *
     * @return string
     */
    private function getCountryCode()
    {
        return $this->getValue(self::ID_COUNTRY_CODE, self::BRL_COUNTRY_CODE);
    }

    /**
     * Returns the merchant name
     *
     * @return string
     */
    private function getMerchantName()
    {
        $merchantName = $this->getParam('merchantName');
        $merchantName = $this->removeSpecialChars($merchantName);
//        $merchantName = ucfirst($merchantName);
        return $this->getValue(self::ID_MERCHANT_NAME, $merchantName);
    }

    /**
     * Returns the merchant city
     *
     * @return string
     */
    private function getMerchantCity()
    {
        $merchantCity = $this->getParam('merchantCity');
        $merchantCity = $this->removeSpecialChars($merchantCity);
//        $merchantCity = mb_strtoupper($merchantCity);
        return $this->getValue(self::ID_MERCHANT_CITY, $merchantCity);
    }

    /**
     * Returns the full additional pix fields (TXID)
     *
     * @return string
     */
    private function getAdditionalDataFieldTemplate()
    {
        $txID = $this->getValue(self::ID_ADDITIONAL_DATA_FIELD_TEMPLATE_TXID, $this->getParam('txid'));
        return $this->getValue(self::ID_ADDITIONAL_DATA_FIELD_TEMPLATE, $txID);
    }

    /**
     * Calculate the validation hash
     *
     * @param $payload
     * @return string
     */
    private function getCRC16($payload)
    {
        $payload .= self::ID_CRC16 . '04';

        $polynomial = 0x1021;
        $result = 0xFFFF;

        if (($length = strlen($payload)) > 0) {
            for ($offset = 0; $offset < $length; $offset++) {
                $result ^= (ord($payload[$offset]) << 8);
                for ($bitwise = 0; $bitwise < 8; $bitwise++) {
                    if (($result <<= 1) & 0x10000) $result ^= $polynomial;
                    $result &= 0xFFFF;
                }
            }
        }
        return self::ID_CRC16.'04'.strtoupper(dechex($result));
    }


    /**
     * Generate the pix payload
     *
     * @return string
     */
    public function getPayload()
    {
        $payload =
            $this->getPayloadHeader() .
            $this->getMerchantAccountInformation() .
            $this->getCategoryCode() .
            $this->getCurrencyCode() .
            $this->getAmmount() .
            $this->getCountryCode() .
            $this->getMerchantName() .
            $this->getMerchantCity() .
            $this->getAdditionalDataFieldTemplate();

        $validationHash = $this->getCRC16($payload);
        return $payload . $validationHash;
    }
}