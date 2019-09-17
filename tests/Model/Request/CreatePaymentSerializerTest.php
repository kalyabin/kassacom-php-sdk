<?php


namespace Tests\KassaCom\SDK\Model\Request;


use KassaCom\SDK\Model\PaymentMethods;
use KassaCom\SDK\Model\Request\Item\ItemsReceiptRequestItem;
use KassaCom\SDK\Model\Request\Item\OrderRequestItem;
use KassaCom\SDK\Model\Request\Item\ReceiptRequestItem;
use KassaCom\SDK\Model\Request\Item\SettingsRequestItem;
use KassaCom\SDK\Model\Request\Payment\CreatePaymentRequest;
use KassaCom\SDK\Model\Request\Payment\CreatePaymentSerializer;
use PHPUnit\Framework\TestCase;

class CreatePaymentSerializerTest extends TestCase
{
    const TYPICAL_DATE = '2017-12-25T00:07:19+00:00';

    const TYPICAL_EMAIL = 'test@test.test';

    public function testGetSerializedData()
    {
        $payment = $this->prepareValidPayment();
        $serializer = new CreatePaymentSerializer($payment);
        $serializedData = $serializer->getSerializedData();

        $this->assertArrayHasKey('partner_payment_id', $serializedData);
        $this->assertArrayHasKey('order', $serializedData);
        $this->assertArrayHasKey('settings', $serializedData);
        $this->assertArrayHasKey('custom_parameters', $serializedData);
        $this->assertArrayHasKey('receipt', $serializedData);

        $this->assertEquals($serializedData['partner_payment_id'], $payment->getPartnerPaymentId());

        $this->assertEquals($serializedData['order']['currency'], $payment->getOrder()->getCurrency());
        $this->assertEquals($serializedData['order']['amount'], $payment->getOrder()->getAmount());
        $this->assertEquals($serializedData['order']['description'], $payment->getOrder()->getDescription());

        $this->assertEquals($serializedData['settings']['project_id'], $payment->getSettings()->getProjectId());
        $this->assertEquals($serializedData['settings']['payment_method'], $payment->getSettings()->getPaymentMethod());
        $this->assertEquals($serializedData['settings']['success_url'], $payment->getSettings()->getSuccessUrl());
        $this->assertEquals($serializedData['settings']['fail_url'], $payment->getSettings()->getFailUrl());
        $this->assertEquals($serializedData['settings']['back_url'], $payment->getSettings()->getBackUrl());
        $this->assertEquals($serializedData['settings']['locale'], $payment->getSettings()->getLocale());
        $this->assertEquals($serializedData['settings']['expire_date'], self::TYPICAL_DATE);
        $this->assertEquals($serializedData['settings']['wallet_id'], $payment->getSettings()->getWalletId());
        $this->assertEquals($serializedData['settings']['hide_form_methods'], $payment->getSettings()->isHideFormMethods());
        $this->assertEquals($serializedData['settings']['hide_form_header'], $payment->getSettings()->isHideFormHeader());

        $this->assertEquals($serializedData['custom_parameters']['email'], self::TYPICAL_EMAIL);

        $this->assertEquals($serializedData['receipt']['email'], self::TYPICAL_EMAIL);
        $this->assertEquals($serializedData['receipt']['phone'], $payment->getReceipt()->getPhone());
        $this->assertEquals($serializedData['receipt']['place'], $payment->getReceipt()->getPlace());
        $this->assertArrayHasKey('items', $serializedData['receipt']);

        foreach ($payment->getReceipt()->getItems() as $index => $item) {
            $this->assertArrayHasKey($index, $serializedData['receipt']['items']);
            $itemData = $serializedData['receipt']['items'][$index];

            $this->assertEquals($itemData['name'], $item->getName());
            $this->assertEquals($itemData['price'], $item->getPrice());
            $this->assertInternalType(\PHPUnit_Framework_Constraint_IsType::TYPE_NUMERIC, $itemData['price']);
            $this->assertEquals($itemData['quantity'], $item->getQuantity());
            $this->assertInternalType(\PHPUnit_Framework_Constraint_IsType::TYPE_NUMERIC, $itemData['quantity']);
            $this->assertEquals($itemData['tax'], $item->getTax());
            $this->assertEquals($itemData['sum'], $item->getSum());
            $this->assertInternalType(\PHPUnit_Framework_Constraint_IsType::TYPE_NUMERIC, $itemData['sum']);
        }
    }

