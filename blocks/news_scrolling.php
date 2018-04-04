<?php
/** news_scrolling.php v.1
 * XOOPS - PHP Content Management System
 * Copyright (c) 2011 <https://xoops.org>
 *
 * Module: newsslider 1.0
 * Author : Yerres
 * Licence : GPL
 *
 */
defined('XOOPS_ROOT_PATH') || die('Restricted access');

function b_scrolling_news_show($options)
{
    global $xoopsDB, $xoopsUser;
    $myts = MyTextSanitizer:: getInstance();

    $block = [];
    /** @var XoopsModuleHandler $moduleHandler */
    $moduleHandler = xoops_getHandler('module');
    $module        = $moduleHandler->getByDirname('news');
    if (!isset($newsConfig)) {
        $configHandler = xoops_getHandler('config');
        $newsConfig    =& $configHandler->getConfigsByCat(0, $module->getVar('mid'));
    }
    if (!is_object($module)) {
        return $block;
    }
    require_once XOOPS_ROOT_PATH . '/modules/news/class/class.newsstory.php';
    require_once XOOPS_ROOT_PATH . '/modules/news/include/functions.php';
    $block['speed']       = isset($options[1]) && '' != $options[1] ? $options[1] : '3';
    $block['bgcolor']     = isset($options[2]) && '' != $options[2] ? $options[2] : '#FFFFFF';
    $block['direction']   = $options[3];
    $block['alternate']   = (1 == $options[4]) ? 1 : 0;
    $block['includedate'] = (1 == $options[5]) ? 1 : 0;
    $block['style']       = $options[6];
    $uniqueid             = substr(md5(uniqid(mt_rand())), 25);
    $block['divid']       = $uniqueid;

    $block['sort'] = $options[7];
    $tmpstory      = new NewsStory;
    // for compatibility with old News versions
    if ($module->getVar('version') >= 150) {
        $restricted = news_getmoduleoption('restrictindex');
        $dateformat = news_getmoduleoption('dateformat');
        $infotips   = news_getmoduleoption('infotips');
        //if($dateformat == '') $dateformat = 'M d, Y g:i A'; //Int. Date
        if ('' == $dateformat) {
            $dateformat = 'd. M. Y G:i';
        }
    } else {
        $restricted = isset($newsConfig['restrictindex']) && 1 == $newsConfig['restrictindex'] ? 1 : 0;
        $dateformat = isset($newsConfig['dateformat'])
                      && '' != $newsConfig['dateformat'] ? $newsConfig['dateformat'] : 'd. M. Y G:i';
        $infotips   = '0';
    }

    if (0 == $options[16]) {
        $stories = $tmpstory->getAllPublished($options[0], 0, $restricted, 0, 1, $options[7]);
    } else {
        $topics  = array_slice($options, 16);
        $stories = $tmpstory->getAllPublished($options[0], 0, $restricted, 0, 1, $options[7]);
    }
    unset($tmpstory);
    if (0 == count($stories)) {
        return '';
    }

    $i = 1;
    foreach ($stories as $story) {
        $news = [];

        $title = $story->title();
        if (strlen($title) > $options[9]) {
            $title = xoops_substr($title, 0, $options[9] + 3);
        }
        $news['title']       = $title;
        $news['id']          = $story->storyid();
        $news['date']        = formatTimestamp($story->published(), $dateformat);
        $userlink            = '<a style="cursor:help;" href="' . XOOPS_URL . '/modules/news/article.php?storyid=' . $story->storyid() . '">';
        $news['url']         = $userlink;
        $news['no']          = ++$i;
        $news['author']      = sprintf('%s %s', _POSTEDBY, $story->uname());
        $news['topic_title'] = $story->topic_title();

        if ($options[10] > 0) {
            $html = 1 == $story->nohtml() ? 0 : 1;
            //$html = $options[11] == 1 ? 0 : 1;
            $clearhtml = 1 == $options[8] ? 0 : 1;
            $smiley    = 1 == $options[12] ? 0 : 1;
            $xcode     = 1 == $options[13] ? 0 : 1;
            $image     = 1 == $options[14] ? 0 : 1;
            $br        = 1 == $options[15] ? 0 : 1;
            //--- for News versions prior to 1.60
            if ($module->getVar('version') <= 160) {
                $news['teaser'] = xoops_substr($myts->displayTarea(strip_tags($story->hometext)), 0, $options[10] + 3);
            } else {
                $news['teaser'] = news_truncate_tagsafe(strip_tags($myts->displayTarea($story->hometext, $html, $smiley, $xcode, $image, $br), $options[10] + 3));
            }
            if ($infotips > 0) {
                $news['infotips'] = ' title="' . news_make_infotips($story->hometext()) . '"';
            } else {
                $news['infotips'] = '';
            }
        } else {
            $news['teaser'] = '';
            if ($infotips > 0) {
                //$newsteaser = xoops_substr($myts->displayTarea(strip_tags($story->hometext)), 0, $options[10]+3);
                //---for news version 1.60+
                $news['teaser']   = news_truncate_tagsafe(strip_tags($myts->displayTarea($story->hometext, $html, $smiley, $xcode, $image, $br), $options[10] + 3));
                $news['infotips'] = ' title="' . news_make_infotips($newsteaser) . '" ';
            } else {
                $news['infotips'] = '';
            }
        }
        $block['stories'][] = $news;
    }
    $block['lang_read_more'] = _MB_NWS_READMORE;

    return $block;
}

