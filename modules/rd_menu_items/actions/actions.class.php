<?php

/*
 * This file is part of the desarrolla2 proyect.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package    sinersis
 * @subpackage rd_menu_items
 * @author      : Daniel González <daniel.gonzalez@freelancemadrid.es>
 * @version     : SVN: $Id: ${name} 1.0  ${date} ${time}
 *
 * @file        : ${file} , UTF-8
 * @date        : ${date} ${time}
 */

class rd_menu_itemsActions extends sfActions {

    /**
     * Show dashboard of menu, credentials, and modules status
     * @param sfWebRequest $request
     */
    public function executeIndex(sfWebRequest $request) {

        $this->items = Doctrine::getTable('RdMenuItems')->getParents();
        $this->setLayout('layout');
    }

    public function executeNew(sfWebRequest $request) {
        $this->form = new rdMenuItemsForm();
        $this->setTemplate('form');
    }

    public function executeEdit(sfWebRequest $request) {
        $this->forward404Unless(
                $this->item = Doctrine::getTable('RdMenuItems')
                        ->findOneBy('id', $request->getParameter('id', null))
        );

        $this->form = new rdMenuItemsForm($this->item);
        $this->setTemplate('form');
    }

    public function executeSave(sfWebRequest $request) {

        $this->item = Doctrine::getTable('RdMenuItems')
                        ->find($request->getParameter('id', null));

        if ($this->item) {
            $this->form = new rdMenuItemsForm($this->item);
        } else {

            $this->form = new rdMenuItemsForm();
        }


        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter($this->form->getName()));
            if ($this->form->isValid()) {
                $this->form->save();
                $this->getUser()->setFlash('notice', 'rdMenuItem sucesfully created or updated');
                $this->redirect('rd_menu_items/edit?id=' . $this->form->getObject()->getId());
            }
        }
        $this->setTemplate('form');
    }

    public function executeDelete(sfWebRequest $request) {
        $this->forward404Unless(
                $this->item = Doctrine::getTable('RdMenuItems')
                        ->findOneBy('id', $request->getParameter('id', null))
        );

        $this->item->delete();
        $this->getUser()->setFlash('notice', 'rdMenuItem sucesfully deleted');
        $this->redirect('rd_menu_items/index');
    }

    public function executeNewModule(sfWebRequest $request) {
        $this->form = new rdMenuModulesForm();
        $this->setTemplate('moduleform');
    }

    public function executeSaveModule(sfWebRequest $request) {
        $this->form = new rdMenuModulesForm();
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter($this->form->getName()));
            if ($this->form->isValid()) {
                $this->form->save();
                $this->getUser()->setFlash('notice', 'rdMenuModules sucesfully created or updated');
            }
        }
        $this->setTemplate('moduleform');
    }

    public function executeDeleteModule(sfWebRequest $request) {
        $this->forward404Unless(
                $this->item = Doctrine::getTable('RdMenuModules')
                        ->findOneBy('id', $request->getParameter('id', null))
        );

        $this->item->delete();
        $this->getUser()->setFlash('notice', 'rdMenuModules sucesfully deleted');
        $this->redirect('rd_menu_items/index');
    }

    public function executeNewCredential(sfWebRequest $request) {
        $this->form = new rdMenuCredentialsForm();
        $this->setTemplate('credentialform');
    }

    public function executeSaveCredential(sfWebRequest $request) {
        $this->form = new rdMenuCredentialsForm();
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter($this->form->getName()));
            if ($this->form->isValid()) {
                $this->form->save();
                $this->getUser()->setFlash('notice', 'rdMenuCredential sucesfully created or updated');
            }
        }
        $this->setTemplate('credentialform');
    }

    public function executeDeleteCredential(sfWebRequest $request) {
        $this->forward404Unless(
                $this->item = Doctrine::getTable('RdMenuCredentials')
                        ->findOneBy('id', $request->getParameter('id', null))
        );

        $this->item->delete();
        $this->getUser()->setFlash('notice', 'rdMenuCredentials sucesfully deleted');
        $this->redirect('rd_menu_items/index');
    }

}
