<?php

/**
 * PluginSystemLogger form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage filter
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormFilterPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginSystemLoggerFormFilter extends BaseSystemLoggerFormFilter {

    public function buildQuery(array $values) {
        return parent::buildQuery($values)->orderBy('created_at DESC');
    }

}
