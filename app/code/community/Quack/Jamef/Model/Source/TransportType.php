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

class Quack_Jamef_Model_Source_TransportType
    extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
    const ROAD = 1;
    const AIR = 2;
    
    public function toOptionArray()
    {
        return array(
            array('value' => self::ROAD, 'label' => Mage::helper('quack_jamef')->__('Rodoviário')),
            array('value' => self::AIR, 'label' => Mage::helper('quack_jamef')->__('Aéreo')),
        );
    }
    
    /**
     * (non-PHPdoc)
     * @see Mage_Eav_Model_Entity_Attribute_Source_Interface::getAllOptions()
     */
    public function getAllOptions()
    {
        return self::toOptionArray();
    }
}
