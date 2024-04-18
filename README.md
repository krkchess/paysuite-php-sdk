[![PHP Composer](https://github.com/hypertech-lda/paysuite-php-sdk/actions/workflows/php.yml/badge.svg)](https://github.com/hypertech-lda/paysuite-php-sdk/actions/workflows/php.yml)

## Como utilizar a biblioteca para criar um checkout

A biblioteca `paysuite-php-sdk` permite que você crie checkouts de forma fácil e rápida. Para criar um checkout, e receber pagamentos suando métodos de pagamento disponíveis em Moçambique como Mpesa, eMola, PayPal e transferência bancária.
Para usar siga os seguintes passos:

1. Crie uma conta no [Paysuite.co.mz](https://paysuite.co.mz) e obtenha a chave secreta no seu dashboard

2. Instale a biblioteca `paysuite-php-sdk`:

    ```bash
    composer require hypertech/paysuite-php-sdk
    ```

3. Crie uma instância da classe `Client` com seu Secret key e chame o método `checkout()` da classe `Client` :

```php
use Hypertech\Paysuite\Client;

$secret = "SuaChaveSecreta";
$paysuite = new Client($secret);
$paysuite->enableTestMode(); // Chame esta função para habilitar o modo de teste

$result = $paysuite->checkout([
    "tx_ref" => 'FACT123',
    "currency" => "MZN",
    "purpose"=> "Pagamento de factura",
    "amount" => 100,
    "callback_url" => "http://seusite.com/callback_url",
    "redirect_url" => "http://seusite.com/invoice.php"
]);

if ($result->isSuccessfully()) {
    $checkoutUrl = $result->getCheckoutUrl();
} else {
    echo $result->getMessage();
}
```


### Testes

``` bash
export SECRET_KEY="ASuaChaveSecreta"
composer test
```

### Changelog

Por-favor veja [CHANGELOG](CHANGELOG.md) para mais detalhes.

## Contribua

Por-favor veja [CONTRIBUTING](CONTRIBUTING.md) para mais detalhes.

### Segurança

Se você descobrir algum problema relacionado à segurança, envie um e-mail para security@hypertech.co.mz em vez de usar o rastreador de problemas.


## Licença

The MIT License (MIT). Por-favor veja [License File](LICENSE.md) para mais informações.
