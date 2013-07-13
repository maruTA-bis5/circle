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

require_once XOOPS_TRUST_PATH . '/modules/circle/preload/AssetPreload.class.php';
Circle_AssetPreloadBase::prepare(basename(dirname(dirname(__FILE__))));

?>
