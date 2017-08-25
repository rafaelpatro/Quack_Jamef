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

class Quack_Jamef_Model_Source_RegionalOfficeCode
    extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
    const AJU = '31';
    const BAR = '19';
    const BAU = '16';
    const BHZ = '02';
    const BNU = '09';
    const BSB = '28';
    const CCM = '26';
    const CPQ = '03';
    const CXJ = '22';
    const CWB = '04';
    const DIV = '38';
    const FES = '34';
    const FLN = '11';
    const FOR_CE = '32';
    const GYN = '24';
    const JPA = '36';
    const JDF = '23';
    const JOI = '08';
    const LDB = '10';
    const MAO = '25';
    const MCZ = '33';
    const MGF = '12';
    const POA = '05';
    const PSA = '27';
    const RAO = '18';
    const REC = '30';
    const RIO = '06';
    const SAO = '07';
    const SJK = '21';
    const SJP = '20';
    const SSA = '29';
    const UDI = '17';
    const VDC = '39';
    const VIX = '14';
    
    public function toOptionArray()
    {
        return array(
            array('value' => self::AJU, 'label' => 'Aracaju/SE'),
            array('value' => self::BAR, 'label' => 'Barueri/SP'),
            array('value' => self::BAU, 'label' => 'Bauru/SP'),
            array('value' => self::BHZ, 'label' => 'Belo Horizonte/MG'),
            array('value' => self::BNU, 'label' => 'Blumenau/SC'),
            array('value' => self::BSB, 'label' => 'Brasília/DF'),
            array('value' => self::CCM, 'label' => 'Criciúma/SC'),
            array('value' => self::CPQ, 'label' => 'Campinas/SP'),
            array('value' => self::CXJ, 'label' => 'Caxias do Sul/RS'),
            array('value' => self::CWB, 'label' => 'Curitiba/PR'),
            array('value' => self::DIV, 'label' => 'Divinópolis/MG'),
            array('value' => self::FES, 'label' => 'Feira de Santana/BA'),
            array('value' => self::FLN, 'label' => 'Florianópolis/SC'),
            array('value' => self::FOR_CE, 'label' => 'Fortaleza/CE'),
            array('value' => self::GYN, 'label' => 'Goiânia/GO'),
            array('value' => self::JPA, 'label' => 'João Pessoa/PB'),
            array('value' => self::JDF, 'label' => 'Juiz de Fora/MG'),
            array('value' => self::JOI, 'label' => 'Joinville/SC'),
            array('value' => self::LDB, 'label' => 'Londrina/PR'),
            array('value' => self::MAO, 'label' => 'Manaus/AM'),
            array('value' => self::MCZ, 'label' => 'Maceió/AL'),
            array('value' => self::MGF, 'label' => 'Maringá/PR'),
            array('value' => self::POA, 'label' => 'Porto Alegre/RS'),
            array('value' => self::PSA, 'label' => 'Pouso Alegre/MG'),
            array('value' => self::RAO, 'label' => 'Ribeirão Preto/SP'),
            array('value' => self::REC, 'label' => 'Recife/PE'),
            array('value' => self::RIO, 'label' => 'Rio de Janeiro/RJ'),
            array('value' => self::SAO, 'label' => 'São Paulo/SP'),
            array('value' => self::SJK, 'label' => 'São José dos Campos/SP'),
            array('value' => self::SJP, 'label' => 'São José do Rio Preto/SP'),
            array('value' => self::SSA, 'label' => 'Salvador/BA'),
            array('value' => self::UDI, 'label' => 'Uberlândia/MG'),
            array('value' => self::VDC, 'label' => 'Vitória da Conquista/BA'),
            array('value' => self::VIX, 'label' => 'Vitória/ES'),
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
