<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of modelRelationsHelper
 *
 * @author diego
 */
class ModelRelationsHelper {

    public static function getRelationsList($options= array()){

        // @TODO: Validar todo
        $q = Doctrine_Query::create()
            // ->select('u.id')
            ->from($options['relation_class'].' u')
            ->leftJoin('u.'.$options['from_class'].' fc')
            ->leftJoin('u.'.$options['to_class'].' tc');

        $q = $q->where('fc.id = ?', $options['from_id']);

        if( $options['permission_class'] != null && strlen($options['permission_class']) > 0 ){
            $q = $q->leftJoin ('u.'.$options['permission_class'].' pc')
                    ->andWhere('pc.id = ?', $options['permission_id']);
        }

        $aList = $q->execute();

        $aReturn = array();
        foreach ($aList as $item) {
            if( ''.$item->$options['to_class'] != '' ){
                array_push( $aReturn,
                        array(
                            'relation_id' => $item->getId(),
                            'to_name' => ''.$item->$options['to_class']
                            )
                        );
            }
        }

        return $aReturn;
    }

    public static function addRelation($options= array()){

        $newItem = new $options['relation_class']();

        $setMethod = 'set' . ucfirst($options['to_class']) .'Id';
        $newItem->$setMethod($options['to_id']);

        $setMethod = 'set' . ucfirst($options['from_class']) .'Id';
        $newItem->$setMethod($options['from_id']);

        if( $options['permission_class'] != null && strlen($options['permission_class']) > 0 ){
            $setMethod = 'set' . ucfirst($options['permission_class']) .'Id';
            $newItem->$setMethod($options['permission_id']);
        }

        $newItem->save();

        return array(
            'relation_id' => $newItem->getId(),
            'to_name' => ''.$newItem->$options['to_class']
        );
    }

    public static function removeRelation($options= array()){

        $q = Doctrine_Query::create()
            ->delete()
            ->from($options['relation_class'].' u')
            ->where('u.id = ?', $options['relation_id'])
            ->execute();

    }
}

