<div id="sf_admin_container">
    <div class="inner">
        <h2 class="list"><?php echo __('Rd menu modules', array(), 'messages') ?></h2>
        <?php if ($sf_user->hasFlash('notice')): ?>
            <div class="notice"><?php echo __($sf_user->getFlash('notice')) ?></div>
        <?php endif; ?>

        <?php if ($sf_user->hasFlash('error')): ?>
                <div class="error"><?php echo __($sf_user->getFlash('error')) ?></div>
        <?php endif; ?>

        <?php if ($form->hasGlobalErrors()): ?>
                    <?php echo $form->renderGlobalErrors() ?>
        <?php endif; ?>
        <div id="sf_admin_content">
                <form id="form" action="<?php echo ( $form->getObject()->isNew() ?
                        url_for('rd_menu_items/saveModule', true) :
                        url_for('rd_menu_items/saveModule?id=' . $form->getObject()->getId(), true)); ?>" method="post">
                    <table>
<tr>
                        <td><?php echo __('Name'); ?></td>
                        <td>
                            <?php echo $form['name']->render(); ?>
                            <?php echo $form['name']->renderError(); ?>
                        </td>                    
                    </tr>
                </table>
                <?php echo $form->renderHiddenFields(); ?>
            </form>
            <a class="button" id="send"><?php echo __('Save'); ?></a>
            <a class="button shadowbox_close"><?php echo __('Exit'); ?></a>
        </div>
    </div>
</div>