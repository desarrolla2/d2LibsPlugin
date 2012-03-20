<ul class="sf_admin_actions" style="margin-left:0;padding:0;">
    <?php foreach (array('new', 'edit') as $action): ?>
    <?php if ('new' == $action): ?>
            [?php if ($form->isNew()): ?]
    <?php else: ?>
                [?php else: ?]
    <?php endif; ?>

    <?php foreach ($this->configuration->getValue($action . '.actions') as $name => $params): ?>
    <?php if ('_delete' == $name): ?>
    <?php echo $this->addCredentialCondition('[?php echo $helper->linkToDelete($form->getObject(), ' . $this->asPhp($params) . ') ?]', $params) ?>

    <?php elseif ('_list' == $name): ?>
    <?php //echo $this->addCredentialCondition('[?php echo $helper->linkToList('.$this->asPhp($params).') ?]', $params) ?>

    <?php elseif ('_save' == $name): ?>
    <?php // echo $this->addCredentialCondition('[?php echo $helper->linkToSave($form->getObject(), ' . $this->asPhp($params) . ') ?]', $params) ?>
                                <a class="button" id="send" href="#">[?php echo __('Save', array(), 'sf_admin');?]</a>

    <?php elseif ('_save_and_add' == $name): ?>
    <?php // echo $this->addCredentialCondition('[?php echo $helper->linkToSaveAndAdd($form->getObject(), ' . $this->asPhp($params) . ') ?]', $params) ?>

    <?php else: ?>
                                        <li class="sf_admin_action_<?php echo $params['class_suffix'] ?>">
                                            [?php if (method_exists($helper, 'linkTo<?php echo $method = ucfirst(sfInflector::camelize($name)) ?>')): ?]
        <?php echo $this->addCredentialCondition('[?php echo $helper->linkTo' . $method . '($form->getObject(), ' . $this->asPhp($params) . ') ?]', $params) ?>

                                        [?php else: ?]
        <?php echo $this->addCredentialCondition($this->getLinkToAction($name, $params, true), $params) ?>

                                        [?php endif; ?]
                                    </li>
    <?php endif; ?>
    <?php endforeach; ?>
    <?php endforeach; ?>
    [?php endif; ?]
    <a class="button" href="[?php echo url_for('<?php echo $this->getModuleName(); ?>/index'); ?]">[?php echo __('back');?]</a>
</ul>