//----
function b_scrolling_news_edit($options)
{
    global $xoopsDB;
    $myts = MyTextSanitizer:: getInstance();
    $form = "<table width='100%' border='0'  class='bg2'>";
    $form .= "<tr><th width='50%'>" . _OPTIONS . "</th><th width='50%'>" . _MB_NWS_SETTINGS . '</th></tr>';
    $form .= "<tr><td class='even'>" . _MB_NWS_BLIMIT . "</td><td class='odd'><input type='text' name='options[0]' size='16' maxlength=3 value='" . $options[0] . "'></td></tr>";
    $form .= "<tr><td class='even'>" . _MB_NWS_BSPEED . "</td><td class='odd'><input type='text' name='options[1]' size='16' maxlength=2 value='" . $options[1] . "'></td></tr>";
    $form .= "<tr><td class='even'>" . _MB_NWS_BACKGROUNDCOLOR . "</td><td class='odd'><input type='text' name='options[2]' size='16'  value='" . $options[2] . "'></td></tr>";
    //---
    $form .= "<tr><td class='even'>" . _MB_NWS_DIRECTION . "</td><td class='odd'><select name='options[3]'>";
    $form .= "<option value='up' " . (('up' === $options[3]) ? ' selected' : '') . '>' . _MB_NWS_UP . "</option>\n";
    $form .= "<option value='down' " . (('down' === $options[3]) ? ' selected' : '') . '>' . _MB_NWS_DOWN . "</option>\n";
    $form .= "</select></td></tr>\n";
    //---
    $form .= "<tr><td class='even'>" . _MB_NWS_ALTERNATE . "</td><td class='odd'>";
    $form .= "<input type='radio' name='options[4]' value='1'" . ((1 == $options[4]) ? ' checked' : '') . '>' . _YES . '&nbsp;';
    $form .= "<input type='radio' name='options[4]' value='0'" . ((0 == $options[4]) ? ' checked' : '') . '>' . _NO . '<br></td></tr>';
    //---
    $form .= "<tr><td class='even'>" . _MB_NWS_SHOWDATE . "</td><td class='odd'>";
    $form .= "<input type='radio' name='options[5]' value='1'" . ((1 == $options[5]) ? ' checked' : '') . '>' . _YES . '&nbsp;';
    $form .= "<input type='radio' name='options[5]' value='0'" . ((0 == $options[5]) ? ' checked' : '') . '>' . _NO . '<br></td></tr>';
    //---
    $form .= "<tr><td class='even'>" . _MB_NWS_DISP . "</td><td class='odd'><select name='options[6]'>";
    $form .= "<option value='0' " . (('0' == $options[6]) ? ' selected' : '') . '>' . _MB_NWS_MARQUEE . "</option>\n";
    $form .= "<option value='1' " . (('1' == $options[6]) ? ' selected' : '') . '>' . _MB_NWS_PAUSESCROLLER . "</option>\n";
    $form .= "<option value='2' " . (('2' == $options[6]) ? ' selected' : '') . '>' . _MB_NWS_DOMTICKER . "</option>\n";
    $form .= "</select></td></tr>\n";
    //---
    $form .= "<tr><td class='even'>" . _MB_NWS_SORT . "</td><td class='odd'><select name='options[7]'>";
    $form .= "<option value='RAND()' " . (('RAND()' === $options[7]) ? ' selected' : '') . '>' . _MB_NWS_RANDOM . "</option>\n";
    $form .= "<option value='published' " . (('published' === $options[7]) ? ' selected' : '') . '>' . _MB_NWS_DATE . "</option>\n";
    $form .= "<option value='counter' " . (('counter' === $options[7]) ? ' selected' : '') . '>' . _MB_NWS_HITS . "</option>\n";
    $form .= "<option value='title' " . (('title' === $options[7]) ? ' selected' : '') . '>' . _MB_NWS_NAME . "</option>\n";
    $form .= "</select></td></tr>\n";
    //---
    $form .= "<tr><td class='even'>" . _MB_NWS_ORDER . "</td><td class='odd'><select name='options[8]'>";
    $form .= "<option value='ASC' " . (('ASC' === $options[8]) ? ' selected' : '') . '>' . _ASCENDING . "</option>\n";
    $form .= "<option value='DESC' " . (('DESC' === $options[8]) ? ' selected' : '') . '>' . _DESCENDING . "</option>\n";
    $form .= "</select></td></tr>\n";
    //---
    $form .= "<tr><td class='even'>" . _MB_NWS_CHARS . "</td><td class='odd'><input type='text' name='options[9]' value='" . $options[9] . "'></td></tr>";
    $form .= "<tr><td class='even'>" . _MB_NWS_TEASER . " </td><td class='odd'><input type='text' name='options[10]' value='" . $options[10] . "'></td></tr>";
    //---
    $form .= "<tr><td class='even'>&nbsp; </td> <td class='odd'>&nbsp;</td></tr>";
    //---
    $form .= "<tr><td class='even'>" . _MB_NWS_HTML . "</td><td class='odd'>";
    $form .= "<input type='radio' name='options[11]' value='1'" . ((1 == $options[11]) ? ' checked' : '') . '>' . _YES . '&nbsp;';
    $form .= "<input type='radio' name='options[11]' value='0'" . ((0 == $options[11]) ? ' checked' : '') . '>' . _NO . '<br></td></tr>';
    //---
    $form .= "<tr><td class='even'>" . _MB_NWS_SMILEY . "</td><td class='odd'>";
    $form .= "<input type='radio' name='options[12]' value='1'" . ((1 == $options[12]) ? ' checked' : '') . '>' . _YES . '&nbsp;';
    $form .= "<input type='radio' name='options[12]' value='0'" . ((0 == $options[12]) ? ' checked' : '') . '>' . _NO . '<br></td></tr>';
    //---
    $form .= "<tr><td class='even'>" . _MB_NWS_XCODE . "</td><td class='odd'>";
    $form .= "<input type='radio' name='options[13]' value='1'" . ((1 == $options[13]) ? ' checked' : '') . '>' . _YES . '&nbsp;';
    $form .= "<input type='radio' name='options[13]' value='0'" . ((0 == $options[13]) ? ' checked' : '') . '>' . _NO . '<br></td></tr>';
    //---
    $form .= "<tr><td class='even'>" . _MB_NWS_BR . "</td><td class='odd'>";
    $form .= "<input type='radio' name='options[14]' value='1'" . ((1 == $options[14]) ? ' checked' : '') . '>' . _YES . '&nbsp;';
    $form .= "<input type='radio' name='options[14]' value='0'" . ((0 == $options[14]) ? ' checked' : '') . '>' . _NO . '<br></td></tr>';
    //---
    $form .= "<tr><td class='even'>" . _MB_NWS_IMAGE . "</td><td class='odd'>";
    $form .= "<input type='radio' name='options[15]' value='1'" . ((1 == $options[15]) ? ' checked' : '') . '>' . _YES . '&nbsp;';
    $form .= "<input type='radio' name='options[15]' value='0'" . ((0 == $options[15]) ? ' checked' : '') . '>' . _NO . '<br></td></tr>';
    //--- get allowed topics
    $form         .= "<tr><td class='even'>" . _MB_NWS_TOPICS . "</td><td class='odd'><select id=\"options[16]\" name=\"options[]\" multiple=\"multiple\">";
    $isAll        = empty($options[16]) ? true : false;
    $options_tops = array_slice($options, 16);
    require_once XOOPS_ROOT_PATH . '/class/xoopsstory.php';
    $xt        = new \XoopsTopic($xoopsDB->prefix('topics'));
    $alltopics = $xt->getTopicsList();
    ksort($alltopics);
    $form .= '<option value="0" ';
    if ($isAll) {
        $form .= ' selected="selected"';
    }
    $form .= '>' . _ALL . '</option>';
    foreach ($alltopics as $topicid => $topic) {
        $sel  = ($isAll || in_array($topicid, $options_tops)) ? ' selected' : '';
        $form .= "<option value=\"$topicid\" $sel>" . $topic['title'] . '</option>';
    }
    $form .= '</select></td></tr>';
    $form .= '</table>';

    //--------
    return $form;
}
