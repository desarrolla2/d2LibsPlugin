<?php

/*
* This file is part of the desarrolla2 proyect.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package    sinersis
 * @subpackage validator
 * @author      : Daniel González <daniel.gonzalez@freelancemadrid.es>
 * @version     : SVN: $Id: ${name} 1.0  ${date} ${time}
 *
 * @file        : ${file} , UTF-8
 * @date        : ${date} ${time}
 */

class sfValidatorDoctrineUniqueSfGuardUserId extends sfValidatorDoctrineUnique {

    /**
     * Constructor.
     *
     * @param array  An array of options
     * @param array  An array of error messages
     *
     * @see sfValidatorSchema
     */
    public function __construct($options = array(), $messages = array()) {
        parent::__construct($options, $messages);
    }

    /**
     * Configures the current validator.
     *
     * Available options:
     *
     *  * model:              The model class (required)
     *  * column:             The unique column name in Doctrine field name format (required)
     *                        If the uniquess is for several columns, you can pass an array of field names
     *  * primary_key:        The primary key column name in Doctrine field name format (optional, will be introspected if not provided)
     *                        You can also pass an array if the table has several primary keys
     *  * connection:         The Doctrine connection to use (null by default)
     *  * throw_global_error: Whether to throw a global error (false by default) or an error tied to the first field related to the column option array
     *
     * @see sfValidatorBase
     */
    protected function configure($options = array(), $messages = array()) {
        $this->addRequiredOption('model');
        $this->addRequiredOption('column');
        $this->addOption('primary_key', null);
        $this->addOption('connection', null);
        $this->addOption('throw_global_error', false);
        $this->setMessage('invalid', 'An object with the same "%column%" already exist.');
    }

    /**
     * @see sfValidatorBase
     */
    protected function doClean($values) {

        if (sfContext::hasInstance()) {
            $sf_guard_user_id = sfContext::getInstance()->getUser()->getGuardUser()->getId();
        } else {
            $sf_guard_user_id = 1;
        }
        $q = Doctrine_Query::create()
                ->select('COUNT(*) as c')
                ->from($this->getOption('model'))
                ->where('sf_guard_user_id = ?', array($sf_guard_user_id))
                ->andWhere($this->getOption('column') . ' = ?', array($values[$this->getOption('column')]));

        if ($values['id']) {
            $q->andWhere('id != ?', array($values['id']));
        }

        $c = $q->execute(array(), Doctrine_Core::HYDRATE_SINGLE_SCALAR);

        if ($c) {
            throw new sfValidatorError($this, 'invalid', array('column' => $this->getOption('column')));
        } else {
            return $values;
        }
    }

}