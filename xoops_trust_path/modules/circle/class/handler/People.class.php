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

/**
 * Circle_PeopleObject
**/
class Circle_PeopleObject extends Legacy_AbstractObject
{
    const PRIMARY = 'people_id';
    const DATANAME = 'people';

    /**
     * __construct
     * 
     * @param   void
     * 
     * @return  void
    **/
    public function __construct()
    {
        parent::__construct();  
        $this->initVar('people_id', XOBJ_DTYPE_INT, '', false);
        $this->initVar('title', XOBJ_DTYPE_STRING, '', false, 255);
        $this->initVar('category_id', XOBJ_DTYPE_INT, '', false);
        $this->initVar('student_id', XOBJ_DTYPE_STRING, '', false, 11);
        $this->initVar('posttime', XOBJ_DTYPE_INT, time(), false);
   }

    /**
     * getShowStatus
     * 
     * @param   void
     * 
     * @return  string
    **/
    public function getShowStatus()
    {
        switch($this->get('status')){
            case Lenum_Status::DELETED:
                return _MD_LEGACY_STATUS_DELETED;
            case Lenum_Status::REJECTED:
                return _MD_LEGACY_STATUS_REJECTED;
            case Lenum_Status::POSTED:
                return _MD_LEGACY_STATUS_POSTED;
            case Lenum_Status::PUBLISHED:
                return _MD_LEGACY_STATUS_PUBLISHED;
        }
    }

	public function getImageNumber()
	{
		return 0;
	}

	public function loadTag()
	{
		$tagDirname = Circle_Utils::getModuleConfig($this->getDirname(), 'tag_dirname');
		if ($this->_mIsTagLoaded == false && $tagDirname) {
			$tagArr = array();
			if (! $this->isNew()) {
				XCube_DelegateUtils::call(
					'Legacy_Tag.'.$tagDirname.'.GetTags',
					new XCube_Ref($tagArr),
					$tagDirname,
					$this->getDirname(),
					'page',
					$this->get('people_id')
				);
			}
			$this->mTag = $tagArr;
			$this->_mIsTagLoaded = true;adump($this);
		}
	}
		
}

/**
 * Circle_PeopleHandler
**/
class Circle_PeopleHandler extends Legacy_AbstractClientObjectHandler
{
    public /*** string ***/ $mTable = '{dirname}_people';
    public /*** string ***/ $mPrimary = 'people_id';
    public /*** string ***/ $mClass = 'Circle_PeopleObject';

    /**
     * __construct
     * 
     * @param   XoopsDatabase  &$db
     * @param   string  $dirname
     * 
     * @return  void
    **/
    public function __construct(/*** XoopsDatabase ***/ &$db,/*** string ***/ $dirname)
    {
        $this->mTable = strtr($this->mTable,array('{dirname}' => $dirname));
        parent::XoopsObjectGenericHandler($db);
    }

}

?>
