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

class Quack_Jamef_Model_Request_Price
{
    const SUCCESS_MSG = 'Ok';
    
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
     * Tipo de produto a ser transportado
     * 
     * Para frete redoviário:
     *   000004 - Conforme Nota Fiscal
     *   000005 - Livros
     *   
     * Para frete aéreo:
     *   000010 - Alimentos industrializados
     *   000008 - Confecções
     *   000004 - Conforme Nota Fiscal
     *   000011 - Cosméticos/Material Cirúrgico
     *   000006 - Jornais/Revistas
     *   000005 - Livros
     *   000013 - Material Escolar
     *  
     * @var string
     */
    private $SEGPROD = '000004';
    
    /**
     * Quantidade de volumes
     * 
     * @var int
     */
    private $QTDVOL = 1;
    
    /**
     * Peso total da mercadoria, este campo deverá ser um
     * somatório de todas os pesos das mercadorias
     * compradas. Formato em KG e separação decimal por
     * ponto ".". Ex: 10.0 Quilos
     * 
     * @var string
     */
    private $PESO;
    
    /**
     * Valor total da mercadoria
     * 
     * @var string
     */
    private $VALMER;
    
    /**
     * Peso cubado em metros
     * Ex.: QUANTIDADE * ALTURA * COMPRIMENTO * LARGURA
     * 
     * @var string
     */
    private $METRO3;
    
    /**
     * CNPJ ou CPF do cliente destino
     * 
     * @var string
     */
    private $CNPJDES = '';
    
    /**
     * Filial da Jamef que irá efetuar a coleta da mercadoria
     * e emitir o CTRC do cliente.
     * 
     * @var string
     */
    private $FILCOT;
    
    /**
     * CEP de destino da mercadoria. Este campo é
     * obrigatório caso não seja informado Município
     * $MUNDES e Estado de destino $ESTDES.
     * 
     * @var string
     */
    private $CEPDES;
    
    /**
     * Contribuinte ICMS. Informar se o CNPJ / CPF
     * Destinatário é Contribuinte ICMS.
     *   S – Contribuinte ICMS
     *   N – Não Contribuinte ICMS
     * 
     * @var string
     */
    private $CONTRIB;
        
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
    public function getProductCategory()
    {
        return $this->SEGPROD;
    }

    /**
     * @return int
     */
    public function getQty()
    {
        return $this->QTDVOL;
    }

    /**
     * @return float
     */
    public function getWeight()
    {
        return $this->PESO;
    }

    /**
     * @return float
     */
    public function getOrderTotal()
    {
        return $this->VALMER;
    }

    /**
     * @return float
     */
    public function getCubicWeight()
    {
        return $this->METRO3;
    }

    /**
     * @return string
     */
    public function getTaxVat()
    {
        return $this->CNPJDES;
    }

