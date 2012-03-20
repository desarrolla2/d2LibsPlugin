<td>
    <ul class="sf_admin_td_actions">
        <?php if ($sf_guard_permission->getRdMenuPluginRelation()): ?>
            <li><a class="remove" href="<?php echo url_for('rd_menu_permission/remove?id=' . $sf_guard_permission->getId(), true); ?>"><?php echo __('Remove'); ?></a></li>
        <?php else: ?>
            <li><a class="select" href="<?php echo url_for('rd_menu_permission/add?id=' . $sf_guard_permission->getId(), true); ?>"><?php echo __('Add'); ?></a></li>
        <?php endif; ?>
    </ul>
</td>