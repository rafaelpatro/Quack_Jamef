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

class Quack_Jamef_Model_Request_Tracking_Response_Result_Cte
{
    /**
     * Número do CTRC para rastreamento da carga
     * 
     * @var string
     */
    private $CTRC;
    
    /**
     * Número da nota fiscal
     * 
     * @var string
     */
    private $NF;
    
    /**
     * Razão Social do cliente de origem da mercadoria
     * 
     * @var string
     */
    private $CLIORIG;
    
    /**
     * Município de origem da coleta da mercadoria
     * 
     * @var string
     */
    private $MUNORIG;
    
    /**
     * Estado de origem da coleta da mercadoria
     * 
     * @var string
     */
    private $UFORIG;
    
    /**
     * Razão Social do cliente de destino da mercadoria
     * 
     * @var string
     */
    private $CLIDEST;
    
    /**
     * Município de destino para entrega da mercadoria
     * 
     * @var string
     */
    private $MUNDEST;
    
    /**
     * Estado de destino da entrega da mercadoria
     * 
     * @var string
     */
    private $UFDEST;
    
    /**
     * Link do arquivo tipo PDF para visualização do CTRC da mercadoria
     * 
     * @var string
     */
    private $LINKIMG;
    
    /**
     * @return string
     */
    public function getCTRC()
    {
        return $this->CTRC;
    }

    /**
     * @return string
     */
    public function getNf()
    {
        return $this->NF;
    }

    /**
     * @return string
     */
    public function getOrigName()
    {
        return $this->CLIORIG;
    }

    /**
     * @return string
     */
    public function getOrigCity()
    {
        return $this->MUNORIG;
    }

    /**
     * @return string
     */
    public function getOrigRegion()
    {
        return $this->UFORIG;
    }

    /**
     * @return string
     */
    public function getDestName()
    {
        return $this->CLIDEST;
    }

    /**
     * @return string
     */
    public function getDestCity()
    {
        return $this->MUNDEST;
    }

    /**
     * @return string
     */
    public function getDestRegion()
    {
        return $this->UFDEST;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->LINKIMG;
    }
}
