<?php


namespace KassaCom\SDK\Model\Request\Payment;


use KassaCom\SDK\Model\PaymentMethods;
use KassaCom\SDK\Model\Request\AbstractRequestSerializer;

class ProcessPaymentSerializer extends AbstractRequestSerializer
{
    /**
     * @inheritDoc
     */
    public function getSerializedData()
    {
        /** @var ProcessPaymentRequest $processPaymentRequest */
        $processPaymentRequest = $this->request;
        $serializedData = [
            'token' => $processPaymentRequest->getToken(),
            'ip' => $processPaymentRequest->getIp(),
            'payment_method_data' => [],
        ];

        $paymentMethodDataItem = $processPaymentRequest->getPaymentMethodData();

        if ($paymentMethodDataItem) {
            $serializedData['payment_method_data']['type'] = $paymentMethodDataItem->getType();

            if ($paymentMethodDataItem->getType() === PaymentMethods::PAYMENT_METHOD_CARD) {
                $serializedData['payment_method_data']['card_number'] = $paymentMethodDataItem->getCardNumber();
                $serializedData['payment_method_data']['card_month'] = $paymentMethodDataItem->getCardMonth();
                $serializedData['payment_method_data']['card_year'] = $paymentMethodDataItem->getCardYear();
                $serializedData['payment_method_data']['card_security'] = $paymentMethodDataItem->getCardSecurity();
            }

            if ($paymentMethodDataItem->getAccount() !== null) {
                $serializedData['payment_method_data']['account'] = $paymentMethodDataItem->getAccount();
            }

            if ($paymentMethodDataItem->getCapture() !== null) {
                $serializedData['payment_method_data']['capture'] = $paymentMethodDataItem->getCapture();
            }
        }

        return $serializedData;
    }
}
