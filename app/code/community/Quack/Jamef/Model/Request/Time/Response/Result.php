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

class Quack_Jamef_Model_Request_Time_Response_Result
{
    /**
     * Data de Previsão de Entrega Máximo. Formato DD/MM/AA
     *
     * @var string
     */
    private $CDTMAX;
    
    /**
     * Data de Previsão de Entrega Mínimo. Formato DD/MM/AA
     *
     * @var string
     */
    private $CDTMIN;
    
    /**
     * Descrição da operação, sucesso ou erro.
     * Em caso de sucesso contém a String “ok”
     *
     * @var string
     */
    private $MSGERRO;
    
    /**
     * @return string
     */
    public function getDateMax()
    {
        return $this->CDTMAX;
    }

    /**
     * @return string
     */
    public function getDateMin()
    {
        return $this->CDTMIN;
    }
    
    /**
     * @return string
     */
    public function getMsg()
    {
        return $this->MSGERRO;
    }
}
