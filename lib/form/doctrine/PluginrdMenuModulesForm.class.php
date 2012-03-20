<?php

/**
 * PluginrdMenuModules form.
 *
 * @package    sinersis
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginrdMenuModulesForm extends BaserdMenuModulesForm {

    public function setup() {

        parent::setup();
        $this->setWidget('rd_main_menu_item_id', new sfWidgetFormInputHidden());
        $this->setDefault('rd_main_menu_item_id',sfContext::getInstance()->getRequest()->getParameter('id', 99));
    }

}
