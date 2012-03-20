<?php

/**
 * Renderiza un submenu
 */
 
class rdSubmenu extends rdSingleton {

    private static $submenu_item_active = false;
    private static $submenu_items = false;
    private static $user = false;
    
    public function renderTabs(){
        if (sfContext::hasInstance()){
            if (sfContext::getInstance()->getModuleName() == 'rd_file_manager_meta_files'){
                return self::renderSubmenuLevel1();
            }else if(sfContext::getInstance()->getModuleName() == 'rd_file_manager_categories'){
                return self::renderSubmenuLevel1();
            }
        }
        return rdMenuPlugin::getInstance()->renderTabs();
    }

    static public function renderSubmenuLevel1($url = 'rd_file_manager_meta_files/index') {

        rdSubmenu::setSubMenuItems(null);

        $html = '<ul class="tabsInner">';
        if (self::hasSubMenuItems()) {
        foreach (self::$submenu_items as $item) {
            if(self::hasCredentialforItem(self::getRdMenuItemForCategory($item))){
                $html .= self::renderSubMenuItem($item, $url);
            }
            }
        } else {
            $html .= '<li class=""><a href="#" class="active ' .
                    'not-available home"> No Items! </a></li>';
        }
         $html .= '</ul>';

        return $html;

    }

    /**
     * Obtiene el código html del submenú para la url argumento $url
     * @param <type> $url url de la acción para la que se generará el submenú
     * @return string
     */

    static public function renderSubmenu($user,$url = 'rd_file_manager_meta_files/index') {
        self::$user=$user;


        if (!self::$submenu_items){
            //Obttiene el id del item del contexto
            $itemId= sfContext::getInstance()->getUser()->getAttribute('id', 1, sfContext::getInstance()->getModuleName());
            //Obtiene la categoría asociada al item
            $iteminicial= rdFileManagerCategoriesTable::findCategory($itemId);

            //$iteminicial->setId($itemId);

        if (!rdFileManagerCategoriesTable::hasParentId($itemId)){
            if(!self::hasCredentialforItem(self::getRdMenuItemForCategory($iteminicial))){

                rdSubmenu::setSubMenuItems(null);
                foreach(self::$submenu_items as $item){
                    if(self::hasCredentialforItem(self::getRdMenuItemForCategory($item))){
                        $itemId=$item->getId();
                        break;
                    }
                }
            }
        }

            rdSubmenu::setSubMenuItems(rdFileManagerCategoriesTable::getParentId($itemId));
        }
        
        $html = '<ul class="tabsInner">';
        if (self::hasSubMenuItems()) {
            $html .= self::renderSubMenuItemAll(rdFileManagerCategoriesTable::getParentId(self::$submenu_items[0]->getId()),$url);
            foreach (self::$submenu_items as $item) {
                $html .= self::renderSubMenuItem($item, $url);
            }
        } else {
            $html .= '<li class=""><a href="#" class="active ' .
                    'not-available home"> No Items! </a></li>';
        }
        $html .= '</ul>';
        return $html;
    }
    
    /**
     * renderiza el item del submenu. con la ruta pasada como argumento
     * @param <type> $item objeto con un atributo id
     * @param <type> $url url relativa para la cual se creará el elemento del submenú
     * @return string
     */

    private static function renderSubMenuItem($item, $url) {

        $idcategoria=sfContext::getInstance()->getUser()->getAttribute('id', 1, sfContext::getInstance()->getModuleName());

        if ($idcategoria == $item->getId() || rdFileManagerCategoriesTable::getParentId($idcategoria)==$item->getId()) {
            $active = 'active';
            self::$submenu_item_active= $item;
        } else {
            $active = '';
        }
        $html = '<li><a class="' . $active . '" href="' . url_for($url . '?id=' . $item->getId())
                . '">' . $item->name . '</a></li>';
        return $html;
    }


    /**
     * Renderiza un item del submenu dedicado a mostrar todos los elementos de la lista
     * @param <type> $idpadre
     * @param <type> $url Url relativa para la cual se creará el elemento del submenú
     * @return string
     */
    

    private static function renderSubMenuItemAll($idpadre, $url){

       // $idpadre=rdFileManagerCategoriesTable::getParentId(sfContext::getInstance()->getUser()->getAttribute('id', 1, sfContext::getInstance()->getModuleName()));
        if (sfContext::getInstance()->getUser()->getAttribute('id', 1, sfContext::getInstance()->getModuleName()) == $idpadre) {
            $active = 'active';
        } else {
            $active = '';
        }
        $html = '<li><a class="' . $active . '" href="' . url_for($url . '?id=' . $idpadre)
                . '">' . 'Todos' . '</a></li>';
        return $html;
        
    }

    /**
     * Devuelve el número de items o false si no hay ninguno
     * @return <type>
     */
    private static function hasSubMenuItems() {
        if (self::$submenu_items) {
            return self::$submenu_items->count();
        } else {
            return false;
        }
    }

    /**
     * Obtiene los items con el id padre $parent_id de la tabla argumento $table
     * @param <type> $parent_id
     * @param <type> $table
     * @return <type>
     */

    static public function setSubMenuItems($parent_id, $table = 'rdFileManagerCategories') {
        if ($parent_id==null){
            self::$submenu_items = Doctrine_Query::create()
                ->from($table)
                ->where('ISNULL(parent_id)')
                ->orderBy('ord ASC')
                ->execute();

        }else{

            self::$submenu_items = Doctrine_Query::create()
                ->from($table)
                ->where('parent_id = ? ' ,array($parent_id))
                ->orderBy('ord ASC')
                ->execute();
        }
        return self::$submenu_items->count();
    }

    /**
     * Devuelve true si el usuario tiene permiso, false si no lo tiene
     *
     * @param rdMenuCredentials $item
     * @return true or false
     */
     public static function hasCredentialforItem(rdMenuItems $item) {


        $user = sfContext::getInstance()->getUser()->getGuardUser();
      
       $permissions= $user->getAllPermissions();
       $item_credentials= self::getCredentialsForItem($item);
       if ($item_credentials) {
            
                foreach($permissions as $permission){
                    if(in_array($permission->getId(), $item_credentials)){   
                        return true;
                      }
            }
        }

       return false;

    }
    /**
     *  return array $credentials for  $item
     *
     * @param rdMenuCredentials $item
     * @return array $credentials
     */

    private static function getCredentialsForItem(rdMenuItems $item) {
        $credentials = array();
        $q = Doctrine_Query::create()
                        ->from('rdMenuCredentials')
                        ->where('rd_main_menu_item_id = ?', array($item->getId()));
        //if ($item->getParentId()) {
        //    $q->orWhere('rd_main_menu_item_id = ?', array($item->getParentId()));
        //}
        $items = $q->execute();

        if ($items->count()) {
            foreach ($items as $i) {
                array_push($credentials, $i->getSfGuardPermissionId());
            }
        }
        return array_unique($credentials);
    }





  public static function getRdMenuItemForCategory($category){
      $item = Doctrine_Query::create()
                ->from('rdMenuItems')
                ->where('name= ?', array($category->name))
                ->fetchOne();

      return $item;
  }

  public static function getPermission(){
      return self::$submenu_items->count();
  }

  public static function getSubmenuItems(){
      return self::$submenu_items;
  }
    
}
