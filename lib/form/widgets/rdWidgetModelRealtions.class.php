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
class rdWidgetModelRelations extends sfWidgetFormInput {

    public function configure($options = array(), $attributes = array()) {

        $this->addOption('relation_class', '');
        $this->addOption('from_id', '');
        $this->addOption('from_class', '');
        $this->addOption('to_class', '');
        $this->addOption('permission_class', null);
        $this->addOption('permission_id', null);

        $this->addOption('template.html', '
            <div id="{div.id}">
                <input type="text" name="relation_for" id="input_{div.id}" />

                <ul id="ul_{div.id}" class="model_relation"></ul>
            </div>
        ');

        $this->addOption('template.javascript', '
          <script type="text/javascript">
            $(document).ready(function(){
                var {div.id}obj = new Radmas.PermissionManager(
                    {
                        component_id: "{div.id}",
                        relation_class: "{relation_class}",
                        from_class: "{from_class}",
                        from_id: "{from_id}",
                        to_class: "{to_class}",
                        permission_class: "{permission_class}",
                        permission_id: "{permission_id}",
                    }
                );

                {div.id}obj.initialize();

            });
          </script>
        ');
    }

    public function getJavascripts() {
        return array(
            '/rdLibsPlugin/js/model_relations.js',
            '/rdLibsPlugin/js/jquery.autocomplete.js'
        );
    }

    public function getStylesheets() {
        return array(
            '/rdLibsPlugin/css/jquery.autocomplete.css' => 'all',
            '/rdLibsPlugin/css/model_relations.css' => 'all'
        );
    }

    public function render($name, $value = null, $attributes = array(), $errors = array()) {

        // define main template variables
        $template_vars = array(
            '{div.id}' => $this->generateId($name),
            '{relation_class}' => $this->getOption('relation_class'),
            '{from_class}' => $this->getOption('from_class'),
            '{from_id}' => $this->getOption('from_id'),
            '{to_class}' => $this->getOption('to_class'),
            '{permission_class}' => $this->getOption('permission_class') != null ? $this->getOption('permission_class') : null,
            '{permission_id}' => $this->getOption('permission_id') ? $this->getOption('permission_id') : null
        );

        // merge templates and variables
        return strtr(
                $this->getOption('template.html') . $this->getOption('template.javascript'),
                $template_vars
        );
    }

}
