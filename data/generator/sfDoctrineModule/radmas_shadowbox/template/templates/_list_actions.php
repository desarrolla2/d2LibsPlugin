<?php if ($actions = $this->configuration->getValue('list.actions')): ?>
<?php foreach ($actions as $name => $params): ?>
<?php if ('_new' == $name): ?>
            <a href="[?php  echo url_for( $this->getModuleName() . '/new', true);?]" class="button">[?php echo __('New', array(), '<?php echo $this->getI18nCatalogue() ?>'); ?]</a>
<?php else: ?>
                <li class="sf_admin_action_<?php echo $params['class_suffix'] ?>">
    <?php echo $this->addCredentialCondition($this->getLinkToAction($name, $params, false), $params) . "\n" ?>
            </li>
<?php endif; ?>
<?php endforeach; ?>
<?php endif; ?>
<a href="#" class="button shadowbox_close">[?php echo __('Exit'); ?]</a>