<?php

header('Content-Type: text/html; charset=UTF-8');

require_once XOOPS_ROOT_PATH . '/header.php';

$root =& XCube_Root::getSingleton();

$mod =& $root->mContext->mModule;
$asset =& $mod->mAssetManager;
$handler = $asset->getObject('handler', 'people');
$accessController = Circle_Utils::getAccessControllerObject($asset->mDirname, 'people');

$criteria = new CriteriaCompo();

if ($cat=intval($root->mContext->mRequest->getRequest('category_id'))) 
	$criteria->add(new Criteria('category_id', $cat));

if ($sid=$root->mContext->mRequest->getRequest('student_id'))
	$criteria->add(new Criteria('student_id', '%'.strtoupper($sid).'%','like'));

if ($name=$root->mContext->mRequest->getRequest('name'))
	$criteria->add(new Criteria('title', '%'.$name.'%', 'like'));

$objects = $handler->getObjects($criteria);
$odd_even = 0;
foreach($objects as $obj) : $obj->loadTag();?>
<tr class="<?php echo $odd_even++%2==0?"even":"odd"?>">
<td><?php echo $obj->getVar('student_id'); ?></td>
<td><?php echo $obj->getVar('title'); ?></td>
<td><a href="<?php echo XOOPS_URL?>/modules/<?php echo $mod->mXoopsModule->get('dirname');?>/?action=PeopleList&category_id=<?php echo intval($obj->getVar('category_id'))?>"><?php echo $accessController->getTitle($obj->getVar('category_id'));?></a></td>
<td><?php if (count($obj->mTag)>0):?>
<?php foreach ($obj->mTag as $tag):?>
<span><a href="<?php echo XOOPS_URL;?>/modules/<?php echo $mod->mXoopsModule->get('dirname');?>/?action=PersonList&tag=<?php echo $tag;?>"><?php echo htmlspecialchars($tag, ENT_QUOTES);?></a></span> 
<?php endforeach;?>
<?php endif;?>
</td>
<td>
<?php echo date('Y/m/d H:i:s', $obj->getVar('posttime')); ?>
</td>
<td>
<a href="<?php echo XOOPS_URL?>/modules/<?php echo $mod->mXoopsModule->get('dirname')?>/?action=PeopleView&people_id=<?php echo $obj->getVar('people_id')?>"><?php echo _VIEW?></a>
<a href="<?php echo XOOPS_URL?>/modules/<?php echo $mod->mXoopsModule->get('dirname')?>/?action=PeopleEdit&people_id=<?php echo $obj->getVar('people_id')?>"><?php echo _EDIT?></a>
<a href="<?php echo XOOPS_URL?>/modules/<?php echo $mod->mXoopsModule->get('dirname')?>/?action=PeopleDelete&people_id=<?php echo $obj->getVar('people_id')?>"><?php echo _DELETE?></a>
</td>
</tr>
<?php endforeach;