    /**
     * @return string
     */
    public function getRegionalOfficeCode()
    {
        return $this->FILCOT;
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
    public function getTaxpayer()
    {
        return $this->CONTRIB;
    }

    /**
     * @param int $TIPTRA
     * @return Quack_Jamef_Model_Request_Price
     */
    public function setTransportType($TIPTRA)
    {
        $this->TIPTRA = $TIPTRA;
        return $this;
    }

    /**
     * @param string $CNPJCPF
     * @return Quack_Jamef_Model_Request_Price
     */
    public function setMerchantVat($CNPJCPF)
    {
        $this->CNPJCPF = $CNPJCPF;
        return $this;
    }

    /**
     * @param string $MUNORI
     * @return Quack_Jamef_Model_Request_Price
     */
    public function setMerchantCity($MUNORI)
    {
        $this->MUNORI = $MUNORI;
        return $this;
    }

    /**
     * @param string $ESTORI
     * @return Quack_Jamef_Model_Request_Price
     */
    public function setMerchantRegion($ESTORI)
    {
        $this->ESTORI = $ESTORI;
        return $this;
    }

    /**
     * @param string $MUNDES2
     * @return Quack_Jamef_Model_Request_Price
     */
    public function setCity($MUNDES2)
    {
        $this->MUNDES2 = $MUNDES2;
        return $this;
    }

    /**
     * @param string $ESTDES2
     * @return Quack_Jamef_Model_Request_Price
     */
    public function setRegion($ESTDES2)
    {
        $this->ESTDES2 = $ESTDES2;
        return $this;
    }

    /**
     * @param string $SEGPROD
     * @return Quack_Jamef_Model_Request_Price
     */
    public function setProductCategory($SEGPROD)
    {
        $this->SEGPROD = $SEGPROD;
        return $this;
    }

    /**
     * @param int $QTDVOL
     * @return Quack_Jamef_Model_Request_Price
     */
    public function setQty($QTDVOL)
    {
        $this->QTDVOL = $QTDVOL;
        return $this;
    }

    /**
     * @param string $PESO
     * @return Quack_Jamef_Model_Request_Price
     */
    public function setWeight($PESO)
    {
        $this->PESO = $PESO;
        return $this;
    }

    /**
     * @param string $VALMER
     * @return Quack_Jamef_Model_Request_Price
     */
    public function setOrderTotal($VALMER)
    {
        $this->VALMER = $VALMER;
        return $this;
    }

    /**
     * @param string $METRO3
     * @return Quack_Jamef_Model_Request_Price
     */
    public function setCubicWeight($METRO3)
    {
        $this->METRO3 = $METRO3;
        return $this;
    }

    /**
     * @param string $CNPJDES
     * @return Quack_Jamef_Model_Request_Price
     */
    public function setTaxVat($CNPJDES)
    {
        $this->CNPJDES = $CNPJDES;
        return $this;
    }

    /**
     * @param string $FILCOT
     * @return Quack_Jamef_Model_Request_Price
     */
    public function setRegionalOfficeCode($FILCOT)
    {
        $this->FILCOT = $FILCOT;
        return $this;
    }

    /**
     * @param string $CEPDES
     * @return Quack_Jamef_Model_Request_Price
     */
    public function setPostcode($CEPDES)
    {
        $this->CEPDES = $CEPDES;
        return $this;
    }

    /**
     * @param string $CONTRIB
     * @return Quack_Jamef_Model_Request_Price
     */
    public function setTaxpayer($CONTRIB)
    {
        $this->CONTRIB = $CONTRIB;
        return $this;
    }

    protected function _getCacheId()
    {
        $cacheCode = "QUACKJAMEF";
        $vat = $this->getMerchantVat();
        $zip = $this->getPostcode();
        $type = $this->getTransportType();
        $payer = $this->getTaxpayer();
        $weight = $this->getWeight();
        $cubic = $this->getCubicWeight();
        $id = "{$cacheCode}_{$vat}_{$zip}_{$type}_{$payer}_{$weight}_{$cubic}";
        $id = preg_replace("/[^[:alnum:]^_]/", "", $id);
        return $id;
    }

    protected function _roundUpToAny($n,$x=5) {
        return (ceil($n)%$x === 0) ? ceil($n) : round(($n+$x/2)/$x)*$x;
    }
    
    protected function _getCacheTags()
    {
        $cacheCode = "QUACKJAMEF";
        $weight = $this->getWeight();
        $weight = $this->_roundUpToAny((float)$weight);
        $cubicWeight = $this->getCubicWeight();
        
        $tags = array(
            $cacheCode,
            "JAMW0520_05",
            "VAT_{$this->getMerchantVat()}",
            "ZIP_{$this->getPostcode()}",
            "TYPE_{$this->getTransportType()}",
            "TAXPAYER_{$this->getTaxpayer()}",
            "WEIGHT_{$weight}",
            "CUBIC_{$cubicWeight}",
        );
        return $tags;
    }
    
    protected function _getCacheSave($response)
    {
        if (Mage::app()->useCache('quack_jamef') && $this->validate($response)) {
            $id = $this->_getCacheId();
            Mage::log("saving to cache: id = {$id}");
            try {
                Mage::app()->getCache()->save(serialize($response), $id, $this->_getCacheTags());
            } catch (Exception $e) {
                Mage::log("Cant save cache: {$e->getMessage()}");
            }
        }
    }
    
    protected function _getCacheLoad()
    {
        $response = null;
        if (Mage::app()->useCache('quack_jamef')) {
            $id = $this->_getCacheId();
            Mage::log("loading from cache: id = {$id}");
            $data = Mage::app()->getCache()->load($id);
            $response = unserialize($data);
            /*if (!$response) {
                $cacheIds = Mage::app()->getCache()->getIdsMatchingTags($this->_getCacheTags());
                foreach ($cacheIds as $cacheId) {
                    Mage::log("loading from cache: id = {$cacheId}");
                    if ($data = Mage::app()->getCache()->load($cacheId)) {
                        $response = unserialize($data);
                        break;
                    }
                }
            }*/
        }
        return $response;
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
     * @return Quack_Jamef_Model_Request_Price
     */
    public function setDefaultTimeout($value)
    {
        ini_set('default_socket_timeout', $value);
        return $this;
    }
    
    /**
     * @param string $url
     * @throws Exception
     * @return Quack_Jamef_Model_Request_Price_Response
     */
    public function requestShippingCost($url)
    {
        Mage::log("Quack_Jamef_Model_Request_Price::requestShippingCost");
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
                $response = $client->JAMW0520_05($this);
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
     * @param Quack_Jamef_Model_Request_Price_Response $response
     * @return mixed
     */
    public function validate($response)
    {
        $output = 0;
        try {
            if ($response instanceof Quack_Jamef_Model_Request_Price_Response) {
                $msg = $response->getResult()->getMsg();
                $output = preg_match('/'.self::SUCCESS_MSG.'/', $msg);
            }
        } catch (Exception $e) {
        }
        return $output;
    }
}
