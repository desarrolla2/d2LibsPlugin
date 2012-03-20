<?php

/**
 * PluginrdMenuItems form.
 *
 * @package    sinersis
 * @subpackage filter
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormFilterPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginrdMenuItemsFormFilter extends BaserdMenuItemsFormFilter {

    public function buildQuery(array $values) {

        $query = parent::buildQuery($values);

        if (isset($values['parent_id'])) {
            $query->OrWhere('id = ?', array($values['parent_id']));
        }
        return $query;
    }

    public function setup() {

        parent::setup();

        $this->setWidget('parent_id',
                new sfWidgetFormDoctrineChoice(array(
                    'model' => $this->getRelatedModelName('rdMenuItems'),
                    'table_method' => 'getParents',
                    'add_empty' => true
                )));
    }

}
