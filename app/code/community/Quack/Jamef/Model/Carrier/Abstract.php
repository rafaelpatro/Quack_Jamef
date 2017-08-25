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

abstract class Quack_Jamef_Model_Carrier_Abstract extends Mage_Shipping_Model_Carrier_Abstract
{
    const STATUS_FROM_TO = 'EM VIAGEM';
    const STATUS_DELIVERED = 'ENTREGA REALIZADA';
    const STATUS_DOC_ISSUED = 'EMISSÃO DE DOCUMENTO';
    const HEIGHT = 16;
    
    /**
     * List of fit itens
     *
     * @var array
     */
    protected $_fitItemHash = array();
    
    /**
     * Lista of estimated delivery time by method
     * 
     * @var array
     */
    protected $_deliveryTime = array();
    
    /**
     * Maximum of posting days of all itens in cart
     * 
     * @var int
     */
    protected $_postingDays = 0;
    
    /**
     * Raw rate request data
     *
     * @var Mage_Shipping_Model_Rate_Request|null
     */
    protected $_rawRequest = null;

    /**
     * Retrieve all visible items from request
     *
     * @param Mage_Shipping_Model_Rate_Request $request Mage request
     *
     * @return array
     */
    protected function _getRequestItems(Mage_Shipping_Model_Rate_Request $request)
    {
        $allItems = $request->getAllItems();
        $items = array();
    
        foreach ( $allItems as $item ) {
            if ( !$item->getParentItemId() ) {
                $items[] = $item;
            }
        }
    
        $items = $this->_loadBundleChildren($items);
    
        return $items;
    }
    
    /**
     * Filter visible and bundle children products.
     *
     * @param array $items Product Items
     *
     * @return array
     */
    protected function _loadBundleChildren($items)
    {
        $visibleAndBundleChildren = array();
        /* @var $item Mage_Sales_Model_Quote_Item */
        foreach ($items as $item) {
            $product = $item->getProduct();
            $isBundle = ($product->getTypeId() == Mage_Catalog_Model_Product_Type::TYPE_BUNDLE);
            if ($isBundle) {
                /* @var $child Mage_Sales_Model_Quote_Item */
                foreach ($item->getChildren() as $child) {
                    $visibleAndBundleChildren[] = $child;
                }
            } else {
                $visibleAndBundleChildren[] = $item;
            }
        }
        return $visibleAndBundleChildren;
    }

    /**
     * Retrieves the simple product attribute
     * 
     * @param Mage_Catalog_Model_Product $product Catalog Product
     * @param string $attribute Attribute Code
     * 
     * @return mixed(string|int|float)
     */
    protected function _getProductAttribute($product, $attribute)
    {
        $type = $product->getTypeInstance(true);
        if ($type->getProduct($product)->hasCustomOptions() &&
            ($simpleProductOption = $type->getProduct($product)->getCustomOption('simple_product'))
        ) {
            $simpleProduct = $simpleProductOption->getProduct($product);
            if ($simpleProduct) {
                return $this->_getProductAttribute($simpleProduct, $attribute);
            }
        }
        return $type->getProduct($product)->getData($attribute);
    }
    
    /**
     * Added a fit size for items in large quantities.
     * Means you can join items like two or more glasses, pots and vases.
     * The calc is applied only for height side.
     * Required attribute fit_size. Example:
     *
     *         code: fit_size
     *         type: varchar
     *
     * After you can set a fit size for all products and improve your sells
     *
     * @param Mage_Eav_Model_Entity_Abstract $item Order Item
     *
     * @return number
     */
    protected function _getFitHeight($item)
    {
        $product = $item->getProduct();
        $height  = $this->_getProductAttribute($product, 'volume_altura');
        $height  = ($height > 0) ? $height : self::HEIGHT;
        $fitSize = (float) $this->_getProductAttribute($product, 'fit_size');
    
        if ($item->getQty() > 1 && is_numeric($fitSize) && $fitSize > 0) {
            $totalSize = $height + ($fitSize * ($item->getQty() - 1));
            $height    = $totalSize / $item->getQty();
        }
    
        return $height;
    }
    
    /**
     * Saves a hash of different itens that can be perfectly fitted for further adjustment
     *
     * @param Mage_Eav_Model_Entity_Abstract $item Product Item
     *
     * @return bool
     */
    protected function _setFitItem($item)
    {
        $product = $item->getProduct();
        $height  = $this->_getProductAttribute($product, 'volume_altura');
        $width   = $this->_getProductAttribute($product, 'volume_largura');
        $length  = $this->_getProductAttribute($product, 'volume_comprimento');
        $fitSize = $this->_getProductAttribute($product, 'fit_size');
        $weight  = $product->getWeight();
        if (!(empty($fitSize) || empty($height) || empty($width) || empty($length))) {
            $itemKey = "{$height}_{$width}_{$length}_{$fitSize}_{$weight}";
            if (isset($this->_fitItemHash[$itemKey]) || $this->_fitItemHash[$itemKey] = 0) {
                $this->_fitItemHash[$itemKey]++;
            }
            return true;
        }
        return false;
    }
    
