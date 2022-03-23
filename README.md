# lojavirtual/sdk-pix

SDK de integração com PIX do Banco Central

## Summary

Esta sdk gera o qrCode estático para pagamentos sem intemediadores, direto com banco central.


### Como utilizar

```php
$params = array(
    "pixKey" => "teste",
    "description" => "Teste Loja Virtual",
    "merchantName" => "PABLO RAPHAEL ALVES SANCH",
    "merchantCity" => "BELO HORIZONTE",
    "txid" => 'Teste',
    "amount" => 10
);

$pix = new Pix($params, 'svg'); // Aceita svg|png
$result = $pix->generate(400); // Tamanho do qrCode gerado

/**
* Retorna um array com duas chaves: 
  - payload: Código do pix copia e cola
  - qrcode: Binário ou Html de SVG do qrCode 
*/
```

### enjoy it! ;)