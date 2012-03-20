<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2007 Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfThumbnail provides a mechanism for creating thumbnail images.
 *
 * This is taken from Harry Fueck's Thumbnail class and
 * converted for PHP5 strict compliance for use with symfony.
 *
 * @package    sfThumbnailPlugin
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @author     Benjamin Meynell <bmeynell@colorado.edu>
 */
class rdThumbnail extends sfThumbnail
{

  private $file_name = null;

  public function loadFile($image){
      $this->file_name = $image;
      parent::loadFile($image);
  }

  
  public function getNumPages() {

        $cmd = 'identify -format %n ' . $this->file_name;
        return exec($cmd);
    }
}
