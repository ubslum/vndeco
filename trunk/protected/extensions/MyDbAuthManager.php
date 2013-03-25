<?php
/**
 * Description of MyDbAuthManager
 * Role-Based Access Control
 * @author Gia Duy
 */
class MyDbAuthManager extends CDbAuthManager{
    //put your code here
    public $assignmentTable = '{{auth_assignment}}';
    public $itemTable       = '{{auth_item}}';
    public $itemChildTable  = '{{auth_item_child}}';
    public $defaultRoles=array('Member', 'Guest');

    /**
     * Check loop
     * @param <type> $itemName
     * @param <type> $childName
     * @return <type>
     */
    public function checktLoop($itemName, $childName)
    {
        return $this->detectLoop($itemName, $childName);
    }
    
    public static function getAllRoles($id_user)
    {
        $roles=Yii::app()->authManager->getRoles($id_user);
        $roles['Member']= Yii::app()->authManager->getAuthItem('Member');
        return $roles;
    }
}
