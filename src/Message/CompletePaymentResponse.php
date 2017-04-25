<?php

namespace Omnipay\Nestpay\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Common\Exception\InvalidResponseException;

class CompletePaymentResponse extends AbstractResponse
{

    public function __construct(RequestInterface $request, $data)
    {
        $this->request = $request;
        $this->data = $data;
        if (!$this->signHash()) {
            throw new InvalidResponseException('Invalid sign hash');
        }
    }

    public function isSuccessful()
    {   
        if (isset($this->data['mdStatus']) && !in_array($this->data['mdStatus'], [1, 2, 3, 4]))
            return false;
        return $this->data["Response"] === 'Approved';
    }

    public function getMessage()
    {
        return isset($this->data['ErrMsg']) ? $this->data['ErrMsg'] : $this->data['mdErrorMsg'];
    }

    public function getTransactionId()
    {
        return $this->data['TransId'];
    }

    public function getTransactionReference()
    {
        return $this->data['HostRefNum'];
    }

    public function getAmount()
    {
        return $this->data['amount'];
    }

    public function getCurrency()
    {
        return $this->data['currency'];
    }

    public function getOrderId()
    {
        return $this->data['ReturnOid'];
    }

    private function signHash()
    {
        $hashParams = explode('|', trim($this->data['HASHPARAMS']));
        $signature = "";
        foreach ($hashParams as $parameter) {
            if (isset($this->data[$parameter])) {
                $signature .= $this->data[$parameter] . '|';
            }
        }
        $generateHash = base64_encode(pack('H*', hash('sha512', $signature . $this->request->getStoreKey())));
        if ($generateHash != $this->data["HASH"]) {
            return false;
        }
        return true;
    }
}
