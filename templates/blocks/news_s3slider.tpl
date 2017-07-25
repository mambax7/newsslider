<script type="text/javascript" src="<{$xoops_url}>/modules/newsslider/assets/js/jquery.min.js"></script>
<script type="text/javascript" src="<{$xoops_url}>/modules/newsslider/assets/js/s3Slider.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#slider').s3Slider({
            timeOut: <{$block.speed}>000
        });
    });
</script>
<div id="slider">
    <ul id="sliderContent">
        <{foreach item=news from=$block.stories}>
            <li class="sliderImage">
                <a href="<{$xoops_url}>/modules/news/article.php?storyid=<{$news.id}>"><img
                            src="<{$xoops_url}>/modules/newsslider/assets/images/s3/<{$news.picture}>"
                            alt="<{$news.title}>">
                    <span class="<{$news.class}>"><strong><{$news.title}></strong><br><{if $block.author}><{$news.author}><{/if}> <{if $block.includedate}><{$news.date}>: <{/if}> <{$news.teaser}></span>
            </li>
        <{/foreach}>
        <div class="clear sliderImage"></div>
    </ul>
</div>
<!-- // slider -->
