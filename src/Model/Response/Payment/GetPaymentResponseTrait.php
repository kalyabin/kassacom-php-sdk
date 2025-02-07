<?php


namespace KassaCom\SDK\Model\Response\Payment;


use KassaCom\SDK\Model\Response\AbstractResponse;
use KassaCom\SDK\Model\Response\Item\MoneyItem;
use KassaCom\SDK\Model\Response\Item\OrderResponseItem;
use KassaCom\SDK\Model\Response\Item\PaymentMethodItem;
use KassaCom\SDK\Model\Response\Item\WalletResponseItem;

trait GetPaymentResponseTrait
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int|null
     */
    private $partnerPaymentId;

    /**
     * @var OrderResponseItem
     */
    private $order;

    /**
     * @var MoneyItem|null
     */
    private $payer;

    /**
     * @var MoneyItem|null
     */
    private $extra;

    /**
     * @var WalletResponseItem
     */
    private $wallet;

    /**
     * @var string
     */
    private $token;

    /**
     * @var \DateTime
     */
    private $createDate;

    /**
     * @var \DateTime
     */
    private $updateDate;

    /**
     * @var \DateTime|null
     */
    private $expireDate;

    /**
     * @var string|null
     */
    private $ip;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string|null
     */
    private $statusDescription;

    /**
     * @var PaymentMethodItem|null
     */
    private $paymentMethod;

    /**
     * @var array|null
     */
    private $customParameters;

    /**
     * @var bool|null
     */
    private $isTest;

    /**
     * @var boolean|null
     */
    private $availableFullRefund;

    /**
     * @var boolean|null
     */
    private $availablePartialRefund;

    /**
     * @var MoneyItem|null
     */
    private $availableForRefund;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getPartnerPaymentId()
    {
        return $this->partnerPaymentId;
    }

    /**
     * @param int|null $partnerPaymentId
     *
     * @return $this
     */
    public function setPartnerPaymentId($partnerPaymentId)
    {
        $this->partnerPaymentId = $partnerPaymentId;

        return $this;
    }

    /**
     * @return OrderResponseItem
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param OrderResponseItem $order
     *
     * @return $this
     */
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * @return MoneyItem|null
     */
    public function getPayer()
    {
        return $this->payer;
    }

    /**
     * @param MoneyItem|null $payer
     *
     * @return $this
     */
    public function setPayer($payer)
    {
        $this->payer = $payer;

        return $this;
    }

    /**
     * @return MoneyItem|null
     */
    public function getExtra()
    {
        return $this->extra;
    }

    /**
     * @param MoneyItem|null $extra
     *
     * @return $this
     */
    public function setExtra($extra)
    {
        $this->extra = $extra;

        return $this;
    }

    /**
     * @return WalletResponseItem
     */
    public function getWallet()
    {
        return $this->wallet;
    }

    /**
     * @param WalletResponseItem $wallet
     *
     * @return $this
     */
    public function setWallet($wallet)
    {
        $this->wallet = $wallet;

        return $this;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     *
     * @return $this
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * @param \DateTime $createDate
     *
     * @return $this
     */
    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getUpdateDate()
    {
        return $this->updateDate;
    }

    /**
     * @param \DateTime $updateDate
     *
     * @return $this
     */
    public function setUpdateDate($updateDate)
    {
        $this->updateDate = $updateDate;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getExpireDate()
    {
        return $this->expireDate;
    }

    /**
     * @param \DateTime|null $expireDate
     *
     * @return $this
     */
    public function setExpireDate($expireDate)
    {
        $this->expireDate = $expireDate;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param null|string $ip
     *
     * @return $this
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     *
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return PaymentMethodItem|null
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * @param PaymentMethodItem|null $paymentMethod
     *
     * @return $this
     */
    public function setPaymentMethod($paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getCustomParameters()
    {
        return $this->customParameters;
    }

    /**
     * @param array|null $customParameters
     *
     * @return $this
     */
    public function setCustomParameters($customParameters)
    {
        $this->customParameters = $customParameters;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getIsTest()
    {
        return $this->isTest;
    }

    /**
     * @param bool|null $isTest
     *
     * @return $this
     */
    public function setIsTest($isTest)
    {
        $this->isTest = $isTest;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getStatusDescription()
    {
        return $this->statusDescription;
    }

    /**
     * @return bool|null
     */
    public function getAvailableFullRefund()
    {
        return $this->availableFullRefund;
    }

    /**
     * @param bool|null $availableFullRefund
     *
     * @return $this
     */
    public function setAvailableFullRefund($availableFullRefund)
    {
        $this->availableFullRefund = $availableFullRefund;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getAvailablePartialRefund()
    {
        return $this->availablePartialRefund;
    }

    /**
     * @param bool|null $availablePartialRefund
     *
     * @return $this
     */
    public function setAvailablePartialRefund($availablePartialRefund)
    {
        $this->availablePartialRefund = $availablePartialRefund;

        return $this;
    }

    /**
     * @return MoneyItem|null
     */
    public function getAvailableForRefund()
    {
        return $this->availableForRefund;
    }

    /**
     * @param MoneyItem|null $availableForRefund
     *
     * @return $this
     */
    public function setAvailableForRefund($availableForRefund)
    {
        $this->availableForRefund = $availableForRefund;

        return $this;
    }

    /**
     * @param null|string $statusDescription
     *
     * @return $this
     */
    public function setStatusDescription($statusDescription)
    {
        $this->statusDescription = $statusDescription;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRequiredFields()
    {
        return [
            'id' => AbstractResponse::TYPE_INTEGER,
            'order' => OrderResponseItem::class,
            'wallet' => WalletResponseItem::class,
            'token' => AbstractResponse::TYPE_STRING,
            'create_date' => AbstractResponse::TYPE_DATE,
            'status' => AbstractResponse::TYPE_STRING,
        ];
    }

    /**
     * @inheritDoc
     */
    public function getOptionalFields()
    {
        return [
            'partner_payment_id' => AbstractResponse::TYPE_INTEGER,
            'expire_date' => AbstractResponse::TYPE_DATE,
            'ip' => AbstractResponse::TYPE_STRING,
            'status_description' => AbstractResponse::TYPE_STRING,
            'payment_method' => PaymentMethodItem::class,
            'custom_parameters' => AbstractResponse::TYPE_ARRAY,
            'update_date' => AbstractResponse::TYPE_DATE,
            'is_test' => AbstractResponse::TYPE_BOOLEAN,
            'available_full_refund' => self::TYPE_BOOLEAN,
            'available_partial_refund' => self::TYPE_BOOLEAN,
            'available_for_refund' => MoneyItem::class,
            'payer' => MoneyItem::class,
            'extra' => MoneyItem::class,
        ];
    }
}
