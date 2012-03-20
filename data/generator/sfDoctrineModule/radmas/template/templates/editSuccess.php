<div id="sf_admin_container">
    <div class="inner">
        <h2 class="edit">[?php echo <?php echo $this->getI18NString('edit.title') ?> ?]</h2>
        [?php include_partial('<?php echo $this->getModuleName() ?>/flashes') ?]
        <div id="sf_admin_header">
                <div style="text-align:right">
                    <ul class="sf_admin_actions">
                        <li class="sf_admin_action_list"><a href="[?php echo url_for('<?php echo $this->getModuleName() ?>/index', true); ?]">[?php echo __('back to list'); ?]</a></li>
                    </ul>
                </div>
                <div class="clear"></div>
                [?php include_partial('<?php echo $this->getModuleName() ?>/form_header', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'configuration' => $configuration)) ?]
        </div>
        <div id="sf_admin_content">
            [?php include_partial('<?php echo $this->getModuleName() ?>/form', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?]
        </div>
        <div id="sf_admin_footer">
            [?php include_partial('<?php echo $this->getModuleName() ?>/form_footer', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'configuration' => $configuration)) ?]
        </div>
    </div>
</div>