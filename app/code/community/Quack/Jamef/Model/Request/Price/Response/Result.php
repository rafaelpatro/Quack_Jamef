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

class Quack_Jamef_Model_Request_Price_Response_Result
{
    /**
     * Array de dados que contém todos os componentes do valor do
     * Frete. São exemplos de Componentes Pedagio, GRIS, TAS, Taxa
     * (até 100 KG), Frete Peso (FM), Frete Valor, TRT, Frete Peso (FP),
     * Taxa (acima 100 KG), TF-TOTAL DO FRETE.
     *
     * @var Quack_Jamef_Model_Request_Price_Response_Result_Shipping
     */
    private $VALFRE;

    /**
     * Descrição da operação, sucesso ou erro.
     * Em caso de sucesso contém a String “ok”
     *
     * @var string
     */
    private $MSGERRO;
    
    /**
     * @return Quack_Jamef_Model_Request_Price_Response_Result_Shipping
     */
    public function getShipping()
    {
        return $this->VALFRE;
    }

    /**
     * @return string
     */
    public function getMsg()
    {
        return $this->MSGERRO;
    }
}
