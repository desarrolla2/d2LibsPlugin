<?php

require_once dirname(__FILE__) . '/../lib/system_messagesGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/system_messagesGeneratorHelper.class.php';

/*
 * This file is part of the desarrolla2 proyect.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package    sinersis
 * @subpackage system_messages
 * @author      : Daniel González <daniel.gonzalez@freelancemadrid.es>
 * @version     : SVN: $Id: ${name} 1.0  ${date} ${time}
 *
 * @file        : ${file} , UTF-8
 * @date        : ${date} ${time}
 */

class system_messagesActions extends autoSystem_messagesActions {
    
    
   public function executeHelp1(){
       
   }
   
   public function executeTruncate(){
       $q = Doctrine_Query::create()
               ->delete('SystemLogger')
               ->execute();
       $this->getUser()->setFlash('notice', 'se han eliminado todos los registros');
       $this->redirect('system_messages/index');
   }
   
}
