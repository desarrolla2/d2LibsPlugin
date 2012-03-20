<?php

/**
 * Ministerio de Politica Territorial
 * División de Sistemas de Información.
 *
 * @author      : daniel.gonzalez@mpt.es
 * @file        : sfCustomDateWidgetclass , UTF-8
 * @date        : Jul 6, 2010, 12:47:00 PM
 * @license     : All right reserved MPT - DSI
 * @version     : 1.0
 */
class sfCustomDateWidget extends sfWidgetFormInput {

    protected function configure($options = array(), $attributes = array()) {
        parent::configure($options, $attributes);
    }

    public function render($name, $value = null, $attributes = array(), $errors = array()) {
        if ($value) {
            //truquillo el DateTime solo acepta fechas separadas por "-"
            $value = preg_replace("/(\d+)\/(\d+)\/(\d+)/", "$1-$2-$3", $value);
            $date = new DateTime($value);
            $value = $date->format('d/m/Y');
//            $value = date_format(date_create($value), "d/m/Y");
        } else {
            $value = '';
        }
        return '<input type="text" value="' . $value . '" name="' . $name . '"  ' .
        ' id="' . $this->generateId($name) . '"  id="fecha" class="required fecha" ' .
        ' readonly="readonly"/><a href="#" class="clear_date" title="' .
        $this->generateId($name) . '" ><img src="/px/common/clean.png" ' .
        ' alt="clean"/></a>';
    }

}