    /**
     * Returns the total saved for different fitted items
     *
     * @return int
     */
    protected function _getFitSaved()
    {
        $cubicWeight = 0;
        // Qty means how many different perfect fit items can be saved
        foreach ($this->_fitItemHash as $itemKey => $qty) {
            if ($qty > 1) {
                list($height,$width,$length,$fitSize,$weight) = explode('_', $itemKey);
                $height -= $fitSize;
                $cubicWeight += $height * $width * $length * ($qty-1);
            }
        }
        return $cubicWeight;
    }
    
    /**
     * Retrieves the customer tax/vat number based on the tracking code
     * and obviously the carrier code.
     * 
     * @param string $code
     * @return string
     */
    protected function _getCustomerTaxvatByTracking($code)
    {
        $taxvat = null;
        $track = Mage::getModel('sales/order_shipment_track');
        $collection = $track->getCollection()
            ->addAttributeToFilter('track_number', $code)
            ->addAttributeToFilter('carrier_code', $this->getCarrierCode());
        foreach ($collection as $track) {
            $order = Mage::getModel('sales/order')->load($track->getOrderId());
            $taxvat = $order->getCustomerTaxvat();
            break;
        }
        return $taxvat;
    }

    /**
     * Loads tracking progress details
     *
     * @param Quack_Jamef_Model_Request_Tracking_Response_Result_History_State $state History State Element
     * @param bool $isDelivered Delivery Flag
     *
     * @return array
     */
    protected function _getTrackingProgressDetails(Quack_Jamef_Model_Request_Tracking_Response_Result_History_State $state, $isDelivered=false)
    {
        $date = DateTime::createFromFormat('d/m/y H:i', $state->getDate());
        $details = array(
            'deliverydate'  => $date->format('Y-m-d'),
            'deliverytime'  => $date->format('H:i:s'),
            'status'        => $state->getStatus(),
        );
        if (!$isDelivered) {
            $msg = $state->getStatus();
            if ($state->getStatus() == self::STATUS_FROM_TO) {
                $msg .= " PARA {$state->getDestCity()}/{$state->getDestRegion()}";
            }
            $details['activity'] = $msg;
            $details['deliverylocation'] = "{$state->getCity()}/{$state->getRegion()}";
        }
        return $details;
    }
    
    /**
     * Loads progress data using the WSDL response
     *
     * @param Quack_Jamef_Model_Request_Tracking_Response $response Request response
     *
     * @return array
     */
    protected function _getTrackingProgress(Quack_Jamef_Model_Request_Tracking_Response $response)
    {
        $progress = array();
        $finalStep = array();
        $trackings = $response->getResult()->getHistory()->getTrackings();
        
        foreach ($trackings as $track) {
            $progress[] = $this->_getTrackingProgressDetails($track);
            if ($track->getStatus() == self::STATUS_DELIVERED) {
                $finalStep = $this->_getTrackingProgressDetails($track, true);
            }
        }
        
        $progress[] = $finalStep;
        return $progress;
    }
    
    /**
     * Retrieves the package size in m3
     * 
     * @param Mage_Shipping_Model_Rate_Request $request Mage request
     * 
     * @return float
     */
    public function getPackageSize(Mage_Shipping_Model_Rate_Request $request)
    {
        $volumeWeight = 0;

        $items = $this->_getRequestItems($request);

        foreach ($items as $item) {
            if ($_product = $item->getProduct()) {
                $_product->load($_product->getId());
    
                $itemAltura = $this->_getProductAttribute($_product, 'volume_altura');
                $itemLargura = $this->_getProductAttribute($_product, 'volume_largura');
                $itemComprimento = $this->_getProductAttribute($_product, 'volume_comprimento');
    
                $itemAltura = $this->_getFitHeight($item);
                $volumeWeight += ($itemAltura * $itemLargura * $itemComprimento * $item->getTotalQty());
    
                $this->_postingDays = max($this->_postingDays, (int) $this->_getProductAttribute($_product, 'posting_days'));
                $this->_setFitItem($item);
            }
        }

        $volumeWeight -= $this->_getFitSaved();
        $volumeWeight /= pow(10, 6);
        return $volumeWeight;
    }

