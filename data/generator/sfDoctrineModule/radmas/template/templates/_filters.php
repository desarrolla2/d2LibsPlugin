<div class="sf_admin_filter">
    [?php if ($form->hasGlobalErrors()): ?]
    [?php echo $form->renderGlobalErrors() ?]
    [?php endif; ?]

    <form action="[?php echo url_for('<?php echo $this->getUrlForAction('collection') ?>', array('action' => 'filter')) ?]" method="post" id="form">
        <table cellspacing="0" class="tabla cebra">
            <tbody>
                [?php foreach ($configuration->getFormFilterFields($form) as $name => $field): ?]
                [?php if ((isset($form[$name]) && $form[$name]->isHidden()) || (!isset($form[$name]) && $field->isReal())) continue ?]
                [?php include_partial('<?php echo $this->getModuleName() ?>/filters_field', array(
                'name'       => $name,
                'attributes' => $field->getConfig('attributes', array()),
                'label'      => $field->getConfig('label'),
                'help'       => $field->getConfig('help'),
                'form'       => $form,
                'field'      => $field,
                'class'      => 'sf_admin_form_row sf_admin_'.rdUtils::normalize($field->getType()).' sf_admin_filter_field_'.$name,
                )) ?]
                [?php endforeach; ?]
            </tbody>
        </table>

        [?php echo $form->renderHiddenFields() ?]
        <div class="contLeft" style="margin-left:108px;">
            <a href="#" id="send" class="button">[?php echo __('Filter');?]</a>
            [?php echo link_to(__('Reset', array(), 'sf_admin'), '<?php echo $this->getUrlForAction('collection') ?>', array('action' => 'filter'), array('class' => 'button', 'query_string' => '_reset', 'method' => 'post')) ?]            
        </div>
        <div class="clear"></div>
    </form>
</div>