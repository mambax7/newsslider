<?php
//  ------------------------------------------------------------------------ //
//                         NewsSlider Module for                             //
//               XOOPS - PHP Content Management System 2.0                   //
//                          Version 1.0.0                                    //
//                    Copyright (c) 2011 Xoops                               //
// ------------------------------------------------------------------------- //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
defined('XOOPS_ROOT_PATH') || exit('Restricted access.');

$modversion['version']             = 1.3;
$modversion['module_status']       = 'Beta 1';
$modversion['release_date']        = '2017/04/23';
$modversion['name']                = _MI_NWS_NAME;
$modversion['description']         = _MI_NWS_DESC;
$modversion['author']              = 'Yerres';
$modversion['help']                = 'readme.txt';
$modversion['official']            = 0; //1 indicates supported by XOOPS Dev Team, 0 means 3rd party supported
$modversion['image']               = 'assets/images/logoModule.png';
$modversion['credits']             = 'see readme';
$modversion['dirname']             = basename(__DIR__);
$modversion['help']                = 'page=help';
$modversion['license']             = 'GNU GPL 2.0 or later';
$modversion['license_url']         = 'www.gnu.org/licenses/gpl-2.0.html';
$modversion['modicons16']          = 'assets/images/icons/16';
$modversion['modicons32']          = 'assets/images/icons/32';
$modversion['module_website_url']  = 'www.xoops.org';
$modversion['module_website_name'] = 'XOOPS';
$modversion['min_php']             = '5.5';
$modversion['min_xoops']           = '2.5.9';
$modversion['min_admin']           = '1.2';
$modversion['min_db']              = ['mysql' => '5.5'];

// Sql
// Admin things
$modversion['hasAdmin']    = 1;
$modversion['system_menu'] = 1;
$modversion['adminindex']  = 'admin/index.php';
$modversion['adminmenu']   = 'admin/menu.php';

// ------------------- Help files ------------------- //
$modversion['helpsection'] = [
    ['name' => _MI_NWS_OVERVIEW, 'link' => 'page=help'],
    ['name' => _MI_NWS_DISCLAIMER, 'link' => 'page=disclaimer'],
    ['name' => _MI_NWS_LICENSE, 'link' => 'page=license'],
    ['name' => _MI_NWS_SUPPORT, 'link' => 'page=support'],
];

// Blocks
$modversion['blocks']   = [];
$modversion['blocks'][] = [
    'file'        => 'news_scrolling.php',
    'name'        => _MI_NWS_BNAME1,
    'description' => 'Shows scrolling News',
    'show_func'   => 'b_scrolling_news_show',
    'edit_func'   => 'b_scrolling_news_edit',
    'options'     => '5|3||up|0|1|0|published|DESC|50|250|1|0|0|0|0|0',
    'template'    => 'news_scrolling.tpl',
    'can_clone'   => true,
];
$modversion['blocks'][] = [
    'file'        => 'news_glider.php',
    'name'        => _MI_NWS_BNAME2,
    'description' => 'Shows News Featured Content Glider',
    'show_func'   => 'b_news_glider_show',
    'edit_func'   => 'b_news_glider_edit',
    'options'     => '5|5|downup|0|250|160||||230|1|0|1|published|DESC|35|175|1|0|0|0|0|0|0',
    'template'    => 'news_glider.tpl',
    'can_clone'   => true,
];
$modversion['blocks'][] = [
    'file'        => 'news_feature.php',
    'name'        => _MI_NWS_BNAME3,
    'description' => 'Shows News Featured Content Slider',
    'show_func'   => 'b_news_feature_show',
    'edit_func'   => 'b_news_feature_edit',
    'options'     => '4|5|0|0|published|DESC|35|175|1|0|0|0|0|0',
    'template'    => 'news_feature.tpl',
    'can_clone'   => true,
];
$modversion['blocks'][] = [
    'file'        => 'news_s3slider.php',
    'name'        => _MI_NWS_BNAME4,
    'description' => 'Shows XOOPS S3 Slider',
    'show_func'   => 'b_news_s3slider_show',
    'edit_func'   => 'b_news_s3slider_edit',
    'options'     => '5|3|0|0|published|bottom|50|175|1|0|0|0|0|0',
    'template'    => 'news_s3slider.tpl',
    'can_clone'   => true,
];
$modversion['blocks'][] = [
    'file'        => 'news_bxslider.php',
    'name'        => _MI_NWS_BNAME5,
    'description' => 'Shows bx Slider',
    'show_func'   => 'b_news_bxslider_show',
    'edit_func'   => 'b_news_bxslider_edit',
    'options'     => '5|5|0|50|0|1|0|published|2|0|25|50|250|1|0|0|0|0|0|0|0|0',
    'template'    => 'news_bxslider.tpl',
    'can_clone'   => true,
];
// other
$modversion['hasMain']         = 0;
$modversion['hasSearch']       = 0;
$modversion['hasComments']     = 0;
$modversion['hasNotification'] = 0;

// On Update X2.0
if (!empty($_POST['fct']) && !empty($_POST['op']) && !empty($_POST['diranme']) && 'modulesadmin' == $_POST['fct']
    && 'update_ok' == $_POST['op']
    && $_POST['dirname'] == $modversion['dirname']) {
    include __DIR__ . '/include/onupdate.inc.php';
}
