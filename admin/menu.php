<?php
/**
 *
 * Module: newsslider
 * Version: 1.1
 * Author: Yerres
 * Licence: GNU
 */

use XoopsModules\Newsslider;

global $xoopsModule;

require_once __DIR__ . '/../class/Helper.php';
//require_once __DIR__ . '/../include/common.php';
$helper = Newsslider\Helper::getInstance();

$pathIcon32 = \Xmf\Module\Admin::menuIconPath('');
$pathModIcon32 = $helper->getModule()->getInfo('modicons32');
$adminmenu[] = [
    'title' => _MI_NWS_HOME,
    'link'  => 'admin/index.php',
    'icon'  => $pathIcon32 . '/home.png',
];

$adminmenu[] = [
    'title' => _MI_NWS_MENU,
    'link'  => '../../modules/system/admin.php?fct=blocksadmin&op=list&filter=1&selgen=' . $xoopsModule->getVar('mid') . '&selmod=-2&selgrp=-1&selvis=-1',
    'icon'  => $pathIcon32 . '/manage.png',

];

$adminmenu[] = [
    'title' => _MI_NWS_ABOUT,
    'link'  => 'admin/about.php',
    'icon'  => $pathIcon32 . '/about.png',
];
