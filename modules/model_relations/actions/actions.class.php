<?php

require_once dirname(__FILE__) . '/../lib/Basemodel_relationsActions.class.php';

/**
 * model_relations actions.
 * 
 * @package    rdLibsPlugin
 * @subpackage model_relations
 * @author     Daniel González <daniel.gonzalez@freelancemadrid.es>
 * @version    SVN: $Id: actions.class.php 12534 2008-11-01 13:38:27Z Kris.Wallsmith $
 */
class model_relationsActions extends Basemodel_relationsActions {

    public function executeListRelations(sfWebRequest $request) {

        $relation_class = $request->getParameter('relation_class');

        $from_id = $request->getParameter('from_id');
        $from_class = $request->getParameter('from_class');
        $to_class = $request->getParameter('to_class');
        $permission_id = $request->getParameter('permission_id', null);
        $permission_class = $request->getParameter('permission_class', null);


        $permissions = ModelRelationsHelper::getRelationsList(array(
                    'relation_class' => $relation_class, 'from_id' => $from_id,
                    'from_class' => $from_class, 'to_class' => $to_class,
                    'permission_id' => $permission_id, 'permission_class' => $permission_class )
        );

        return $this->renderText(json_encode($permissions));
    }

    public function executeAddRelation(sfWebRequest $request) {

        /* if (!$request->isXmlHttpRequest())
          return $this->renderText(json_encode(array('error'=>'Sólo respondo consultas vía AJAX.')));
         */
        $relation_class = $request->getParameter('relation_class');

        $from_id = $request->getParameter('from_id');
        $from_class = $request->getParameter('from_class');
        $to_id = $request->getParameter('to_id');
        $to_class = $request->getParameter('to_class');

        // Optional
        $permission_id = $request->getParameter('permission_id', null);
        $permission_class = $request->getParameter('permission_class', null);

        $added_permission = ModelRelationsHelper::addRelation(array(
                    'relation_class' => $relation_class,
                    'from_id' => $from_id, 'from_class' => $from_class,
                    'to_id' => $to_id, 'to_class' => $to_class,
                    'permission_id' => $permission_id, 'permission_class' => $permission_class)
        );

        return $this->renderText(json_encode($added_permission));
    }

    public function executeRemoveRelation(sfWebRequest $request) {

        /* if (!$request->isXmlHttpRequest())
          return $this->renderText(json_encode(array('error'=>'Sólo respondo consultas vía AJAX.')));
         */
        $relation_id = $request->getParameter('relation_id');
        $relation_class = $request->getParameter('relation_class');

        $added_permission = ModelRelationsHelper::removeRelation(array(
                    'relation_id' => $relation_id,
                    'relation_class' => $relation_class)
        );

        return $this->renderText(json_encode($added_permission));
    }

    public function executeListTargetElements(sfWebRequest $request) {

        $to_class = $request->getParameter('to_class');

        $elements = Doctrine::getTable($to_class)
                        ->findAll();

        $aElements = array();

        foreach ($elements as $item) {
            $aElements['' . $item] = $item->getId();
        }

        return $this->renderText(json_encode($aElements));
    }

}
