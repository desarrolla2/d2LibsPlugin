<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2007 Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfImageMagickAdapter provides a mechanism for creating thumbnail images.
 * @see http://www.imagemagick.org
 *
 * @package    sfThumbnailPlugin
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @author     Benjamin Meynell <bmeynell@colorado.edu>
 */
class rdImageMagickAdapter extends sfImageMagickAdapter {

    private $thumbnail = null;

    public function save($thumbnail, $thumbDest, $targetMime = null) {
        $this->thumbnail = $thumbnail;
        parent::save($thumbnail, $thumbDest, $targetMime = null);
    }

    

}
