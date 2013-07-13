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
 * Circle_PeopleEditForm
**/
class Circle_PeopleEditForm extends XCube_ActionForm
{
	/**
	 * getTokenName
	 * 
	 * @param	void
	 * 
	 * @return	string
	**/
	public function getTokenName()
	{
		return "module.circle.PeopleEditForm.TOKEN";
	}

	/**
	 * prepare
	 * 
	 * @param	void
	 * 
	 * @return	void
	**/
	public function prepare()
	{
		//
		// Set form properties
		//
        $this->mFormProperties['people_id'] = new XCube_IntProperty('people_id');
        $this->mFormProperties['title'] = new XCube_StringProperty('title');
        $this->mFormProperties['category_id'] = new XCube_IntProperty('category_id');
        $this->mFormProperties['student_id'] = new XCube_StringProperty('student_id');
        $this->mFormProperties['posttime'] = new XCube_IntProperty('posttime');
        $this->mFormProperties['tags'] = new XCube_TextProperty('tags');

	
		//
		// Set field properties
		//
       $this->mFieldProperties['people_id'] = new XCube_FieldProperty($this);
$this->mFieldProperties['people_id']->setDependsByArray(array('required'));
$this->mFieldProperties['people_id']->addMessage('required', _MD_CIRCLE_ERROR_REQUIRED, _MD_CIRCLE_LANG_PEOPLE_ID);
       $this->mFieldProperties['title'] = new XCube_FieldProperty($this);
        $this->mFieldProperties['title']->setDependsByArray(array('required','maxlength'));
        $this->mFieldProperties['title']->addMessage('required', _MD_CIRCLE_ERROR_REQUIRED, _MD_CIRCLE_LANG_TITLE);
        $this->mFieldProperties['title']->addMessage('maxlength', _MD_CIRCLE_ERROR_MAXLENGTH, _MD_CIRCLE_LANG_TITLE, '255');
        $this->mFieldProperties['title']->addVar('maxlength', '255');
       $this->mFieldProperties['category_id'] = new XCube_FieldProperty($this);
$this->mFieldProperties['category_id']->setDependsByArray(array('required'));
$this->mFieldProperties['category_id']->addMessage('required', _MD_CIRCLE_ERROR_REQUIRED, _MD_CIRCLE_LANG_CATEGORY_ID);
       $this->mFieldProperties['student_id'] = new XCube_FieldProperty($this);
        $this->mFieldProperties['student_id']->setDependsByArray(array('required','maxlength'));
        $this->mFieldProperties['student_id']->addMessage('required', _MD_CIRCLE_ERROR_REQUIRED, _MD_CIRCLE_LANG_STUDENT_ID);
        $this->mFieldProperties['student_id']->addMessage('maxlength', _MD_CIRCLE_ERROR_MAXLENGTH, _MD_CIRCLE_LANG_STUDENT_ID, '11');
        $this->mFieldProperties['student_id']->addVar('maxlength', '11');
        $this->mFieldProperties['posttime'] = new XCube_FieldProperty($this);
	}

	/**
	 * load
	 * 
	 * @param	XoopsSimpleObject  &$obj
	 * 
	 * @return	void
	**/
	public function load(/*** XoopsSimpleObject ***/ &$obj)
	{
        $this->set('people_id', $obj->get('people_id'));
        $this->set('title', $obj->get('title'));
        $this->set('category_id', $obj->get('category_id'));
        $this->set('student_id', $obj->get('student_id'));
        $this->set('posttime', $obj->get('posttime'));
      $tags = is_array($obj->mTag) ? implode(' ', $obj->mTag) : null;
        if(count($obj->mTag)>0) $tags = $tags.' ';
        $this->set('tags', $tags);
	}

	/**
	 * update
	 * 
	 * @param	XoopsSimpleObject  &$obj
	 * 
	 * @return	void
	**/
	public function update(/*** XoopsSimpleObject ***/ &$obj)
	{
        $obj->set('title', $this->get('title'));
        $obj->set('category_id', $this->get('category_id'));
        $obj->set('student_id', $this->get('student_id'));
        $obj->mTag = explode(' ', trim($this->get('tags')));
	}

	/**
	 * _makeDateString
	 *
	 * @param	string	$key
	 * @param	XoopsSimpleObject	$obj
	 *
	 * @return	string
	 **/
	protected function _makeDateString($key, $obj)
	{
		return $obj->get($key) ? date(_PHPDATEPICKSTRING, $obj->get($key)) : '';
	}

	/**
	 * _makeUnixtime
	 * 
	 * @param	string	$key
	 * 
	 * @return	unixtime
	**/
	protected function _makeUnixtime($key)
	{
		if(! $this->get($key)){
			return 0;
		}
		$timeArray = explode('-', $this->get($key));
		return mktime(0, 0, 0, $timeArray[1], $timeArray[2], $timeArray[0]);
	}
}

?>
