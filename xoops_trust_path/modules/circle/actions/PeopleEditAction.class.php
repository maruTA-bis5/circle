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

require_once CIRCLE_TRUST_PATH . '/class/AbstractEditAction.class.php';

/**
 * Circle_PeopleEditAction
**/
class Circle_PeopleEditAction extends Circle_AbstractEditAction
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
		return ($this->mObject->get('category_id')) ? $this->mObject->get('category_id') : intval($this->mRoot->mContext->mRequest->getRequest('category_id'));
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
		$catId = $this->_getCatId();
	
		if($catId>0){
			//is Manager ?
			$check = $this->mAccessController['main']->check($catId, Circle_AbstractAccessController::MANAGE, 'people');
			if($check==true){
				return true;
			}
			//is new post and has post permission ?
			$check = $this->mAccessController['main']->check($catId, Circle_AbstractAccessController::POST, 'people');
			if($check==true && $this->mObject->isNew()){
				return true;
			}
			//is old post and your post ?
			if($check==true && ! $this->mObject->isNew() && $this->mObject->get('uid')==Legacy_Utils::getUid() && $this->mObject->get('uid')>0){
				return true;
			}
		}
		else{
			$idList = array();
			$idList = $this->mAccessController['main']->getPermittedIdList(Circle_AbstractAccessController::POST, $this->_getCatId());
			if(count($idList)>0 || $this->mAccessController['main']->getAccessControllerType()=='none'){
				return true;
			}
		}
	
		return false;
	}

    /**
     * prepare
     * 
     * @param   void
     * 
     * @return  bool
    **/
    public function prepare()
    {
        parent::prepare();
        if($this->mObject->isNew()){
			$this->mObject->set('category_id', $this->_getCatId());
        }
		$this->_setupAccessController('people');
		$this->mObject->loadTag();
     return true;
    }

    /**
     * executeViewInput
     * 
     * @param   XCube_RenderTarget  &$render
     * 
     * @return  void
    **/
    public function executeViewInput(/*** XCube_RenderTarget ***/ &$render)
    {
        $render->setTemplateName($this->mAsset->mDirname . '_people_edit.html');
        $render->setAttribute('actionForm', $this->mActionForm);
        $render->setAttribute('object', $this->mObject);
        $render->setAttribute('dirname', $this->mAsset->mDirname);
        $render->setAttribute('dataname', self::DATANAME);

        //set tag usage
        $render->setAttribute('tag_dirname', $this->mRoot->mContext->mModuleConfig['tag_dirname']);
        
		$render->setAttribute('accessController',$this->mAccessController['main']);
  }

}
?>
