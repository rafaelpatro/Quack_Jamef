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

class Quack_Jamef_Model_Request_Time
{
    const SUCCESS_MSG = 'OK';
    
    /**
     * Tipo de transporte
     *   1: Rodoviário
     *   2: Aéreo
     *   
     * @var int
     */
    private $TIPTRA;
    
    /**
     * CNPJ do pagador do frete
     * 
     * @var string
     */
    private $CNPJCPF;
    
    /**
     * Município de origem da mercadoria
     * 
     * @var string
     */
    private $MUNORI;
    
    /**
     * Sigla do estado de origem
     * 
     * @var string
     */
    private $ESTORI;
    
    /**
     * Nome do município de destino da mercadoria.
     * Maiúsculo e sem acentuação.
     * 
     * @var string
     */
    private $MUNDES2;
    
    /**
     * Sigla do estado de destino
     * 
     * @var string
     */
    private $ESTDES2;
        
    /**
     * CEP de destino da mercadoria. Este campo é
     * obrigatório caso não seja informado Município
     * $MUNDES e Estado de destino $ESTDES.
     * 
     * @var string
     */
    private $CEPDES;
    
    /**
     * Data da Coleta da Mercadoria. Formato DD/MM/AAAA
     * 
     * @var string
     */
    private $CDATINI;

    /**
     * Hora da Coleta da Mercadoria. Formato HH:MM
     *
     * @var string
     */
    private $CHORINI;
    
    /**
     * @return int
     */
    public function getTransportType()
    {
        return $this->TIPTRA;
    }

    /**
     * @return string
     */
    public function getMerchantVat()
    {
        return $this->CNPJCPF;
    }

    /**
     * @return string
     */
    public function getMerchantCity()
    {
        return $this->MUNORI;
    }

    /**
     * @return string
     */
    public function getMerchantRegion()
    {
        return $this->ESTORI;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->MUNDES2;
    }

    /**
     * @return string
     */
    public function getRegion()
    {
        return $this->ESTDES2;
    }

    /**
     * @return string
     */
    public function getPostcode()
    {
        return $this->CEPDES;
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return $this->CDATINI;
    }

    /**
     * @return string
     */
    public function getTime()
    {
        return $this->CHORINI;
    }
    
    /**
     * @param int $TIPTRA
     * @return Quack_Jamef_Model_Request_Time
     */
    public function setTransportType($TIPTRA)
    {
        $this->TIPTRA = $TIPTRA;
        return $this;
    }

    /**
     * @param string $CNPJCPF
     * @return Quack_Jamef_Model_Request_Time
     */
    public function setMerchantVat($CNPJCPF)
    {
        $this->CNPJCPF = $CNPJCPF;
        return $this;
    }

    /**
     * @param string $MUNORI
     * @return Quack_Jamef_Model_Request_Time
     */
    public function setMerchantCity($MUNORI)
    {
        $this->MUNORI = $MUNORI;
        return $this;
    }

    /**
     * @param string $ESTORI
     * @return Quack_Jamef_Model_Request_Time
     */
    public function setMerchantRegion($ESTORI)
    {
        $this->ESTORI = $ESTORI;
        return $this;
    }

    /**
     * @param string $MUNDES2
     * @return Quack_Jamef_Model_Request_Time
     */
    public function setCity($MUNDES2)
    {
        $this->MUNDES2 = $MUNDES2;
        return $this;
    }

    /**
     * @param string $ESTDES2
     * @return Quack_Jamef_Model_Request_Time
     */
    public function setRegion($ESTDES2)
    {
        $this->ESTDES2 = $ESTDES2;
        return $this;
    }

    /**
     * @param string $CEPDES
     * @return Quack_Jamef_Model_Request_Time
     */
    public function setPostcode($CEPDES)
    {
        $this->CEPDES = $CEPDES;
        return $this;
    }

    /**
     * @param string $CDATINI
     * @return Quack_Jamef_Model_Request_Time
     */
    public function setDate($CDATINI)
    {
        $this->CDATINI = $CDATINI;
        return $this;
    }

    /**
     * @param string $CHORINI
     * @return Quack_Jamef_Model_Request_Time
     */
    public function setTime($CHORINI)
    {
        $this->CHORINI = $CHORINI;
        return $this;
    }
    
