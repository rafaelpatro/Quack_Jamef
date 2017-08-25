<?php
/**
 * Este arquivo é parte do programa Quack Jamef
 *
 * Quack Jamef é um software livre; você pode redistribuí-lo e/ou
 * modificá-lo dentro dos termos da Licença Pública Geral GNU como
 * publicada pela Fundação do Software Livre (FSF); na versão 3 da
 * Licença, ou (na sua opinião) qualquer versão.
 *
 * Este programa é distribuído na esperança de que possa ser útil,
 * mas SEM NENHUMA GARANTIA; sem uma garantia implícita de ADEQUAÇÃO
 * a qualquer MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a
 * Licença Pública Geral GNU para maiores detalhes.
 *
 * Você deve ter recebido uma cópia da Licença Pública Geral GNU junto
 * com este programa, Se não, veja <http://www.gnu.org/licenses/>.
 *
 * @category   Quack
 * @package    Quack_Jamef
 * @author     Rafael Patro <rafaelpatro@gmail.com>
 * @copyright  Copyright (c) 2017 Rafael Patro (rafaelpatro@gmail.com)
 * @license    http://www.gnu.org/licenses/gpl.txt
 * @link       https://github.com/rafaelpatro/Quack_Jamef
 */

class Quack_Jamef_Model_Carrier_Shipping
    extends Quack_Jamef_Model_Carrier_Abstract
    implements Mage_Shipping_Model_Carrier_Interface
{
    protected $_code = 'quack_jamef';
    
    /**
     * (non-PHPdoc)
     * @see Mage_Shipping_Model_Carrier_Abstract::isTrackingAvailable()
     */
    public function isTrackingAvailable()
    {
        return true;
    }
    
    /**
     * (non-PHPdoc)
     * @see Mage_Shipping_Model_Carrier_Interface::getAllowedMethods()
     */
    public function getAllowedMethods()
    {
        $methods = array();
        $options = Mage::getSingleton('quack_jamef/source_transportType')->getAllOptions();
        foreach ($options as $option) {
            $methods["{$this->getCarrierCode()}_{$option['value']}"] = $option['label'];
        }
        return $methods;
        
    }

    /**
     * (non-PHPdoc)
     * @see Mage_Shipping_Model_Carrier_Abstract::proccessAdditionalValidation()
     */
    public function proccessAdditionalValidation(Mage_Shipping_Model_Rate_Request $request)
    {
        Mage::log("Quack_Jamef_Model_Carrier_Shipping::proccessAdditionalValidation");
        $this->_rawRequest = clone $request;
        
        $postcode = $this->getHelper()->formatZip($request->getDestPostcode());
        if (!$this->getHelper()->validateZip($postcode)) {
            return false;
        }
        if (!$this->getHelper()->validateAllowedZips($postcode)) {
            return false;
        }
        
        try {
            $timeRequest = $this->getJamefRequestTime();
            $allowedMethods = explode(',', $this->getConfigData('allowed_methods'));
            
            foreach ($allowedMethods as $method) {
                $timeRequest->setTransportType($method);
                $response = $timeRequest->requestShippingTime($this->getConfigData('url'));
                if (!$timeRequest->validate($response)) {
                    throw new Exception(print_r($response, true));
                }
                
                if ($response instanceof Quack_Jamef_Model_Request_Time_Response) {
                    $deliveryTime = $response->getDeliveryTime($timeRequest->getDate());
                    if ($deliveryTime > 0) {
                        $this->setDeliveryTime($method, $deliveryTime);
                    }
                }
            }
            
            if (empty($this->_deliveryTime)) {
                throw new Exception("Empty delivery time");
            }
        } catch (Exception $e) {
            Mage::logException(Mage::exception('Mage_Core', $e->getMessage()));
            return false;
        }
        
        return $this;
    }
    
    /**
     * (non-PHPdoc)
     * @see Mage_Shipping_Model_Carrier_Abstract::collectRates()
     */
    public function collectRates(Mage_Shipping_Model_Rate_Request $request)
    {
        Mage::log("Quack_Jamef_Model_Carrier_Shipping::collectRates");
        $rateResult = Mage::getModel('shipping/rate_result');
        try {
            $priceRequest = $this->getJamefRequestPrice();
            $allowedMethods = explode(',', $this->getConfigData('allowed_methods'));
            
            foreach ($allowedMethods as $method) {
                $priceRequest->setTransportType($method);
                $response = $priceRequest->requestShippingCost($this->getConfigData('url'));
                if (!$priceRequest->validate($response)) {
                    throw new Exception(print_r($response, true));
                }
                
                $shippingCost = $response->getShippingCost();
                if ($shippingCost > 0) {
                    $shippingPrice = $this->getMethodPrice($shippingCost, $method);
                    $rate = $this->getRateResultMethod();
                    $rate->setMethod("{$this->getCarrierCode()}_{$method}");
                    $rate->setMethodTitle($this->getTitleByMethod($method));
                    $rate->setCost($shippingCost);
                    $rate->setPrice($shippingPrice);
                    $rateResult->append($rate);
                }
            }
            //$this->_updateFreeMethodQuote($request);
        } catch (Exception $e) {
            Mage::logException(Mage::exception('Mage_Core', $e->getMessage()));
            $rate = $this->getRateResultError();
            $rateResult->append($rate);
        }
        return $rateResult;
    }

    /**
     * Get Tracking Info
     *
     * @param mixed $trackingCodes Tracking
     *
     * @return mixed
     */
    public function getTrackingInfo($trackingCodes)
    {
        $result = Mage::getModel('shipping/tracking_result');
        foreach ((array) $trackingCodes as $code) {
            $error = Mage::getModel('shipping/tracking_result_error');
            $error->setTracking($code);
            $error->setCarrier($this->getCarrierCode());
            $error->setCarrierTitle($this->getConfigData('title'));
            
            $taxvat = $this->_getCustomerTaxvatByTracking($code);
            $request = $this->getJamefRequestTracking();
            $request->setNf($code)->setDestTaxVat($taxvat);
            $response = $request->requestTracking($this->getConfigData('url_tracking'));
            
            if ($err = $response->getResult()->getError()) {
                $error->setErrorMessage($err->getMessage());
                $result->append($error);
                continue;
            }
            
            $progress = $this->_getTrackingProgress($response);
            if (!empty($progress)) {
                $track = array_pop($progress);
                $track['progressdetail'] = $progress;
                $status = Mage::getModel('shipping/tracking_result_status');
                $status->setTracking($code);
                $status->setCarrier($this->getCarrierCode());
                $status->setCarrierTitle($this->getConfigData('title'));
                $status->addData($track);
                $result->append($status);
                continue;
            } else {
                $result->append($error);
                continue;
            }
        }
        
        if ($trackings = $result->getAllTrackings()) {
            return $trackings[0];
        }
        
        return false;
    }
    
}
