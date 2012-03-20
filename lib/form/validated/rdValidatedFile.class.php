<?php
/**
 *
 * @package    sinersis
 * @subpackage sales_point_image
 * @author     daniel.gonzalez@freelancemadrid.es
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */

class rdValidatedFile extends sfValidatedFile {

    private $savedFilename = null;

    public function save($file = null, $fileMode = 0666, $create = true, $dirMode = 0777) {
        if ($this->savedFilename === null)
            $this->savedFilename = $file;

        return parent::save($this->savedFilename, $fileMode, $create, $dirMode);
    }

}