<?php
/**
* @class Permission
*
* This class represents the permissions for objects.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class Permission extends Db_Object {
    
    /**
    * Function to check if the logged user has an specific permission on an object
    */
    static public function getPermission($permissionCheck, $objectName) {
    	$login = User_Login::getInstance();
    	if ($login->isConnected()) {
    		$type = UserType::read($login->get('idUserType'));
    		$permission = Permission::readFirst(array('where'=>'objectName="'.$objectName.'" AND idUserType="'.$type->id().'" AND '.$permissionCheck.'="1"'));
    		return ($permission->id()!='');
    	}
    	return false;
    }

    /**
    * Function to check all the permissions for the logged user on an object
    */
    static public function getAll($objectName) {
    	$login = User_Login::getInstance();
    	if ($login->isConnected()) {
    		$type = UserType::read($login->get('idUserType'));
    		if ($type->get('managesPermissions')=='1') {
    			return array('permissionListAdmin'=>1,
							'permissionInsert'=>1,
							'permissionModify'=>1,
							'permissionDelete'=>1);
    		}
    		$permission = Permission::readFirst(array('where'=>'objectName="'.$objectName.'" AND idUserType="'.$type->id().'"'));
    		return array('permissionListAdmin'=>$permission->get('permissionListAdmin'),
    							'permissionInsert'=>$permission->get('permissionInsert'),
    							'permissionModify'=>$permission->get('permissionModify'),
    							'permissionDelete'=>$permission->get('permissionDelete'));
    	}
    	return array('permissionListAdmin'=>0,
					'permissionInsert'=>0,
					'permissionModify'=>0,
					'permissionDelete'=>0);
    }

}
?>