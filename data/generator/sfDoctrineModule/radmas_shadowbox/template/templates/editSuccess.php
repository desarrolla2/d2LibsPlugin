<div id="sf_admin_container">
    <div class="inner">
        <h2 class="edit">[?php echo <?php echo $this->getI18NString('edit.title') ?> ?]</h2>
        [?php include_partial('<?php echo $this->getModuleName() ?>/flashes') ?]
        <div id="sf_admin_header">
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