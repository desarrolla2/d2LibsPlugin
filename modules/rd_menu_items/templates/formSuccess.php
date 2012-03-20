<div id="sf_admin_container">
    <div class="inner">
        <h2 class="list"><?php echo __('Rd menu item', array(), 'messages') ?></h2>
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
                        url_for('rd_menu_items/save', true) :
                        url_for('rd_menu_items/save?id=' . $form->getObject()->getId(), true)); ?>" method="post">
                    <table>

                    <tr>
                        <td><?php echo __('Parent'); ?></td>
                        <td>
                            <?php echo $form['parent_id']->render(); ?>
                            <?php echo $form['parent_id']->renderError(); ?>
                        </td>
                    <tr>
                        <td><?php echo __('Order'); ?></td>
                        <td>
                            <?php echo $form['ord']->render(); ?>
                            <?php echo $form['ord']->renderError(); ?>
                        </td>
                    <tr>
                        <td><?php echo __('Name'); ?></td>
                        <td>
                            <?php echo $form['name']->render(); ?>
                            <?php echo $form['name']->renderError(); ?>
                        </td>
                    <tr>
                        <td><?php echo __('CSS'); ?></td>
                        <td>
                            <?php echo $form['css']->render(); ?>
                            <?php echo $form['css']->renderError(); ?>
                        </td>
                    <tr>
                        <td><?php echo __('Url'); ?></td>
                        <td>
                            <?php echo $form['url']->render(); ?>
                            <?php echo $form['url']->renderError(); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo __('Target'); ?></td>
                        <td>
                            <?php echo $form['target']->render(); ?>
                            <?php echo $form['target']->renderError(); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo __('Color'); ?></td>
                        <td>
                            <?php echo $form['color']->render(); ?>
                            <?php echo $form['color']->renderError(); ?>
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