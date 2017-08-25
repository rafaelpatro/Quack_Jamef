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

class Quack_Jamef_Model_Request_Tracking_Response_Result_History_State
{
    /**
     * Status da entrega da mercadoria no momento da consulta
     * 
     * @var string
     */
    private $STATUS;
    
    /**
     * Data de atualização do status
     * 
     * @var string
     */
    private $DTATUALIZ;
    
    /**
     * Número do manifesto
     * 
     * @var string
     */
    private $MANIF;
    
    /**
     * Município no qual se localiza a mercadoria no momento da consulta
     * 
     * @var string
     */
    private $MUNLOCL;
    
    /**
     * Estado no qual se localiza a mercadoria no momento da consulta
     * 
     * @var string
     */
    private $UFLOCL;
    
    /**
     * Município de destino do manifesto
     * 
     * @var string
     */
    private $MUNDESTMANF;
    
    /**
     * Estado de destino do manifesto
     * 
     * @var string
     */
    private $UFDESTMANF;
    
    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->STATUS;
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return $this->DTATUALIZ;
    }

    /**
     * @return string
     */
    public function getManifest()
    {
        return $this->MANIF;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->MUNLOCL;
    }

    /**
     * @return string
     */
    public function getRegion()
    {
        return $this->UFLOCL;
    }

    /**
     * @return string
     */
    public function getDestCity()
    {
        return $this->MUNDESTMANF;
    }

    /**
     * @return string
     */
    public function getDestRegion()
    {
        return $this->UFDESTMANF;
    }
}