    public function testGetSerializedDataRequired()
    {
        $payment = $this->prepareValidPayment();
        $payment->setReceipt(null);
        $payment->setCustomParameters(null);
        $serializer = new CreatePaymentSerializer($payment);
        $serializedData = $serializer->getSerializedData();

        $this->assertArrayHasKey('order', $serializedData);
        $this->assertArrayHasKey('settings', $serializedData);
        $this->assertArrayNotHasKey('custom_parameters', $serializedData);
        $this->assertArrayNotHasKey('receipt', $serializedData);
    }

    public function testGetSerializedDataOrder()
    {
        $payment = $this->prepareValidPayment();
        $order = new OrderRequestItem();
        $order
            ->setAmount(101.1)
            ->setCurrency('USD')
            ->setDescription('Description');
        $payment->setOrder($order);
        $serializer = new CreatePaymentSerializer($payment);
        $serializedData = $serializer->getSerializedData();
        $this->assertArrayHasKey('order', $serializedData);
        $this->assertEquals($serializedData['order']['amount'], 101.1);
        $this->assertEquals($serializedData['order']['currency'], 'USD');
        $this->assertEquals($serializedData['order']['description'], 'Description');

        $order = new OrderRequestItem();
        $order
            ->setAmount(999999999999.99)
            ->setCurrency('RUB');
        $payment->setOrder($order);
        $serializer = new CreatePaymentSerializer($payment);
        $serializedData = $serializer->getSerializedData();
        $this->assertEquals($serializedData['order']['amount'], 999999999999.99);
        $this->assertEquals($serializedData['order']['currency'], 'RUB');
        $this->assertArrayNotHasKey('description', $serializedData['order']);
    }

    public function testGetSerializedDataSettings()
    {
        $payment = $this->prepareValidPayment();
        $settings = new SettingsRequestItem();
        $settings->setProjectId(1);
        $payment->setSettings($settings);
        $serializer = new CreatePaymentSerializer($payment);
        $serializedData = $serializer->getSerializedData();
        $this->assertEquals(1, $serializedData['settings']['project_id']);
        $this->assertEquals('ru', $serializedData['settings']['locale']);
        $this->assertArrayNotHasKey('payment_method', $serializedData['settings']);
        $this->assertArrayNotHasKey('success_url', $serializedData['settings']);
        $this->assertArrayNotHasKey('fail_url', $serializedData['settings']);
        $this->assertArrayNotHasKey('expire_date', $serializedData['settings']);
        $this->assertArrayNotHasKey('wallet_id', $serializedData['settings']);
        $this->assertArrayNotHasKey('hide_form_methods', $serializedData['settings']);
        $this->assertArrayNotHasKey('hide_form_header', $serializedData['settings']);

        $settings = new SettingsRequestItem();
        $settings
            ->setProjectId(2)
            ->setLocale(null);
        $payment->setSettings($settings);
        $serializer = new CreatePaymentSerializer($payment);
        $serializedData = $serializer->getSerializedData();
        $this->assertEquals(2, $serializedData['settings']['project_id']);
        $this->assertArrayNotHasKey('locale', $serializedData['settings']);
    }

