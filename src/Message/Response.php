<?php

namespace Hypertech\Paysuite\Message;
class Response
{
    public string $status;
    private ?string $transaction_id = null;
    private ?string $trx_ref = null;
    private string $checkout_url;
    private float $amount;
    private string $message;
    private array  $content;

    public function __construct($content)
    {
        $this->content = json_decode($content, true);
        $this->initialize();
    }

    /**
     * @return string|null
     */
    public function getTransactionId(): ?string
    {
        return $this->transaction_id;
    }

    /**
     * @return string|null
     */
    public function getTrxRef(): ?string
    {
        return $this->trx_ref;
    }

    /**
     * @return string|null
     */
    public function getCheckoutUrl(): ?string
    {
        return $this->checkout_url;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @return array
     */
    public function getContent(): array
    {
        return $this->content;
    }

    public function initialize(){

        foreach ($this->getproperties() as $property){
            if (isset($this->content[$property])){
                $this->{$property} = $this->content[$property];
            }
        }


    }

    private function getProperties():array{

        return array(
            'status',
            'checkout_url',
            'message',
        );
    }

    public function isSuccessfully(): bool
    {
        return ($this->status == 'success');
    }

    public function getMessage(): string
    {
        return $this->message;
    }



}