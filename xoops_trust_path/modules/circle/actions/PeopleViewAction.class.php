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

require_once CIRCLE_TRUST_PATH . '/class/AbstractViewAction.class.php';

/**
 * Circle_PeopleViewAction
**/
class Circle_PeopleViewAction extends Circle_AbstractViewAction
{
	const DATANAME = 'people';


	/**
	 * _getCatId
	 * 
	 * @param	void
	 * 
	 * @return	int
	**/
	protected function _getCatId()
	{
		return $this->mObject->get('category_id');
	}


	/**
	 * hasPermission
	 * 
	 * @param	void
	 * 
	 * @return	bool
	**/
	public function hasPermission()
	{
		return $this->mAccessController['main']->check($this->_getCatId(), Circle_AbstractAccessController::VIEW, 'circle');
	}

	/**
	 * prepare
	 * 
	 * @param	void
	 * 
	 * @return	bool
	**/
	public function prepare()
	{
		parent::prepare();
		$this->_setupAccessController('people');

		return true;
	}

	/**
	 * executeViewSuccess
	 * 
	 * @param	XCube_RenderTarget	&$render
	 * 
	 * @return	void
	**/
	public function executeViewSuccess(/*** XCube_RenderTarget ***/ &$render)
	{
		$render->setTemplateName($this->mAsset->mDirname . '_people_view.html');
		$render->setAttribute('object', $this->mObject);
		$render->setAttribute('dirname', $this->mAsset->mDirname);
		$render->setAttribute('dataname', self::DATANAME);
		$render->setAttribute('accessController', $this->mAccessController['main']);
	}
}

?>
