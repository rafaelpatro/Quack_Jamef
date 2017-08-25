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

class Quack_Jamef_Model_Request_Tracking
{
    /**
     * CNPJ do cliente que será responsável pelo pagamento
     * 
     * @var string
     */
    private $CIC_RESP_PGTO;
    
    /**
     * CNPJ do cliente de destino
     * 
     * @var string
     */
    private $CIC_DEST;
    
    /**
     * Número da nota fiscal do produto
     * 
     * @var string
     */
    private $NUM_NF;
    
    /**
     * Número de série da nota fiscal do produto
     * 
     * @var string
     */
    private $SERIE_NF;
    
    /**
     * Código da filial Jamef que coletará a mercadoria
     * 
     * @var string
     */
    private $COD_REGN_ORIG;
    
    /**
     * @return string
     */
    public function getPayerTaxVat()
    {
        return $this->CIC_RESP_PGTO;
    }

    /**
     * @return string
     */
    public function getDestTaxVat()
    {
        return $this->CIC_DEST;
    }

    /**
     * @return string
     */
    public function getNf()
    {
        return $this->NUM_NF;
    }

    /**
     * @return string
     */
    public function getNfSeries()
    {
        return $this->SERIE_NF;
    }

    /**
     * @return string
     */
    public function getRegionalOfficeCode()
    {
        return $this->COD_REGN_ORIG;
    }

    /**
     * @param string $CIC_RESP_PGTO
     */
    public function setPayerTaxVat($CIC_RESP_PGTO)
    {
        $this->CIC_RESP_PGTO = $CIC_RESP_PGTO;
        return $this;
    }

    /**
     * @param string $CIC_DEST
     */
    public function setDestTaxVat($CIC_DEST)
    {
        $this->CIC_DEST = $CIC_DEST;
        return $this;
    }

    /**
     * @param string $NUM_NF
     */
    public function setNf($NUM_NF)
    {
        $this->NUM_NF = $NUM_NF;
        return $this;
    }

    /**
     * @param string $SERIE_NF
     */
    public function setNfSeries($SERIE_NF)
    {
        $this->SERIE_NF = $SERIE_NF;
        return $this;
    }

    /**
     * @param string $COD_REGN_ORIG
     */
    public function setRegionalOfficeCode($COD_REGN_ORIG)
    {
        $this->COD_REGN_ORIG = $COD_REGN_ORIG;
        return $this;
    }
    
    /**
     * @param string $url
     * @throws Exception
     * @return Quack_Jamef_Model_Request_Tracking_Response
     */
    public function requestTracking($url)
    {
        Mage::log("Quack_Jamef_Model_Request_Tracking::requestTracking");
        Mage::log(print_r($this, true));
        $response = null;
        try {
            $client = new SoapClient($url, Mage::helper('quack_jamef')->getSoapOptions());
            $response = $client->RASTREAMENTO($this);
            if($response->getResult()->getError()) {
                throw new Exception("{$response->getResult()->getError()->getMessage()}");
            }
        } catch (Exception $e) {
            Mage::log($e->getMessage());
        }
        return $response;
    }
}
