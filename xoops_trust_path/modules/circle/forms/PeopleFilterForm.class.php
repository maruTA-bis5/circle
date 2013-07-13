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

require_once CIRCLE_TRUST_PATH . '/class/AbstractFilterForm.class.php';

define('CIRCLE_PEOPLE_SORT_KEY_PEOPLE_ID', 1);
define('CIRCLE_PEOPLE_SORT_KEY_TITLE', 2);
define('CIRCLE_PEOPLE_SORT_KEY_UID', 3);
define('CIRCLE_PEOPLE_SORT_KEY_CATEGORY_ID', 4);
define('CIRCLE_PEOPLE_SORT_KEY_POSTTIME', 5);

define('CIRCLE_PEOPLE_SORT_KEY_DEFAULT', CIRCLE_PEOPLE_SORT_KEY_PEOPLE_ID);

/**
 * Circle_PeopleFilterForm
**/
class Circle_PeopleFilterForm extends Circle_AbstractFilterForm
{
    public /*** string[] ***/ $mSortKeys = array(
 	   CIRCLE_PEOPLE_SORT_KEY_PEOPLE_ID => 'people_id',
 	   CIRCLE_PEOPLE_SORT_KEY_TITLE => 'title',
 	   CIRCLE_PEOPLE_SORT_KEY_UID => 'uid',
 	   CIRCLE_PEOPLE_SORT_KEY_CATEGORY_ID => 'category_id',
 	   CIRCLE_PEOPLE_SORT_KEY_POSTTIME => 'posttime',

    );

    /**
     * getDefaultSortKey
     * 
     * @param   void
     * 
     * @return  void
    **/
    public function getDefaultSortKey()
    {
        return CIRCLE_PEOPLE_SORT_KEY_DEFAULT;
    }

    /**
     * fetch
     * 
     * @param   void
     * 
     * @return  void
    **/
    public function fetch()
    {
        parent::fetch();
    
        $root =& XCube_Root::getSingleton();
    
		if (($value = $root->mContext->mRequest->getRequest('people_id')) !== null) {
			$this->mNavi->addExtra('people_id', $value);
			$this->_mCriteria->add(new Criteria('people_id', $value));
		}
		if (($value = $root->mContext->mRequest->getRequest('title')) !== null) {
			$this->mNavi->addExtra('title', $value);
			$this->_mCriteria->add(new Criteria('title', $value));
		}
		if (($value = $root->mContext->mRequest->getRequest('uid')) !== null) {
			$this->mNavi->addExtra('uid', $value);
			$this->_mCriteria->add(new Criteria('uid', $value));
		}
		if (($value = $root->mContext->mRequest->getRequest('category_id')) !== null) {
			$this->mNavi->addExtra('category_id', $value);
			$this->_mCriteria->add(new Criteria('category_id', $value));
		}
		if (($value = $root->mContext->mRequest->getRequest('posttime')) !== null) {
			$this->mNavi->addExtra('posttime', $value);
			$this->_mCriteria->add(new Criteria('posttime', $value));
		}

    
        $this->_mCriteria->addSort($this->getSort(), $this->getOrder());
    }
}

?>
