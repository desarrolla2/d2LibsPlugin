<?php

require_once dirname(__FILE__) . '/../lib/rd_menu_permissionGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/rd_menu_permissionGeneratorHelper.class.php';

/**
 * rd_menu_permission actions.
 *
 * @package    sinersis
 * @subpackage rd_menu_permission
 * @author     Daniel González <daniel.gonzalez@freelancemadrid.es>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class rd_menu_permissionActions extends autoRd_menu_permissionActions {

    protected function getId() {
        if (!$this->id = $this->getRequest()->getParameter('id', null)) {
            throw new Exception('Expecting id parameter');
        }
        return $this->id;
    }

    public function executeIndex(sfWebRequest $request) {

        parent::executeIndex($request);

        if ($id = $request->getParameter('id', null)) {
            $this->getUser()->setAttribute('id', $id, $this->getModuleName());
        }

        if (!$this->getUser()->hasAttribute('id', $this->getModuleName())) {
            throw new Exception('Expecting id parameter');
        }
    }

    public function executeRemove(sfWebRequest $request) {

        Doctrine_Query::create()
                ->delete('rdMenuCredentials')
                ->where('sf_guard_permission_id = ?', array($this->getId()))
                ->addwhere('rd_main_menu_item_id = ?', array(sfContext::getInstance()->getUser()
                    ->getAttribute('id', null, sfContext::getInstance()->getModuleName())))
                ->execute();

        $this->getUser()->setFlash('notice', 'Permiso eliminado');
        $this->redirect('rd_menu_permission/index', 301);
    }

    public function executeAdd(sfWebRequest $request) {

        $credential = new rdMenuCredentials();

        $credential->sf_guard_permission_id = $this->getId();
        $credential->rd_main_menu_item_id = sfContext::getInstance()->getUser()
                        ->getAttribute('id', null, sfContext::getInstance()->getModuleName());
        $credential->save();

        $this->getUser()->setFlash('notice', 'Permiso añadido');
        $this->redirect('rd_menu_permission/index', 301);
    }

}
