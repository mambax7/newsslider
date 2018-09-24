<?php

use XoopsModules\Newsslider;

require_once __DIR__ . '/admin_header.php';

defined('XOOPS_ROOT_PATH') || die('Restricted access');

xoops_cp_header();

if (!defined('XOOPS_ORETEKI')) {
    // Skip for ORETEKI XOOPS

    if (!isset($module) || !is_object($module)) {
        $module = $xoopsModule;
    } elseif (!is_object($xoopsModule)) {
        die('$xoopsModule is not set');
    }

    /** @var Newsslider\Helper $helper */
    $helper = Newsslider\Helper::getInstance();
    $helper->loadLanguage('modinfo');

    require_once __DIR__   . '/menu.php';

    //  array_push( $adminObject , array( 'title' => _PREFERENCES , 'link' => '../system/admin.php?fct=preferences&op=showmod&mod=' . $module->getvar('mid') ) ) ;
    $menuitem_dirname = $module->getVar('dirname');
    if ($module->getVar('hasconfig')) {
        array_push($adminObject, [
            'title' => _PREFERENCES,
            'link'  => 'admin/admin.php?fct=preferences&op=showmod&mod=' . $module->getVar('mid')
        ]);
    }

    $menuitem_count = 0;
    $mymenu_uri     = empty($mymenu_fake_uri) ? $_SERVER['REQUEST_URI'] : $mymenu_fake_uri;
    $mymenu_link    = substr(strstr($mymenu_uri, '/admin/'), 1);

    // hilight
    foreach (array_keys($adminObject) as $i) {
        if ($mymenu_link == $adminmenu[$i]['link']) {
            $adminmenu[$i]['color'] = '#FFCCCC';
            $adminMenu_hilighted    = true;
        } else {
            $adminmenu[$i]['color'] = '#DDDDDD';
        }
    }
    if (empty($adminMenu_hilighted)) {
        foreach (array_keys($adminObject) as $i) {
            if (false !== stripos($mymenu_uri, $adminmenu[$i]['link'])) {
                $adminmenu[$i]['color'] = '#FFCCCC';
            }
        }
    }

    /*  // display
        foreach ($adminObject as $menuitem) {
            echo "<a href='".XOOPS_URL."/modules/$menuitem_dirname/{$menuitem['link']}' style='background-color:{$menuitem['color']};font:normal normal bold 9pt/12pt;'>{$menuitem['title']}</a> &nbsp; \n" ;

            if (++ $menuitem_count >= 4) {
                echo "</div>\n<div width='95%' align='center'>\n" ;
                $menuitem_count = 0 ;
            }
        }
        echo "</div>\n" ;
    */
    // display
    echo "<div style='text-align:left;width:98%;'>";
    foreach ($adminObject as $menuitem) {
        echo "<div style='float:left;height:1.5em;'><nobr><a href='" . XOOPS_URL . "/modules/$menuitem_dirname/{$menuitem['link']}' style='background-color:{$menuitem['color']};font:normal normal bold 9pt/12pt;'>{$menuitem['title']}</a> | </nobr></div>\n";
    }
    echo "</div>\n<hr style='clear:left;display:block;'>\n";
}
