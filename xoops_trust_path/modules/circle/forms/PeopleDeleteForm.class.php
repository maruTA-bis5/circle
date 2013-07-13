<?php
/**
 * @file
 * @package circle
 * @version $Id$
**/

if(!defined('XOOPS_ROOT_PATH'))
{
    exit;
}

require_once XOOPS_ROOT_PATH . '/core/XCube_ActionForm.class.php';
require_once XOOPS_MODULE_PATH . '/legacy/class/Legacy_Validator.class.php';

/**
 * Circle_PeopleDeleteForm
**/
class Circle_PeopleDeleteForm extends XCube_ActionForm
{
    /**
     * getTokenName
     * 
     * @param   void
     * 
     * @return  string
    **/
    public function getTokenName()
    {
        return "module.circle.PeopleDeleteForm.TOKEN";
    }

    /**
     * prepare
     * 
     * @param   void
     * 
     * @return  void
    **/
    public function prepare()
    {
        //
        // Set form properties
        //
        $this->mFormProperties['people_id'] = new XCube_IntProperty('people_id');
    
        //
        // Set field properties
        //
        $this->mFieldProperties['people_id'] = new XCube_FieldProperty($this);
        $this->mFieldProperties['people_id']->setDependsByArray(array('required'));
        $this->mFieldProperties['people_id']->addMessage('required', _MD_CIRCLE_ERROR_REQUIRED, _MD_CIRCLE_LANG_PEOPLE_ID);
    }

    /**
     * load
     * 
     * @param   XoopsSimpleObject  &$obj
     * 
     * @return  void
    **/
    public function load(/*** XoopsSimpleObject ***/ &$obj)
    {
        $this->set('people_id', $obj->get('people_id'));
    }

    /**
     * update
     * 
     * @param   XoopsSimpleObject  &$obj
     * 
     * @return  void
    **/
    public function update(/*** XoopsSimpleObject ***/ &$obj)
    {
        $obj->set('people_id', $this->get('people_id'));
    }
}

?>
