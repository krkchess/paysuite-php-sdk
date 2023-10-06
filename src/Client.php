<?php

namespace Hypertech\Paysuite;

use Hypertech\Paysuite\Message\Response;
class Client
{

    private string $secret_key;
    private  int $test_mode = 0;
    private string $api_url = "https://paysuite.co.mz/api/v1/";
    private int $timeout = 30;

    /**
     * @param  string  $secret_key secret key
     */
    public function __construct(string $secret_key)
    {
        $this->secret_key = $secret_key;
    }


    /**
     * @return string
     */
    public function getSecretKey(): string
    {
        return $this->secret_key;
    }

    /**
     * @param  string  $secret_key
     */
    public function setSecretKey(string $secret_key): void
    {
        $this->secret_key = trim($secret_key);
    }

    /**
     * @return int
     */
    public function getTestMode(): int
    {
        return $this->test_mode;
    }

    /**
     * @return void
     */
    public function enableTestMode(): void
    {
        $this->test_mode = 1;
    }

    /**
     * @param  array  $data
     * @return Response
     */
    public function checkout(array $data): Response
    {
       $result =  $this->request('POST', 'payments', $data);
       return new Response($result);
    }

    public function request($method, $path = '', $data = [])
    {
        $url = $this->api_url . $path;
        $data = array_merge([
            'is_test' => $this->getTestMode(),
        ], $data);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => $this->timeout,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer '.$this->getSecretKey()
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }

}