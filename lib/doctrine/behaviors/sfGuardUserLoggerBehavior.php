<?php

/**
 * This file is part of the desarrolla2 proyect.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package     : sinersis
 * @author      : daniel.gonzalez@freelancemadrid.es
 * @version     : SVN: $Id: rdXliffI18nHandler.class 1.0  24-ago-2010 15:40:04
 *
 * @file        : sfGuardUserLoggerTemplate , UTF-8
 * @date        : 25 Oct 2011
 */
class sfGuardUserLoggerBehavior extends Doctrine_Template
{
    public function setTableDefinition()
    {
        $this->hasColumn('sf_guard_user_id', 'integer');
        $this->addListener(new sfGuardUserLoggerListener());
    }
}
