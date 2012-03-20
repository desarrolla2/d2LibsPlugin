<?php

/**
 * This file is part of the desarrolla2 proyect.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package     : sinersis
 * @author      : daniel.gonzalez@freelancemadrid.es
 * @version     : SVN: $Id: rdXliffI18nHandler.class 1.0  24-ago-2010 15:40:04
 *
 * @file        : sfGuardUserLoggerListener , UTF-8
 * @date        : 25 Oct 2011
 */

class sfGuardUserLoggerListener extends Doctrine_Record_Listener
{
    public function preInsert(Doctrine_Event $event)
    {
        $this->setSfGuardUser($event);
    }

    public function preUpdate(Doctrine_Event $event)
    {
        $this->setSfGuardUser($event);
    }
    
    private function setSfGuardUser(Doctrine_Event $event){
        if (sfContext::hasInstance()){
            if($user = sfContext::getInstance()->getUser()){
                if($id = $user->getId()){
                    $event->getInvoker()->sf_guard_user_id = $id;
                }
            }            
        }else{
            $event->getInvoker()->sf_guard_user_id = null;
        }       
    }
}