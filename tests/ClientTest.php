<?php


use Hypertech\Paysuite\Client;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{

    function testCanGenerateCheckoutUlr()
    {

        $paysuite = new Client($this->apikey);

            $result = $paysuite->checkout([
                "tx_ref" => 'TEST'.$this->generateReference(4),
                "currency" => "MZN",
                "purpose"=> "Invoice Payment",
                "amount" => 100,
                "callback_url" => "http://domaim.com/callback_url",
                "redirect_url" => "http://domaim.com/invoice.php"
            ]);

            $this->assertTrue($result->isSuccessfully(),$result->getMessage());
            $this->assertStringStartsWith('http', $result->getCheckoutUrl());


    }

    function testFailToGenerateCheckoutUlr()
    {

        $paysuite = new Client($this->apikey);

        $result = $paysuite->checkout([
            "tx_ref" => 'TEST'.$this->generateReference(4),
            "currency" => "MZX",
            "purpose"=> "Invoice Payment",
            "amount" => 100,
        ]);

        $this->assertFalse($result->isSuccessfully());
    }

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->apikey = $_ENV['SECRET_KEY'];
    }

    function generateReference($length): string
    {
        $chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $string = '';

        for ($i = 0; $i < $length; $i++) {
            $char = $chars[rand(0, strlen($chars) - 1)];

            while (strstr($string, $char)) {
                $char = $chars[rand(0, strlen($chars) - 1)];
            }

            $string .= $char;
        }

        return $string;
    }

}
