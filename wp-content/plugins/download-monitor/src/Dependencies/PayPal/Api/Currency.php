<?php

namespace Never5\DownloadMonitor\Dependencies\PayPal\Api;

use Never5\DownloadMonitor\Dependencies\PayPal\Common\PayPalModel;
use Never5\DownloadMonitor\Dependencies\PayPal\Converter\FormatConverter;
use Never5\DownloadMonitor\Dependencies\PayPal\Validation\NumericValidator;

/**
 * Class Currency
 *
 * Base object for all financial value related fields (balance, payment due, etc.)
 *
 * @package Never5\DownloadMonitor\Dependencies\PayPal\Api
 *
 * @property string currency
 * @property string value
 */
class Currency extends PayPalModel
{
    /**
     * 3 letter currency code as defined by ISO 4217.
     *
     * @param string $currency
     * 
     * @return $this
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * 3 letter currency code as defined by ISO 4217.
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * amount up to N digit after the decimals separator as defined in ISO 4217 for the appropriate currency code.
     *
     * @param string|double $value
     * 
     * @return $this
     */
    public function setValue($value)
    {
        NumericValidator::validate($value, "Value");
        $value = FormatConverter::formatToPrice($value, $this->getCurrency());
        $this->value = $value;
        return $this;
    }

    /**
     * amount up to N digit after the decimals separator as defined in ISO 4217 for the appropriate currency code.
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

}
