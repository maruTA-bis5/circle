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

if(!defined('CIRCLE_TRUST_PATH'))
{
    define('CIRCLE_TRUST_PATH',XOOPS_TRUST_PATH . '/modules/circle');
}

require_once CIRCLE_TRUST_PATH . '/class/CircleUtils.class.php';
require_once CIRCLE_TRUST_PATH . '/class/Enum.class.php';
/**
 * Circle_AssetPreloadBase
**/
class Circle_AssetPreloadBase extends XCube_ActionFilter
{
    public $mDirname = null;

    /**
     * prepare
     *
     * @param   string  $dirname
     *
     * @return  void
    **/
    public static function prepare(/*** string ***/ $dirname)
    {
        static $setupCompleted = false;
        if(!$setupCompleted)
        {
            $setupCompleted = self::_setup($dirname);
        }
    }

    /**
     * _setup
     *
     * @param   void
     *
     * @return  bool
    **/
    public static function _setup(/*** string ***/ $dirname)
    {
        $root =& XCube_Root::getSingleton();
        $instance = new self($root->mController);
        $instance->mDirname = $dirname;
        $root->mController->addActionFilter($instance);
        return true;
    }

    /**
     * preBlockFilter
     *
     * @param   void
     *
     * @return  void
    **/
    public function preBlockFilter()
    {
        $file = CIRCLE_TRUST_PATH . '/class/callback/DelegateFunctions.class.php';
        $this->mRoot->mDelegateManager->add('Module.circle.Global.Event.GetAssetManager','Circle_AssetPreloadBase::getManager');
        $this->mRoot->mDelegateManager->add('Legacy_Utils.CreateModule','Circle_AssetPreloadBase::getModule');
        $this->mRoot->mDelegateManager->add('Legacy_Utils.CreateBlockProcedure','Circle_AssetPreloadBase::getBlock');
        $this->mRoot->mDelegateManager->add('Module.'.$this->mDirname.'.Global.Event.GetNormalUri','Circle_CoolUriDelegate::getNormalUri', $file);

        $this->mRoot->mDelegateManager->add('Legacy_CategoryClient.GetClientList','Circle_CatClientDelegate::getClientList', CIRCLE_TRUST_PATH.'/class/callback/AccessClient.class.php');
        $this->mRoot->mDelegateManager->add('Legacy_CategoryClient.'.$this->mDirname.'.GetClientData','Circle_CatClientDelegate::getClientData', CIRCLE_TRUST_PATH.'/class/callback/AccessClient.class.php');
        //Group Client
        $this->mRoot->mDelegateManager->add('Legacy_GroupClient.GetClientList','Circle_GroupClientDelegate::getClientList', CIRCLE_TRUST_PATH.'/class/callback/AccessClient.class.php');
        $this->mRoot->mDelegateManager->add('Legacy_GroupClient.'.$this->mDirname.'.GetClientData','Circle_GroupClientDelegate::getClientData', CIRCLE_TRUST_PATH.'/class/callback/AccessClient.class.php');
        $this->mRoot->mDelegateManager->add('Legacy_GroupClient.GetActionList','Circle_GroupClientDelegate::getActionList', CIRCLE_TRUST_PATH.'/class/callback/AccessClient.class.php');
        $this->mRoot->mDelegateManager->add('Legacy_TagClient.GetClientList','Circle_TagClientDelegate::getClientList', CIRCLE_TRUST_PATH.'/class/callback/TagClient.class.php');
        $this->mRoot->mDelegateManager->add('Legacy_TagClient.'.$this->mDirname.'.GetClientData','Circle_TagClientDelegate::getClientData', CIRCLE_TRUST_PATH.'/class/callback/TagClient.class.php');  }

    /**
     * getManager
     *
     * @param   Circle_AssetManager  &$obj
     * @param   string  $dirname
     *
     * @return  void
    **/
    public static function getManager(/*** Circle_AssetManager ***/ &$obj,/*** string ***/ $dirname)
    {
        require_once CIRCLE_TRUST_PATH . '/class/AssetManager.class.php';
        $obj = Circle_AssetManager::getInstance($dirname);
    }

    /**
     * getModule
     *
     * @param   Legacy_AbstractModule  &$obj
     * @param   XoopsModule  $module
     *
     * @return  void
    **/
    public static function getModule(/*** Legacy_AbstractModule ***/ &$obj,/*** XoopsModule ***/ $module)
    {
        if($module->getInfo('trust_dirname') == 'circle')
        {
            require_once CIRCLE_TRUST_PATH . '/class/Module.class.php';
            $obj = new Circle_Module($module);
        }
    }

    /**
     * getBlock
     *
     * @param   Legacy_AbstractBlockProcedure  &$obj
     * @param   XoopsBlock  $block
     *
     * @return  void
    **/
    public static function getBlock(/*** Legacy_AbstractBlockProcedure ***/ &$obj,/*** XoopsBlock ***/ $block)
    {
        $moduleHandler =& Circle_Utils::getXoopsHandler('module');
        $module =& $moduleHandler->get($block->get('mid'));
        if(is_object($module) && $module->getInfo('trust_dirname') == 'circle')
        {
            require_once CIRCLE_TRUST_PATH . '/blocks/' . $block->get('func_file');
            $className = 'Circle_' . substr($block->get('show_func'), 4);
            $obj = new $className($block);
        }
    }
}

?>