    /**
     * @return Quack_Jamef_Helper_Data
     */
    public function getHelper()
    {
        return Mage::helper($this->getCarrierCode());
    }
    
    /**
     * @return string
     */
    public function getCity()
    {
        $city = $this->_rawRequest->getCity();
        return $this->getHelper()->formatCity($city);
    }

    /**
     * @return string
     */
    public function getRegion()
    {
        $regionId = $this->_rawRequest->getRegionId();
        $region = Mage::getSingleton('directory/region')->load($regionId);
        return $region->getCode();
    }
    
    /**
     * @return string
     */
    public function getPostingTime()
    {
        return (string)$this->getConfigData('posting_time');
    }
    
    /**
     * @return string
     */
    public function getPostingDate()
    {
        $increment = (int)$this->getConfigData('posting_days_increment');
        return $this->getHelper()->getSendDate($increment);
    }
    
    /**
     * @return Mage_Shipping_Model_Rate_Result_Method
     */
    public function getRateResultMethod()
    {
        $rate = Mage::getModel('shipping/rate_result_method');
        $rate->setCarrier($this->getCarrierCode());
        $rate->setCarrierTitle($this->getConfigData('title'));
        return $rate;
    }
    
    /**
     * @return Mage_Shipping_Model_Rate_Result_Error
     */
    public function getRateResultError()
    {
        $rate = Mage::getModel('shipping/rate_result_error');
        $rate->setCarrier($this->getCarrierCode());
        $rate->setErrorMessage($this->getConfigData('specificerrmsg'));
        return $rate;
    }
    
    /**
     * Retrieves the model/object for Shipping Price estimate request
     * 
     * @return Quack_Jamef_Model_Request_Price
     */
    public function getJamefRequestPrice()
    {
        $size = number_format($this->getPackageSize($this->_rawRequest), 4, '.', '');
        $weight = number_format($this->_rawRequest->getPackageWeight(), 2, '.', '');
        $amount = number_format($this->_rawRequest->getPackageValue(), 2, '.', '');
        $postcode = $this->getHelper()->formatZip($this->_rawRequest->getDestPostcode());
        
        $requestPrice = Mage::getModel('quack_jamef/request_price');
        $requestPrice->setMerchantVat( $this->getHelper()->getMerchantVat() )
            ->setMerchantCity($this->getCity())
            ->setMerchantRegion($this->getRegion())
            ->setWeight($weight)
            ->setOrderTotal($amount)
            ->setCubicWeight($size)
            ->setRegionalOfficeCode($this->getConfigData('regional_office'))
            ->setTaxpayer('N')
            ->setPostcode($postcode);
        return $requestPrice;
    }
    
    /**
     * Retrieves the model/object for Delivery Time estimate request
     * 
     * @return Quack_Jamef_Model_Request_Time
     */
    public function getJamefRequestTime()
    {
        $postcode = $this->getHelper()->formatZip($this->_rawRequest->getDestPostcode());
        
        $requestTime = Mage::getModel('quack_jamef/request_time');
        $requestTime->setMerchantVat( $this->getHelper()->getMerchantVat() )
            ->setMerchantCity($this->getCity())
            ->setMerchantRegion($this->getRegion())
            ->setPostcode($postcode)
            ->setTime($this->getPostingTime())
            ->setDate($this->getPostingDate());
        return $requestTime;
    }
    
    /**
     * Retrieves the model/object for Tracking request
     *
     * @return Quack_Jamef_Model_Request_Tracking
     */
    public function getJamefRequestTracking()
    {
        $request = Mage::getModel('quack_jamef/request_tracking');
        $request->setPayerTaxVat($this->getHelper()->getMerchantVat());
        return $request;
    }
    
    /**
     * @param string $method
     * @return string
     */
    public function getTitleByMethod($method)
    {
        $increment = max((int)$this->getConfigData('posting_days_increment'), $this->_postingDays);
        $deliveryTimeDays = $this->getDeliveryTime($method) + $increment;
        $title = Mage::getSingleton('quack_jamef/source_transportType')->getOptionText($method);
        $time = $this->getHelper()->__('Em média %s dias úteis', $deliveryTimeDays);
        $methodTitle = "{$title} - {$time}";
        return $methodTitle;
    }
    
    /**
     * @param string $method
     * @return int
     */
    public function getDeliveryTime($method)
    {
        return (int)$this->_deliveryTime[$method];
    }
    
    /**
     * @param string $method
     * @param int $value
     * @return Quack_Jamef_Model_Carrier_Abstract
     */
    public function setDeliveryTime($method, $value)
    {
        $this->_deliveryTime[$method] = $value;
        return $this;
    }
}