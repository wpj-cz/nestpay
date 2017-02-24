<?php

namespace Omnipay\Nestpay;

use Omnipay\Common\AbstractGateway;

class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'Nestpay';
    }

    public function getDefaultParameters()
    {
        return array(
            'bank' => '',
            'username' => '',
            'password' => '',
            'clientId' => '',
            'orderid' => '',
            'storeKey' => '',
            'BillToName' => 'billToName',
            'BillToCompany' => 'billToCompany',
            'transactionType' => 'Auth',
            'installment' => 1,
            'lang' => 'sl',
            'testMode' => false,
        );
    }

    public function getBank () {
        return $this->getParameter('bank');
    }

    public function setBank ($value) {
        return $this->setParameter('bank', $value);
    }

    public function getUsername () {
        return $this->getParameter('username');
    }

    public function setUsername ($value) {
        return $this->setParameter('username', $value);
    }

    public function getPassword () {
        return $this->getParameter('password');
    }

    public function setPassword ($value) {
        return $this->setParameter('password', $value);
    }

    public function getClientId () {
        return $this->getParameter('clientId');
    }

    public function setClientId ($value) {
        return $this->setParameter('clientId', $value);
    }

    public function getStoreKey () {
        return $this->getParameter('storeKey');
    }

    public function setStoreKey ($value) {
        return $this->setParameter('storeKey', $value);
    }

    public function getFirmName() {
       return $this->getParameter('firmName');
    }

    public function setFirmName($value) {
       return $this->setParameter('firmName', $value);
    }

    public function getBillToName() {
        return $this->getParameter('billToName');
    }

    public function setBillToName($value) {
        return $this->setParameter('billToName', $value);
    }

    public function getBillToCompany() {
        return $this->getParameter('billToCompany');
    }

    public function setBillToCompany($value) {
        return $this->setParameter('billToCompany', $value);
    }

   public function getLang() {
      return $this->getParameter('lang');
   }

   public function setLang($value) {
      return $this->setParameter('lang', $value);
   }

    public function authorize(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Nestpay\Message\AuthorizeRequest', $parameters);
    }

    public function completeAuthorize(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Nestpay\Message\CompletePaymentRequest', $parameters);
    }

    public function capture(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Nestpay\Message\CaptureRequest', $parameters);
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Nestpay\Message\PurchaseRequest', $parameters);
    }

    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Nestpay\Message\CompletePaymentRequest', $parameters);
    }

    public function void(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Nestpay\Message\VoidRequest', $parameters);
    }

    public function refund(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Nestpay\Message\RefundRequest', $parameters);
    }

}
