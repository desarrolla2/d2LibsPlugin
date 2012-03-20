<?php

/**
 * PluginrdMenuItems form.
 *
 * @package    sinersis
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginrdMenuItemsForm extends BaserdMenuItemsForm {


    public function setup() {

        parent::setup();

        $this->setWidget(
                'parent_id',
                new sfWidgetFormDoctrineChoice(array(
                    'model' => $this->getRelatedModelName('rdMenuItems'),
                    'table_method' => 'getParents',
                    'add_empty' => true
                )));
    }

}