    protected function _getCacheId()
    {
        $cacheCode = "QUACKJAMEF";
        $vat = $this->getMerchantVat();
        $zip = $this->getPostcode();
        $type = $this->getTransportType();
        $date = $this->getDate();
        $id = "{$cacheCode}_{$vat}_{$zip}_{$type}_{$date}";
        $id = preg_replace("/[^[:alnum:]^_]/", "", $id);
        return $id;
    }
    
    protected function _getCacheTags()
    {
        $cacheCode = "QUACKJAMEF";
        $requestName = "JAMW0520_04";
        $vat = $this->getMerchantVat();
        $zip = $this->getPostcode();
        $type = $this->getTransportType();
        $tags = array($cacheCode, $requestName, "VAT_{$vat}", "ZIP_{$zip}", "TYPE_{$type}");
        return $tags;
    }
    
    protected function _getCacheLoad()
    {
        $response = null;
        if (Mage::app()->useCache('quack_jamef')) {
            $id = $this->_getCacheId();
            Mage::log("loading from cache: id = {$id}");
            $data = Mage::app()->getCache()->load($id);
            $response = unserialize($data);
            if (!$response) {
                $cacheIds = Mage::app()->getCache()->getIdsMatchingTags($this->_getCacheTags());
                foreach ($cacheIds as $cacheId) {
                    Mage::log("loading from cache: id = {$cacheId}");
                    if ($data = Mage::app()->getCache()->load($cacheId)) {
                        $response = unserialize($data);
                        list(,,,,$cachedDate) = explode('_', $cacheId);
                        $cachedDateTime = DateTime::createFromFormat('dmY', $cachedDate);
                        $this->setDate($cachedDateTime->format('d/m/Y'));
                        Mage::log("reset date: {$this->getDate()}");
                        break;
                    }
                }
            }
        }
        return $response;
    }
    
    protected function _getCacheSave($response)
    {
        if (Mage::app()->useCache('quack_jamef') && $this->validate($response)) {
            $id = $this->_getCacheId();
            Mage::log("saving to cache: id = {$id}");
            try {
                Mage::app()->getCache()->save(serialize($response), $id, $this->_getCacheTags());
            } catch(Exception $e) {
                Mage::log("Cant save cache: {$e->getMessage()}");
            }
        }
    }
    
    /**
     * @return int
     */
    public function getConfigTimeout()
    {
        return Mage::getStoreConfig('carriers/quack_jamef/timeout');
    }
    
    /**
     * @return int
     */
    public function getDefaultTimeout()
    {
        return ini_get('default_socket_timeout');
    }
    
    /**
     * @return Quack_Jamef_Model_Request_Time
     */
    public function setDefaultTimeout($value)
    {
        ini_set('default_socket_timeout', $value);
        return $this;
    }
    
    /**
     * @param string $url
     * @throws Exception
     * @return Quack_Jamef_Model_Request_Time_Response
     */
    public function requestShippingTime($url)
    {
        Mage::log("Quack_Jamef_Model_Request_Time::requestShippingTime");
        $response = null;
        
        if ($response = $this->_getCacheLoad()) {
            Mage::log("cache hit");
        } else {
            // Timeout update for socket connections
            $configTimeout = $this->getConfigTimeout();
            $defaultTimeout = $this->getDefaultTimeout();
            if (is_numeric($configTimeout)) {
                $this->setDefaultTimeout($configTimeout);
            }
            
            try {
                $options = Mage::helper('quack_jamef')->getSoapOptions();
                $options['connection_timeout'] = $configTimeout;
                $client = new SoapClient($url, $options);
                $response = $client->JAMW0520_04($this);
                if(!$this->validate($response)) {
                    throw new Exception("{$response->getResult()->getMsg()}");
                }
            } catch (Exception $e) {
                Mage::log($e->getMessage());
            }
            // Timeout restore for socket connections
            $this->setDefaultTimeout($defaultTimeout);
            
            $this->_getCacheSave($response);
        }
        
        return $response;
    }

    /**
     *
     * @param Quack_Jamef_Model_Request_Time_Response $response
     * @return mixed
     */
    public function validate($response)
    {
        $output = 0;
        try {
            if ($response instanceof Quack_Jamef_Model_Request_Time_Response) {
                $msg = $response->getResult()->getMsg();
                $output = preg_match('/'.self::SUCCESS_MSG.'/', $msg);
            }
        } catch (Exception $e) {
        }
        return $output;
    }
}
