<script type="text/javascript" src="<{$xoops_url}>/modules/newsslider/assets/js/jquery.min.js"></script>
<script type="text/javascript" src="<{$xoops_url}>/modules/newsslider/assets/js/jquery-ui.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#featured").tabs({fx: {opacity: "toggle"}}).tabs("rotate", <{$block.speed}>000, true);
        $("#featured").hover(
                function () {
                    $("#featured").tabs("rotate", 0, true);
                },
                function () {
                    $("#featured").tabs("rotate", <{$block.speed}>000, true);
                }
        );
    });
</script>

<div id="featured">
    <ul class="ui-tabs-nav">
        <{foreach item=news from=$block.stories}>
            <li style="list-style:none outside none;"
                class="ui-tabs-nav-item <{if $news.no == 0}>ui-tabs-selected<{/if}>" id="nav-fragment-<{$news.no}>"><a
                        href="#fragment-<{$news.no}>"><img
                            src="<{$xoops_url}>/modules/newsslider/assets/images/<{$news.thumb}>"
                            alt="<{$news.topic_title}> - <{$news.title}>"><span><{$news.title}>
                        <br> <{if $block.includedate}>
                            <span
                                    id="date"><{$news.date}></span>
                            <br>
                        <{/if}></span><{if $block.author}><span id="date"><{$news.author}></span><{/if}></span></a></li>
        <{/foreach}>
    </ul>

    <{foreach item=news from=$block.stories}>
        <!-- <{$news.no}>. Content -->
        <div id="fragment-<{$news.no}>" class="ui-tabs-panel<{if $news.no != 0}> ui-tabs-hide<{/if}>" style="">
            <img src="<{$xoops_url}>/modules/newsslider/assets/images/<{$news.picture}>"
                 alt="<{$news.topic_title}> - <{$news.title}>">
            <div class="info">
                <h2><a href="<{$xoops_url}>/modules/news/article.php?storyid=<{$news.id}>">
                    <{$news.title}></a></h2>
                <p><{$news.teaser}> <a
                            href="<{$xoops_url}>/modules/news/article.php?storyid=<{$news.id}>"><{$smarty.const._MB_NWS_READMORE}></a>
                </p>
            </div>
        </div>
    <{/foreach}>
</div>
