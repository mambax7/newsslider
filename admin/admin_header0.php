<?php
/**
 * Module: newsslider
 * Version: 1.1
 * Author: yerres
 * Licence: GNU
 */
require_once dirname(dirname(dirname(__DIR__))) . '/mainfile.php';
require_once dirname(dirname(dirname(__DIR__))) . '/include/cp_header.php';
global $xoopsModule, $xoopsConfig;

require_once XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->dirname() . '/admin/functions.php';

$myts = \MyTextSanitizer::getInstance();

if (is_object($xoopsUser)) {
    $xoopsModule = XoopsModule::getByDirname('newsslider');
    if (!$xoopsUser->isAdmin($xoopsModule->mid())) {
        redirect_header(XOOPS_URL . '/', 1, _NOPERM);
    }
} else {
    redirect_header(XOOPS_URL . '/', 1, _NOPERM);
}
