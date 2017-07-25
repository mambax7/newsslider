<script type="text/javascript" src="<{$xoops_url}>/modules/newsslider/assets/js/jquery.min.js"></script>
<script type="text/javascript" src="<{$xoops_url}>/modules/newsslider/assets/js/jquery.bxSlider.min.js"></script>
<{if $block.easing}>
    <script type="text/javascript" src="<{$xoops_url}>/modules/newsslider/assets/js/jquery.easing.1.3.js"></script>
<{/if}>
<{*
$block.mode == 0 - horizontal
$block.mode == 1 - vertical
$block.mode == 2 - fade
$block.mode == 3 - ticker
*}>
<script type="text/javascript">
    $(document).ready(function () {
        $("#slider1").bxSlider({
            <{if $block.mode == '3'}>
            ticker: true,
            tickerSpeed: <{$block.tickerspeed}>00,
            <{elseif  $block.mode == '0'}>
            auto: true,
            <{elseif $block.mode == '1'}>
            mode: 'vertical',
            auto: true,
            <{elseif  $block.mode == '2'}>
            mode: 'fade',
            auto: true,
            <{/if}>
            infiniteLoop: <{$block.loop}>,
            hideControlOnEnd: true,
            autoHover: true,
            easing: '<{$block.easing}>',
            captions: <{$block.captions}>,
            pause: <{$block.speed}>000,
            pager: <{$block.controls}>,
            autoControls: false,
            controls: false
        });
    });
</script>
<ul id="slider1">
    <{foreach item=news from=$block.stories}>
        <li>
            <img <{if $block.float == 1}>style="float:left; padding:0px;"
                 <{elseif $block.float == 2}>style="float:right;padding:2px;"<{/if}>
                 src="<{$xoops_url}>/modules/newsslider/assets/images/<{$news.picture}>" width="<{$block.imgwidth}>%"
                 title="<{$news.topic_title}> - <{$news.title}>"
                 alt="<{$news.topic_title}> - <{$news.title}>">
            <div class="bxcontent">
                <a style="cursor:help;"
                   href="<{$xoops_url}>/modules/news/article.php?storyid=<{$news.id}>" <{$news.infotips}>>
                    <h4><{$news.title}></h4></A>
                <p><{if $block.topictitle}><{$news.topic_title}><br><{/if}>
                    <{if $block.author}><span id="date"><{$news.author}></span><br><{/if}>
                    <{if $block.includedate}>
                <div id="date"><{$news.date}></div>
                <{/if}></p>
                <p <{if $block.textalign == 1}>style="text-align:left;"
                   <{elseif $block.textalign == 2}>style="text-align:right;"
                   <{elseif $block.textalign == 3}>style="text-align:justify;"<{/if}>><{$news.teaser}> <a
                            href="<{$xoops_url}>/modules/news/article.php?storyid=<{$news.id}>"><{$smarty.const._MB_NWS_READMORE}></a>
                </p>
            </div>
        </li>
    <{/foreach}>
</ul>
<div class="clear"></div>
