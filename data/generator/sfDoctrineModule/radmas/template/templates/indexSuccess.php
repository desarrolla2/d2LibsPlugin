<div id="sf_admin_container">
    <div class="left">
        <div class="inner">
            <h2 class="list">[?php echo <?php echo $this->getI18NString('list.title') ?> ?]</h2>

            [?php include_partial('<?php echo $this->getModuleName() ?>/list_header') ?]
            [?php include_partial('<?php echo $this->getModuleName() ?>/flashes') ?]

            <div id="sf_admin_content">                    
                    [?php include_partial('<?php echo $this->getModuleName() ?>/list_actions', array('helper' => $helper)) ?]
                <div class="clear" style="height:10px;"></div>
                <form action="[?php echo url_for('<?php echo $this->getUrlForAction('collection') ?>', array('action' => 'batch')) ?]" method="post">
                    [?php include_partial('<?php echo $this->getModuleName() ?>/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?]
                    [?php include_partial('<?php echo $this->getModuleName() ?>/list_batch_actions', array('helper' => $helper)) ?]
                </form>
            </div>
            <div id="sf_admin_footer">
                [?php include_partial('<?php echo $this->getModuleName() ?>/list_footer', array('pager' => $pager)) ?]
            </div>
        </div>
    </div>
    <div class="right">
        <div class="inner">
            <h2 class="search">[?php echo __('Filter list'); ?]</h2>
    	[?php include_partial('<?php echo $this->getModuleName() ?>/filters', array('form' => $filters, 'configuration' => $configuration)) ?]
        [?php include_partial('<?php echo $this->getModuleName() ?>/filters_fieldset') ?]

        </div>
    </div>
    <div class="clear"></div>
</div>