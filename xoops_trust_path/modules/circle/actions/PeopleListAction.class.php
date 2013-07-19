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

require_once CIRCLE_TRUST_PATH . '/class/AbstractListAction.class.php';

/**
 * Circle_PeopleListAction
**/
class Circle_PeopleListAction extends Circle_AbstractListAction
{
	const DATANAME = 'people';
	protected $mCriteria = null;
	protected $mActionForm = null;

	protected function getCriteria()
	{
		if (isset($this->mFilter) && $this->mFilter != null) {
			return $this->mCriteria =& $this->mFilter->getCriteria();
		}
		return false;
	}

	protected function addCriteria(Criteria $criteria)
	{
		if (!isset($this->mCriteria) || !($this->mCriteria instanceof CriteriaCompo)) {
			$this->mCriteria = new CriteriaCompo();
		}
		$this->mCriteria->add($criteria);
	}


	/**
	 * _getCatId
	 * 
	 * @param	void
	 * 
	 * @return	int
	**/
	protected function _getCatId()
	{
		return intval($this->mRoot->mContext->mRequest->getRequest('category_id'));
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
		if($this->_getCatId() > 0){
			return $this->mAccessController['main']->check($this->_getCatId(), Circle_AbstractAccessController::VIEW, 'circle');
		}
		return true;
	}
	/**
	 * getDefaultView
	 * 
	 * @param	void
	 * 
	 * @return	Enum
	**/
	public function getDefaultView()
	{
		$this->mFilter =& $this->_getFilterForm();
		$this->mFilter->fetch();

		$handler =& $this->_getHandler();
		$criteria =& $this->getCriteria();
	
        $criteria = new CriteriaCompo();
		$tree = array();
		if(! $this->_getCatId()){
		
			//get permitted categories to show
			$idList = $this->mAccessController['main']->getPermittedIdList(Circle_AbstractAccessController::VIEW, $this->_getCatId());
			if(count($idList)>0 && $this->mAccessController['main']->getAccessControllerType()!='none'){
				$criteria->add(new Criteria('category_id', $idList, 'IN'));
			}
		} else {
			$criteria->add(new Criteria('category_id', $this->_getCatId()));
		}
		if ($sid = $this->_getStudentId()) {
			$criteria->add(new Criteria('student_id', strtoupper($sid), 'like'));
		}
        $criteria->add(new Criteria('title', $this->_getName(), 'like'));
		
		$this->mObjects = $handler->getObjects($criteria);
	
		return CIRCLE_FRAME_VIEW_INDEX;
	}

	protected function _getStudentId()
	{
		return '%'.$this->mRoot->mContext->mRequest->getRequest('student_id').'%';
	}

	protected function _getName() 
	{
		return '%'.$this->mRoot->mContext->mRequest->getRequest('name').'%';
	}

	protected function _setupActionForm()
	{
		$this->mActionForm =& $this->mAsset->getObject('form', self::DATANAME, false, 'edit');
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
		$this->_setupActionForm();

		return true;
	}

	/**
	 * executeViewIndex
	 * 
	 * @param	XCube_RenderTarget	&$render
	 * 
	 * @return	void
	**/
	public function executeViewIndex(/*** XCube_RenderTarget ***/ &$render)
	{
		$render->setTemplateName($this->mAsset->mDirname . '_people_list.html');
		$render->setAttribute('actionForm', $this->mActionForm);
		$render->setAttribute('objects', $this->mObjects);
		$render->setAttribute('dirname', $this->mAsset->mDirname);
		$render->setAttribute('dataname', self::DATANAME);
		$render->setAttribute('pageNavi', $this->mFilter->mNavi);
		$render->setAttribute('accessController', $this->mAccessController['main']);
		$render->setAttribute('tag_dirname', $this->mRoot->mContext->mModuleConfig['tag_dirname']);
	}
}

?>
