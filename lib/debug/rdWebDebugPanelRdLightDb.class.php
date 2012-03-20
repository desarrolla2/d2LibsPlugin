<?php

/**
 * This file is part of the desarrolla2 proyect.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package     : sinersis
 * @author      : daniel.gonzalez@freelancemadrid.es
 *
 * @file        : rdWebDebugPanelRdLightDb , UTF-8
 * @date        : 14-Jul-2011
 */

/**
 * rdWebDebugPanelRdLightDb class
 *
 * This class has been created in order to integrate all systems
 */
class rdWebDebugPanelRdLightDb extends sfWebDebugPanel {

    public function __construct(sfWebDebug $webDebug) {
        parent::__construct($webDebug);

        $this->db = rdLightDb::getInstance();
    }

    protected function getNumberOfQueries() {
        return $this->db->countQueries();
    }

    public function getTitle() {
        return '<img src="/sf/sf_web_debug/images/database.png" alt="rdLightDb" height="16" width="16" />' . $this->getNumberOfQueries() . ' rd';
    }

    public function getPanelTitle() {
        return 'rdLightDb';
    }

    protected function getClear() {
        return '<div class="clear"></div>';
    }

    public function getQueriesList() {
        $queries_list = '<ul id="rd_web_debud_rd_light_db_queries">';
        if ($queries = $this->db->getQueries()) {
            foreach ($queries as $query) {
                $queries_list .= '<li>' . $query . '</li>';
            }
        } else {
            $queries_list .= '<li>No queries</li>';
        }
        $queries_list .= '</ul>';
        $toggler = $this->getToggler('rd_web_debud_rd_light_db_queries', 'Queries');

        return sprintf('<h3>List Queries %s</h3>%s %s', $toggler, $this->getClear(), $queries_list);
    }

    protected function getErrorList() {
        $error_list = '<ul id="rd_web_debud_rd_light_db_errors">';
        if ($errors = $this->db->getErrorStack()) {
            foreach ($errors as $error) {
                $error_list .= '<li>' . $error . '</li>';
            }
        } else {
            $error_list .= '<li>No errors</li>';
        }
        $error_list .= '</ul>';
        $toggler = $this->getToggler('rd_web_debud_rd_light_db_errors', 'Errors');

        return sprintf('<h3>List Errors %s</h3>%s %s', $toggler, $this->getClear(), $error_list);
    }

    public function getPanelContent() {

        return $this->getQueriesList() .
        $this->getErrorList();
    }

    public static function listenToLoadDebugWebPanelEvent(sfEvent $event) {
        $event->getSubject()->setPanel(
                'rdLightDb', new self($event->getSubject())
        );
    }

}