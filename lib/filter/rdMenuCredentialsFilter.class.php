<?php

/**
 * This file is part of the desarrolla2 proyect.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author      : daniel.gonzalez@freelancemadrid.es
 * @version     : SVN: $Id: setCpFilter 1.0  11-ago-2010 13:33:23
 *
 * @file        : rdGISFilter , UTF-8
 * @date        : 11-ago-2010 , 13:33:23
 */
class rdMenuCredentialsFilter extends sfFilter {

    public function execute($filterChain) {

        if ($this->isFirstCall()) {
            if ($this->context->getUser()->isAuthenticated()) {
                if (!rdMenuPlugin::getInstance()->hasPemission()) {
                    sfContext::getInstance()
                            ->getController()
                            ->forward('sfGuardAuth', 'secure');
                    //throw new Exception ('Credentials required');
                }
            }
            $filterChain->execute();
        }        
    }

}