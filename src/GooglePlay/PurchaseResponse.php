<?php

namespace ReceiptValidator\GooglePlay;

use Carbon\Carbon;

/**
 * Class PurchaseResponse.
 */
class PurchaseResponse extends AbstractResponse
{
    /**
     * @var \Google_Service_AndroidPublisher_ProductPurchase
     */
    protected $response;

    protected $developerPayload = [];

    public function __construct($response)
    {
        parent::__construct($response);
        $this->developerPayload = json_decode($this->response->developerPayload, true);
    }

    /**
     * @return int
     */
    public function getConsumptionState()
    {
        return $this->response->consumptionState;
    }

    /**
     * @return string
     */
    public function getPurchaseTimeMillis()
    {
        return $this->response->purchaseTimeMillis;
    }
    
    /**
     * @return Carbon|null
     */
    public function getPurchaseTimeDate(): ?Carbon
    {
        if (null !== $this->response->purchaseTimeMillis) {
            return Carbon::createFromTimestampUTC(
                (int) round((int) $this->response->purchaseTimeMillis / 1000)
            );
        }
        
        return null;
    }

    public function getDeveloperPayload()
    {
        return $this->developerPayload;
    }

    /**
     * @param string $key
     *
     * @return string
     */
    public function getDeveloperPayloadElement($key)
    {
        return (isset($this->developerPayload[$key])) ? $this->developerPayload[$key] : '';
    }

    /**
     * @return string
     */
    public function getPurchaseState()
    {
        return $this->response->purchaseState;
    }
}
