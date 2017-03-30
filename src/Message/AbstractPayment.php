<?php

namespace Omnipay\Nestpay\Message;

abstract class AbstractPayment extends AbstractRequest
{
    protected $transactionType;

    protected $endpoints = [
        'isbank' => 'https://spos.isbank.com.tr/servlet/est3Dgate',
        'akbank' => 'https://www.sanalakpos.com/servlet/est3Dgate',
        'finansbank' => 'https://www.fbwebpos.com/servlet/est3Dgate',
        'halkbank' => 'https://sanalpos.halkbank.com.tr/servlet/est3Dgate',
        'anadolubank' => 'https://anadolusanalpos.est.com.tr/servlet/est3Dgate',
        'activa' => 'https://activa.eway2pay.com/fim/est3dgate',
        'testAsseco' => 'https://entegrasyon.asseco-see.com.tr/fim/est3Dgate',
        'test' => 'https://testsecurepay.intesasanpaolocard.com/fim/est3dgate',
    ];

    protected $allowedCardBrands = [
        'visa' => 1,
        'mastercard' => 2
    ];

    public function getData()
    {
         $data = array();

         $data['clientid'] = $this->getClientId();
         $data['amount'] = $this->getAmount();
         $data['oid'] = $this->getOrderId();
         $data['okurl'] = $this->getReturnUrl();
         $data['failUrl'] = $this->getCancelUrl();
         $data['TranType'] = $this->transactionType;
         $data['currency'] = $this->getCurrency();
         $data['rnd'] = microtime();
         $data['storetype'] = '3d_pay_hosting';
         $data['hashAlgorithm'] = 'ver2';
         $data['lang'] = $this->getLang();
         $data['BillToName'] = $this->getBillToName();
         $data['BillToCompany'] = $this->getBillToCompany();
         $data['refreshtime'] = '5';

         $signatureArr = [
            $data['clientid'],
            $data['oid'],
            $data['amount'],
            $data['okurl'],
            $data['failUrl'],
            $data['TranType'],
            '',
            $data['rnd'],
            '',
            '',
            '',
            $data['currency'],
            $this->getStoreKey()
         ];

         foreach ($signatureArr as $key => $value) {
            $signatureArr[$key] = str_replace("|", "\\|", str_replace("\\", "\\\\", $value));
         }

         $stringToHash = join('|', $signatureArr);
         $calculatedHashValue = hash('sha512', $stringToHash);
         $data['hash'] = base64_encode (pack('H*',$calculatedHashValue));

         $data['encoding'] = 'utf-8';
         $data['module_name'] = 'Degriz_NestPay';

         return $data;
    }

    public function sendData($data)
    {
        return $this->response = new PaymentResponse($this, $data);
    }

}
