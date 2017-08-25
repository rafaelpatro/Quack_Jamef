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

class Quack_Jamef_Helper_Data extends Mage_Core_Helper_Abstract
{
    const CONFIG_PATH_ALLOWED_ZIPS = 'carriers/quack_jamef/allowed_zips';
    
    /**
     * @param number $increment
     * @return string
     */
    public function getSendDate($increment=0)
    {
        $now = new DateTime();
        $now->add(new DateInterval("P{$increment}D"));
        return $now->format('d/m/Y');
    }
    
    public function getMerchantVat()
    {
        $vat = Mage::getStoreConfig('general/store_information/merchant_vat_number');
        $vat = preg_replace('/[^\d]/', '', $vat);
        return $vat;
    }

    public function validateZip($postcode)
    {
        $output = preg_match('/^[\d]{8}$/', $postcode);
        return ($output != 0);
    }
    
    public function formatZip($postcode, $length=8)
    {
        $postcode = preg_replace('/[^\d]/', '', $postcode);
        $postcode = str_pad($postcode, $length, '0', STR_PAD_LEFT);
        return $postcode;
    }
    
    public function formatCity($city)
    {
        $city = $this->strtoascii($city);
        $city = strtoupper($city);
        return $city;
    }
    
    public function getSoapOptions()
    {
        return array(
            'classmap' => array(
                'JAMW0520_05' => 'Quack_Jamef_Model_Request_Price',
                'JAMW0520_05RESPONSE' => 'Quack_Jamef_Model_Request_Price_Response',
                'RESJAMW0520' => 'Quack_Jamef_Model_Request_Price_Response_Result',
                'ARRAYOFAVALFRE' => 'Quack_Jamef_Model_Request_Price_Response_Result_Shipping',
                'AVALFRE' => 'Quack_Jamef_Model_Request_Price_Response_Result_Shipping_Rate',
                'JAMW0520_04' => 'Quack_Jamef_Model_Request_Time',
                'JAMW0520_04RESPONSE' => 'Quack_Jamef_Model_Request_Time_Response',
                'PRVJAMW0520' => 'Quack_Jamef_Model_Request_Time_Response_Result',
                'RASTREAMENTO' => 'Quack_Jamef_Model_Request_Tracking',
                'RASTREAMENTORESPONSE' => 'Quack_Jamef_Model_Request_Tracking_Response',
                'RETORNO' => 'Quack_Jamef_Model_Request_Tracking_Response_Result',
                'CONHECIMENTO' => 'Quack_Jamef_Model_Request_Tracking_Response_Result_Cte',
                'ERRO' => 'Quack_Jamef_Model_Request_Tracking_Response_Result_Error',
                'ARRAYOFPOSICAO' => 'Quack_Jamef_Model_Request_Tracking_Response_Result_History',
                'POSICAO' => 'Quack_Jamef_Model_Request_Tracking_Response_Result_History_State',
            )
        );
    }

    public function strtoascii($str)
    {
        //setlocale(LC_ALL, 'pt_BR.utf8');
        return iconv('UTF-8', 'ASCII//TRANSLIT', $str);
    }
    
    public function validateAllowedZips($postcode)
    {
        $output = true;
    
        if ($allowedZips = Mage::getStoreConfig(self::CONFIG_PATH_ALLOWED_ZIPS)) {
            $allowedZips = unserialize($allowedZips);
    
            if (is_array($allowedZips) && !empty($allowedZips)) {
                $output = false;
    
                foreach ($allowedZips as $zip) {
                    $isValid = ((int)$zip['from'] <= (int)$postcode);
                    $isValid &= ((int)$zip['to'] >= (int)$postcode);
                    if ($isValid) {
                        $output = true;
                        break;
                    }
                }
            }
        }
        return $output;
    }
    
}
