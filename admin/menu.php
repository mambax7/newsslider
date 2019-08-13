<?php
/**
 * Module: newsslider
 * Version: 1.1
 * Author: Yerres
 * Licence: GNU
 */

//use XoopsModules\Newsslider;

include dirname(__DIR__) . '/preloads/autoloader.php';

$moduleDirName      = basename(dirname(__DIR__));
$moduleDirNameUpper = mb_strtoupper($moduleDirName);

/** @var \XoopsModules\Newsslider\Helper $helper */
$helper = \XoopsModules\Newsslider\Helper::getInstance();

$pathIcon32 = \Xmf\Module\Admin::menuIconPath('');
if (is_object($helper->getModule())) {
    $pathModIcon32 = $helper->getModule()->getInfo('modicons32');
    $mid           = $helper->getModule()->getVar('mid');
}

global $xoopsModule;

$adminmenu[] = [
    'title' => _MI_NWS_HOME,
    'link'  => 'admin/index.php',
    'icon'  => $pathIcon32 . '/home.png',
];

//if (null !== $mid) {
//    $adminmenu[] = [
//        'title' => _MI_NWS_MENU,
//        //    'link'  => '../../modules/system/admin.php?fct=blocksadmin&op=list&filter=1&selgen=' . $xoopsModule->getVar('mid') . '&selmod=-2&selgrp=-1&selvis=-1',
//        'link'  => '../../modules/system/admin.php?fct=blocksadmin&op=list&filter=1&selgen=' . $mid . '&selmod=-2&selgrp=-1&selvis=-1',
//        'icon'  => $pathIcon32 . '/manage.png',
//    ];
//}

$adminmenu[] = [
    'title' => _MI_NWS_BLOCKS,
    'link'  => 'admin/blocksadmin.php',
    'icon'  => $pathIcon32 . '/block.png',
];

$adminmenu[] = [
    'title' => _MI_NWS_ABOUT,
    'link'  => 'admin/about.php',
    'icon'  => $pathIcon32 . '/about.png',
];