    public function testGetSerializedDataCustomParameters()
    {
        $customParameters = [
            'key' => 'value',
            'key1' => 1,
            'key2' => -500,
            'key3' => 'Value value',
            'key4' => [],
            'key5' => '',
            'key6' => 0,
            'key7' => null,
            'key8' => ['1', 1, 2 => 3],
        ];
        $payment = $this->prepareValidPayment();
        $payment->setCustomParameters($customParameters);
        $serializer = new CreatePaymentSerializer($payment);
        $serializedData = $serializer->getSerializedData();
        $this->assertArrayHasKey('custom_parameters', $serializedData);

        foreach ($customParameters as $key => $customParameter) {
            if (empty($customParameter)) {
                $this->assertArrayNotHasKey($key, $serializedData['custom_parameters']);
                continue;
            }

            $this->assertArrayHasKey($key, $serializedData['custom_parameters']);
            $this->assertEquals($customParameter, $serializedData['custom_parameters'][$key]);
        }
    }

    public function testGetSerializedDataCustomReceipt()
    {
        $payment = $this->prepareValidPayment();
        $receipt = new ReceiptRequestItem();
        $payment->setReceipt($receipt);
        $serializer = new CreatePaymentSerializer($payment);
        $serializedData = $serializer->getSerializedData();
        $this->assertArrayHasKey('receipt', $serializedData);

        $payment = $this->prepareValidPayment();
        $receipt = new ReceiptRequestItem();
        $receiptItems = [];

        for ($i = 0; $i <= 1; $i++) {
            $receiptItems[] = $this->generateReceiptItem();
        }

        $receipt->setItems($receiptItems);
        $payment->setReceipt($receipt);
        $serializer = new CreatePaymentSerializer($payment);
        $serializedData = $serializer->getSerializedData();
        $this->assertArrayHasKey('items', $serializedData['receipt']);
        $this->assertArrayNotHasKey('email', $serializedData['receipt']);
        $this->assertArrayNotHasKey('phone', $serializedData['receipt']);
        $this->assertArrayNotHasKey('place', $serializedData['receipt']);
    }

    /**
     * @return CreatePaymentRequest
     */
    protected function prepareValidPayment()
    {
        $payment = new CreatePaymentRequest();

        $payment->setPartnerPaymentId('test_payment_1');

        $order = new OrderRequestItem();
        $order
            ->setAmount(0.99)
            ->setCurrency('RUB')
            ->setDescription('Very long text or not so long');

        $receiptItems = [];

        for ($i = 0; $i < 10; $i++) {
            $receiptItems[] = $this->generateReceiptItem();
        }

        $receipt = new ReceiptRequestItem();
        $receipt
            ->setPhone('7999999999')
            ->setEmail(self::TYPICAL_EMAIL)
            ->setItems($receiptItems)
            ->setPlace('http://test.test.test');

        $settings = new SettingsRequestItem();
        $settings
            ->setExpireDate(new \DateTime(self::TYPICAL_DATE))
            ->setFailUrl('http://site.site/?failCallback')
            ->setSuccessUrl('http://site.site/?successCallback')
            ->setBackUrl('http://site.site/?backUrl')
            ->setLocale('ru')
            ->setPaymentMethod(PaymentMethods::PAYMENT_METHOD_CARD)
            ->setProjectId(1)
            ->setWalletId(1)
            ->setHideFormHeader(true)
            ->setHideFormMethods(true);

        $payment
            ->setOrder($order)
            ->setReceipt($receipt)
            ->setSettings($settings)
            ->setCustomParameters([
                'email' => self::TYPICAL_EMAIL,
            ]);

        return $payment;
    }

    /**
     * @return ItemsReceiptRequestItem
     */
    protected function generateReceiptItem()
    {
        $itemsNames = [
            'Nice hat',
            'Продукт 1',
            'Space dust',
            'Sand',
            'Very long and strange product name',
            'Ring from dragon\'s eye',
        ];

        $receiptItem = new ItemsReceiptRequestItem();
        $receiptItem
            ->setName($itemsNames[mt_rand(0, count($itemsNames) - 1)])
            ->setPrice(mt_rand(0, 1000) * 1.1)
            ->setQuantity(mt_rand(0, 1000) * 1.1)
            ->setSum(mt_rand(0, 1000) * 1.1)
            ->setTax(ItemsReceiptRequestItem::TAX_NONE);

        return $receiptItem;
    }
}
