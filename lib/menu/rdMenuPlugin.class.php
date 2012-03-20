<?php

/**
 * This file is part of the desarrolla2 proyect.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author      : daniel.gonzalez@freelancemadrid.es
 * @version     : SVN: $Id: rdSinersisUser 1.0  11-ago-2010 13:08:44
 *
 * @file        : rdMainMenu.class.php , UTF-8
 * @date        : 11-ago-2010 , 13:08:44
 */
/*
 * rdMainMenu manager class for menu, css class, and permissions
 *
 *
 */

class rdMenuPlugin extends rdSingleton {    

    private $menu_item_active = false;
    private $tabs_item_active = false;
    private $menu_items = false;
    private $tabs_items = false;
    private $user_credentials = array();

    private function notExecuteInProduction() {
        if (sfConfig::get('sf_environment') == 'prod') {
            throw new Exception('this method not available in production enviroments');
        }
    }

    public function debugMenu() {
        $this->notExecuteInProduction();

        if ($this->hasMenuItems()) {
            return '<pre><label>Activo: </label>' .
                    htmlentities(print_r($this->menu_item_active->toArray(), true)) .
                    '</pre> ' .
                    '<pre><label>Elementos: </label>' .
                    htmlentities(print_r($this->menu_items->toArray(), true)) .
                    '</pre> ';
        } else {
            return '<pre><label>No hay elementos</label>No hay elementos';
        }
    }

    public function debugTabs() {
        $this->notExecuteInProduction();

        if (!$this->tabs_item_active) {
            $this->tabs_item_active = new rdMenuItems();
        }
        return '<pre><label>Activo: </label>' .
                htmlentities(print_r($this->tabs_item_active->toArray(), true)) .
                '</pre> ' .
                '<pre><label>Elementos: </label>' .
                htmlentities(print_r($this->tabs_items->toArray(), true)) .
                '</pre> ';
    }

    /**
     * Set user credentials in array $user_credentials, example array('credential1' ,'credential2')
     *
     * return int count($credentials)
     */
    private function setUserCredentials() {
        $this->user_credentials = array();
        if (sfContext::hasInstance()) {
            $this->user_credentials = array_unique(
                    sfContext::getInstance()->getUser()->getCredentials());
        }

        return count($this->user_credentials);
    }

    /**
     *  return array $credentials for  $item
     *
     * @param rdMenuCredentials $item
     * @return array $credentials
     */
    private function getCredentialsForItem(rdMenuItems $item) {
        $credentials = array();
        $q = Doctrine_Query::create()
                ->from('rdMenuCredentials')
                ->where('rd_main_menu_item_id = ?', array($item->getId()));
        $items = $q->execute();

        if ($items->count()) {
            foreach ($items as $i) {
                array_push($credentials, $i->getName());
            }
        }
        return array_unique($credentials);
    }

    /**
     *  return array $credentials for  $item
     *
     * @param rdMenuCredentials $item
     * @return array $credentials
     */
    private function getCredentialsForTab(rdMenuItems $item) {
        $credentials = array();
        $q = Doctrine_Query::create()
                ->from('rdMenuCredentials')
                ->where('rd_main_menu_item_id = ?', array($item->getId()));
        $items = $q->execute();

        if ($items->count()) {
            foreach ($items as $i) {
                array_push($credentials, $i->getName());
            }
        }
        return array_unique($credentials);
    }

    private function getMenuTabActiveCredentials() {

        throw new Exception('deprecated');
        return $this->getCredentialsForItem($this->menu_item_active);
    }

    /**
     *  return array $credentials for a item active
     *
     * @return array $credentials
     */
    private function getMenuItemActiveCredentials() {

        return $this->getCredentialsForItem($this->menu_item_active);
    }

    /*
     * Determines if the user has permission for a menu item, or a tab item
     * ( both are rdMenuItems ).
     * This method accesses the context to determine if has permission
     * only be invoked in situations where the context is created.
     *
     * return true or false
     */

    protected function initialize() {

        parent::initialize();

        if (!$this->menu_items) {
            $this->setMenuItems();
        }
        if ($this->hasMenuItems()) {
            $this->setMenuItemActive();
            $this->setTabsItems();
        }

        $this->setUserCredentials();
    }

    public function renderColor() {
        if ($this->menu_item_active) {
            if ($color = $this->menu_item_active->getColor()) {
                return $color;
            }
        }
        return 'darkblue';
    }

    public function renderMenu() {
        $html = '<ul class="menu">';
        if ($this->hasMenuItems()) {
            foreach ($this->menu_items as $item) {
                $html .= $this->renderMenuItem($item);
            }
        } else {
            $html .= '<li class="active"><a href="#" class="active ' .
                    'not-available home"> No Items! </a></li>';
        }
        $html .= '</ul>';
        return $html;
    }

    public function renderMenuUrl($id=null) {
        $html = '<ul class="menu">';
        if ($this->hasMenuItems()) {
            foreach ($this->menu_items as $item) {
                $html .= $this->renderMenuItem($item);
            }
        } else {
            $html .= '<li class="active"><a href="#" class="active ' .
                    'not-available home"> No Items! </a></li>';
        }
        $html .= '</ul>';
        return $html;
    }

    /**
     *  return array $credentials for  $item
     *
     * @param rdMenuCredentials $item
     * @return true or false
     */
    private function hasCredentialforItem(rdMenuItems $item) {
        if ($item_credentials = $this->getCredentialsForItem($item)) {
            foreach ($item_credentials as $credential) {
                if (in_array($credential, $this->user_credentials)) {
                    return true;
                }
            }

            return false;
        }
        return true;
    }

