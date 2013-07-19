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

//
// Define a basic manifesto.
//
$modversion['name'] = $myDirName;
$modversion['version'] = 1.00;
$modversion['description'] = _MI_CIRCLE_DESC_CIRCLE;
$modversion['author'] = _MI_CIRCLE_LANG_AUTHOR;
$modversion['credits'] = _MI_CIRCLE_LANG_CREDITS;
$modversion['help'] = 'help.html';
$modversion['license'] = 'GPL';
$modversion['official'] = 0;
$modversion['image'] = 'images/module_icon.png';
$modversion['dirname'] = $myDirName;
$modversion['trust_dirname'] = 'circle';

$modversion['cube_style'] = true;
$modversion['legacy_installer'] = array(
    'installer'   => array(
        'class'     => 'Installer',
        'namespace' => 'Circle',
        'filepath'  => CIRCLE_TRUST_PATH . '/admin/class/installer/CircleInstaller.class.php'
    ),
    'uninstaller' => array(
        'class'     => 'Uninstaller',
        'namespace' => 'Circle',
        'filepath'  => CIRCLE_TRUST_PATH . '/admin/class/installer/CircleUninstaller.class.php'
    ),
    'updater' => array(
        'class'     => 'Updater',
        'namespace' => 'Circle',
        'filepath'  => CIRCLE_TRUST_PATH . '/admin/class/installer/CircleUpdater.class.php'
    )
);
$modversion['disable_legacy_2nd_installer'] = false;

$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
$modversion['tables'] = array(
//    '{prefix}_{dirname}_xxxx',
##[cubson:tables]
    '{prefix}_{dirname}_people',

##[/cubson:tables]
);

//
// Templates. You must never change [cubson] chunk to get the help of cubson.
//
$modversion['templates'] = array(
/*
    array(
        'file'        => '{dirname}_xxx.html',
        'description' => _MI_CIRCLE_TPL_XXX
    ),
*/
##[cubson:templates]
        array('file' => '{dirname}_people_delete.html','description' => _MI_CIRCLE_TPL_PEOPLE_DELETE),
        array('file' => '{dirname}_people_edit.html','description' => _MI_CIRCLE_TPL_PEOPLE_EDIT),
        array('file' => '{dirname}_people_list.html','description' => _MI_CIRCLE_TPL_PEOPLE_LIST),
        array('file' => '{dirname}_people_view.html','description' => _MI_CIRCLE_TPL_PEOPLE_VIEW),
        array('file' => '{dirname}_people_inc_view.html','description' => _MI_CIRCLE_TPL_PEOPLE_VIEW),
        array('file' => '{dirname}_people_ajaxStdId.js','description' => _MI_CIRCLE_TPL_PEOPLE_AJAX),

##[/cubson:templates]
);

//
// Admin panel setting
//
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = 'admin/index.php?action=Index';
$modversion['adminmenu'] = array(
/*
    array(
        'title'    => _MI_CIRCLE_LANG_XXXX,
        'link'     => 'admin/index.php?action=xxx',
        'keywords' => _MI_CIRCLE_KEYWORD_XXX,
        'show'     => true,
        'absolute' => false
    ),
*/
##[cubson:adminmenu]
##[/cubson:adminmenu]
);

//
// Public side control setting
//
$modversion['hasMain'] = 1;
$modversion['hasSearch'] = 0;
$modversion['sub'] = array(
/*
    array(
        'name' => _MI_CIRCLE_LANG_SUB_XXX,
        'url'  => 'index.php?action=XXX'
    ),
*/
##[cubson:submenu]
##[/cubson:submenu]
);

//
// Config setting
//
$modversion['config'] = array(
/*
    array(
        'name'          => 'xxxx',
        'title'         => '_MI_CIRCLE_TITLE_XXXX',
        'description'   => '_MI_CIRCLE_DESC_XXXX',
        'formtype'      => 'xxxx',
        'valuetype'     => 'xxx',
        'options'       => array(xxx => xxx,xxx => xxx),
        'default'       => 0
    ),
*/

	array(
		'name'			=> 'access_controller',
		'title' 		=> '_MI_CIRCLE_LANG_ACCESS_CONTROLLER',
		'description'	=> '_MI_CIRCLE_DESC_ACCESS_CONTROLLER',
		'formtype'		=> 'server_module',
		'valuetype' 	=> 'text',
		'default'		=> '',
		'options'		=> array('none', 'cat', 'group')
	),
	array(
		'name'			=> 'auth_type' ,
		'title' 		=> "_MI_CIRCLE_LANG_AUTH_TYPE" ,
		'description'	=> "_MI_CIRCLE_DESC_AUTH_TYPE" ,
		'formtype'		=> 'textbox' ,
		'valuetype' 	=> 'text' ,
		'default'		=> 'viewer|poster|manager' ,
		'options'		=> array()
	) ,

    array(
        'name'          => 'tag_dirname' ,
        'title'         => '_MI_CIRCLE_LANG_TAG_DIRNAME' ,
        'description'   => '_MI_CIRCLE_DESC_TAG_DIRNAME' ,
        'formtype'      => 'server_module',
        'valuetype'     => 'text',
        'default'       => '',
        'options'       => array('none','tag')
    ) ,
                    
    array(
        'name'          => 'css_file' ,
        'title'         => "_MI_CIRCLE_LANG_CSS_FILE" ,
        'description'   => "_MI_CIRCLE_DESC_CSS_FILE" ,
        'formtype'      => 'textbox' ,
        'valuetype'     => 'text' ,
        'default'       => '/modules/'.$myDirName.'/style.css',
        'options'       => array()
    ) ,
##[cubson:config]
##[/cubson:config]
);

//
// Block setting
//
$modversion['blocks'] = array(
/*
    x => array(
        'func_num'          => x,
        'file'              => 'xxxBlock.class.php',
        'class'             => 'xxx',
        'name'              => _MI_CIRCLE_BLOCK_NAME_xxx,
        'description'       => _MI_CIRCLE_BLOCK_DESC_xxx,
        'options'           => '',
        'template'          => '{dirname}_block_xxx.html',
        'show_all_module'   => true,
        'visible_any'       => true
    ),
*/
##[cubson:block]
##[/cubson:block]
);

?>
