<div id="sf_admin_container">
    <div class="inner">
        <h2 class="list"><?php echo __('Rd menu items list', array(), 'messages') ?></h2>
        <div id="sf_admin_content">
            <?php if ($sf_user->hasFlash('notice')): ?>
                <div class="notice"><?php echo __($sf_user->getFlash('notice')) ?></div>
            <?php endif; ?>

            <?php if ($sf_user->hasFlash('error')): ?>
                    <div class="error"><?php echo __($sf_user->getFlash('error')) ?></div>
            <?php endif; ?>

                    <a href="<?php echo url_for('rd_menu_items/new'); ?>" rel="shadowbox;width=520;height=390" class="button"><?php echo __('New'); ?></a>
                    <div class="clear"></div>
            <?php foreach ($items as $item): ?>
                        <table cellspacing="0" cellpadding="0">
                            <tr>
                                <td valign="top" width="300" style="background:#ffffff;"><h3><?php echo $item->getName(); ?></h3></td>
                                <td valign="top" width="300" style="background:#ffffff;">
                                    <p style="margin:20px 0 5px 0;"><strong>Módulos:</strong><small>&nbsp;&nbsp;<a rel="shadowbox;width=520;height=390" href="<?php echo url_for('rd_menu_items/newModule?id=' . $item->getId(), true); ?>">[<?php echo __('New'); ?>]</a></small></p>
                                    <ul class="items">
                            <?php foreach ($item->getModules() as $module): ?>
                                <li><?php echo $module->getName(); ?><small style="text-transform: uppercase;">&nbsp;&nbsp;<a href="<?php echo url_for('rd_menu_items/deleteModule?id=' . $module->getId(), true); ?>" >[<?php echo __('Delete'); ?>]</a></small></li>
                            <?php endforeach; ?>
                            </ul>
                        </td>
                        <td valign="top" style="background:#ffffff;">
                            <p style="margin:20px 0 5px 0;"><strong>Credenciales:</strong><small style="text-transform: uppercase;">&nbsp;&nbsp;<a rel="shadowbox" href="<?php echo url_for('rd_menu_permission/index?id=' . $item->getId(), true); ?>">[Editar]</a></small></p>
                            <ul class="items">
                            <?php foreach ($item->getCredentials() as $credential): ?>
                                    <li><?php echo $credential->getName(); ?></li>
                            <?php endforeach; ?>
                                </ul>        
                            </td>
                            <td align="right" valign="top" style="background:#ffffff;">
                                <div id="sf_admin_header" style="text-align:right;float:right;">
                                    <ul class="sf_admin_actions" style="font-size: 11px;padding-top:10px;">
                                        <li><a rel="shadowbox;width=520;height=390" href="<?php echo url_for('rd_menu_items/edit?id=' . $item->getId(), true); ?>" class="edit"><?php echo __('Edit'); ?></a></li>
                                        <li><a href="<?php echo url_for('rd_menu_items/delete?id=' . $item->getId(), true); ?>" class="delete"><?php echo __('Delete'); ?></a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <div class="clear" style="border-bottom: 1px dotted #cccccc;"></div>
            <?php foreach ($item->getChildrens() as $children): ?>
                                        <div class="item">
                                            <table cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td valign="top" width="300" style="background:#ffffff;"><?php echo $children->getName(); ?></td>
                                                    <td valign="top" width="300" style="background:#ffffff;">
                                                        <p style="margin:0 0 5px 0;"><strong>Módulos:</strong><small>&nbsp;&nbsp;<a rel="shadowbox;width=520;height=390" href="<?php echo url_for('rd_menu_items/newModule?id=' . $children->getId(), true); ?>">[<?php echo __('New'); ?>]</a></small></p>
                                                        <ul class="items">
                                <?php foreach ($children->getModules() as $module): ?>
                                            <li><?php echo $module->getName(); ?><small>&nbsp;&nbsp;<a  href="<?php echo url_for('rd_menu_items/deleteModule?id=' . $children->getId(), true); ?>">[<?php echo __('Delete'); ?>]</a></small></li>
                                <?php endforeach; ?>
                                    </td>
                                    <td valign="top" style="background:#ffffff;">
                                        <p style="margin:0 0 5px 0;"><strong>Credenciales:</strong><small>&nbsp;&nbsp;<a rel="shadowbox" href="<?php echo url_for('rd_menu_permission/index?id=' . $children->getId(), true); ?>">[Editar]</a></small></p>
                                        <ul class="items">
                                <?php foreach ($children->getCredentials() as $credential): ?>
                                                <li><?php echo $credential->getName(); ?></li>
                                <?php endforeach; ?>
                                            </ul>
                                        </td>
                                        <td align="right" valign="top" style="background:#ffffff;">
                                            <div id="sf_admin_header" style="text-align:right;float:right;padding:0;margin:0;">
                                                <ul class="sf_admin_actions" style="font-size: 11px;padding:0;margin:0;">
                                                    <li><a rel="shadowbox;width=520;height=390" href="<?php echo url_for('rd_menu_items/edit?id=' . $children->getId(), true); ?>" class="edit"><?php echo __('Edit'); ?></a></li>
                                                    <li><a href="<?php echo url_for('rd_menu_items/delete?id=' . $children->getId(), true); ?>" class="delete"><?php echo __('Delete'); ?></a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
            <?php endforeach; ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>