    /**
     *  return array $credentials for  $item
     *
     * @param rdMenuCredentials $item
     * @return true or false
     */
    private function hasCredentialforTab(rdMenuItems $item) {
        if ($item_credentials = $this->getCredentialsForTab($item)) {
            foreach ($item_credentials as $credential) {
                if (in_array($credential, $this->user_credentials)) {
                    return true;
                }
            }

            return false;
        }
        return true;
    }

    private function hasMenuItems() {
        if ($this->menu_items) {
            return $this->menu_items->count();
        } else {
            return false;
        }
    }

    private function hasTabsItems() {
        if ($this->tabs_items) {
            return $this->tabs_items->count();
        } else {
            return false;
        }
    }

    /**
     * Return if current user has permission form module name
     * See plugin documentation
     * 
     * @return true or false
     */
    public function hasPemission() {
        if ($this->menu_item_active) {
            if (!$this->hasCredentialforItem($this->menu_item_active)) {
                return false;
            }
        }
        if ($this->tabs_item_active) {
            if (!$this->hasCredentialforTab($this->tabs_item_active)) {
                return false;
            }
        }
        return true;
    }

    private function setMenuItems() {
        $this->menu_items = Doctrine_Query::create()
                ->from('rdMenuItems')
                ->where('parent_id is null')
                ->orderBy('ord ASC')
                ->execute();
        return $this->menu_items->count();
    }

    private function setTabsItems() {
        if ($this->menu_item_active) {
            $this->tabs_items = Doctrine_Query::create()
                    ->from('rdMenuItems')
                    ->where('parent_id = ?', array($this->menu_item_active->getId()))
                    ->orderBy('ord ASC')
                    ->execute();
            return $this->tabs_items->count();
        } else {
            return false;
        }
    }

    private function setMenuItemActive() {
        if (!$this->menu_item_active) {
            $module = sfContext::getInstance()->getModuleName();
            if ($module) {
                $q = Doctrine_Query::create()->from('rdMenuModules')
                        ->where('name = ?', array($module))
                        ->execute();
                if ($q->count()) {
                    $item_active = $q->getFirst()->getRdMenuItems();
                    if (is_null($item_active->getParentId())) {
                        $this->menu_item_active = $item_active;
                    } else {
                        $this->tabs_item_active = $item_active;
                        $this->menu_item_active = $item_active->getRdMenuItems();
                    }
                } else {
                    $this->menu_item_active = false;
                }
            } else {
                $this->menu_item_active = false;
            }
        }
    }

    private function renderMenuItemActive($item) {

        if ($this->menu_item_active) {
            if (strtolower($item->getName()) == strtolower($this->menu_item_active->getName())) {
                return ' active ';
            } else {
                return '';
            }
        } else {
            return '';
        }
    }

    private function renderTabsItemActive($item) {
        if ($this->tabs_item_active) {
            if (strtolower($item->getName())
                    == strtolower($this->tabs_item_active->getName())) {
                return ' active ';
            }
        }
        return '';
    }

    private function renderMenuItemCss($item) {

        if ($this->renderUrl($item) == '#') {
            return $item->css . ' not-available ';
        } else {
            return $item->css;
        }
    }

    private function renderTabItemCss($item) {
        if ($this->renderUrl($item) == '#') {
            return ' not-available ' . $item->css;
        } else {
            return $item->css;
        }
    }

    private function renderTarget($item) {
        $targets = array(
            '_self', '_blank', '_parent', '_top'
        );
        if (in_array($item->getTarget(), $targets)) {
            return trim($item->getTarget());
        }
    }

    private function renderMenuItem(rdMenuItems $item) {
        $html = '';
        if ($this->hasCredentialforItem($item)) {
            $html = '<li class="' . $this->renderMenuItemActive($item) . ' ' .
                    $item->getColor() . '"><a href="' . $this->renderUrl($item) .
                    '" class="' . $this->renderMenuItemCss($item) .
                    $this->renderMenuItemActive($item) . '" target="' .
                    $this->renderTarget($item) . '">' . $item->name . '</a></li>';
        }
        return $html;
    }

    private function renderTabsItem(rdMenuItems $item) {
        $html = '';
        if ($this->hasCredentialforTab($item)) {
            $html = '<li><a href="' . $this->renderUrl($item) . '" class="' .
                    $this->renderTabsItemActive($item) . $this->renderTabItemCss($item) .
                    '" target="' . $this->renderTarget($item) . '" >' . $item->name . '</a></li>';
        }
        return $html;
    }

    private function renderUrl($item) {
        if ($item->getUrl() == '#' || $item->getUrl() == '') {
            $url = '#';
        } else {
            $url = url_for($item->getUrl(), true);
        }
        return $url;
    }

    public function renderTabs() {

        $html = '<ul>';

        if (sfConfig::get('app_rd_menu_tab_render_active_item', false)) {
            $html .= '<li><a href="' . $this->renderUrl($this->menu_item_active) .
                    '" class="' .
                    ( $this->tabs_item_active ?
                            '' : $this->renderMenuItemActive($this->menu_item_active) )
                    . '">' . $this->menu_item_active->getName() . '</a></li>';
        }

        if ($this->hasTabsItems()) {
            foreach ($this->tabs_items as $item) {
                $html .= $this->renderTabsItem($item);
            }
        }
        $html .= '</ul>';

        return $html;
    }

}