<?php

require_once dirname(__FILE__) . '/../lib/Baseweb_serverActions.class.php';

/**
 * web_server actions.
 * 
 * @package    rdLibsPlugin
 * @subpackage web_server
 * @author     Daniel González <daniel.gonzalez@freelancemadrid.es>
 * @version    SVN: $Id: actions.class.php 12534 2008-11-01 13:38:27Z Kris.Wallsmith $
 */
class web_serverActions extends Baseweb_serverActions {

    public function preExecute() {
        rdUtils::registerZend();
    }

    public function executeWsdl(sfWebRequest $request) {
        $autodiscover = new Zend_Soap_AutoDiscover();
        $autodiscover->setClass('PrimeFactors');
        $autodiscover->handle();
        die();
    }

    public function executeIndex(sfWebRequest $request) {
        $server = new Zend_Soap_Server();
        $server->setClass('PrimeFactors');
        $server->handle();
        die();
    }

}
