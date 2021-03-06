<style type='text/css'>
    .glidecontentwrapper<{$block.divid}> {
        position: relative; /* Do not change this value */
        width: <{$block.width}>px;
        height: <{$block.height}>px;
        border: <{$block.border}>px solid <{$block.bordercolor}>;
        margin-left: 10px; /*seems centered*/
        overflow: hidden;
    }

    /* Total wrapper width: 350px+5px+5px=360px
        Or width of wrapper div itself plus any left and right CSS border and padding
        Adjust related containers below according to comments
    */
    .glidecontent<{$block.divid}> {
        position: absolute; /* Do not change this value */
        background: <{$block.bgcolor}>;
        padding: 10px;
        visibility: hidden;
        width: <{$block.wrapperwidth}>px;
    }

    #date {
        color: gray;
        font-size: 85%;
    }

    <{if $block.navi == '0' }>
    .glidecontenttoggler {
        width: <{$block.width}>px;
        margin-top: 6px;
        text-align: center;
        /*How to align pagination links: "left", "center", or "right"
       background:




    <{$block.bcolor}>     ; /*always declare an explicit background color for fade effect to properly render in IE*/
    }

    .glidecontenttoggler a { /*style for every navigational link within toggler */
        display: -moz-inline-box;
        display: inline-block;
        border: 1px solid black;
        color: #2e6ab1;
        padding: 1px 3px;
        margin-right: 3px;
        font-weight: bold;
        text-decoration: none;
    }

    .glidecontenttoggler a.selected {
        background: #E4EFFA;
        color: black;
    }

    .glidecontenttoggler a:hover {
        background: #E4EFFA;
        color: black;
    }

    /*for individual toggler links (page 1, page 2, etc). */
    .glidecontenttoggler a.toc {
    }

    .glidecontenttoggler a.prev, .glidecontenttoggler a.next {
    }

    .glidecontenttoggler a.prev:hover, .glidecontenttoggler a.next:hover {
        background: #1A48A4;
        color: white;
    }

    <{else}>
    .cssbuttonstoggler { /*style for DIV used to contain toggler links. */
        width: <{$block.width}>px;
        /*height:




    <{$block.height}>     px;*/
        margin-top: 6px;
        margin-left: 50px;
        text-align: center;
        background: <{$block.bgcolor}>;
        overflow: hidden;
    }

    .cssbuttonstoggler a { /*style for every navigational link within toggler */
        background: transparent url('<{$xoops_url}>/modules/newsslider/assets/images/square-gray-left.gif') no-repeat top left;
        color: #494949;
        display: block;
        float: left;
        margin-right: 6px;
        font: normal 13px Arial;
        line-height: 15px;
        height: 23px;
        padding-left: 9px;
        text-decoration: none;
    }

    .cssbuttonstoggler a span {
        background: transparent url('<{$xoops_url}>/modules/newsslider/assets/images/square-gray-right.gif') no-repeat top right;
        display: block;
        padding: 4px 9px 4px 0;
    }

    .cssbuttonstoggler a.selected, .cssbuttonstoggler a:hover {
        background-position: bottom left;
    }

    .cssbuttonstoggler a.selected span, .cssbuttonstoggler a:hover span {
        background-position: bottom right;
        color: black;
    }

    /*style for individual toggler links (page 1, page 2, etc). ".toc" class auto generated! */
    .cssbuttonstoggler a.toc {
    }

    .cssbuttonstoggler a.prev, .glidecontenttoggler-2 a.next {
    }

    .cssbuttonstoggler a.prev:hover, .glidecontenttoggler-2 a.next:hover {
    }

    <{/if}>
</style>
<script type="text/javascript" src="<{$xoops_url}>/modules/newsslider/assets/js/jquery-1.1.3.pack.js"></script>
<script type="text/javascript" src="<{$xoops_url}>/modules/newsslider/assets/js/featuredcontentglider.js">
    /***********************************************
     * Featured Content Glider script- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
     * Visit http://www.dynamicDrive.com for hundreds of DHTML scripts
     * This notice must stay intact for legal use
     ***********************************************/
</script>
<script type="text/javascript">
    featuredcontentglider.init({
        gliderid: "<{$block.divid}>", //ID of main glider container
        contentclass: "glidecontent<{$block.divid}>", //Shared CSS class name of each glider content
        togglerid: "p-select<{$block.divid}>", //ID of toggler container
        remotecontent: "", //Get gliding contents from external file on server? "filename" or "" to disable
        selected: 0, //Default selected content index (0=1st)
        persiststate: <{$block.persiststate}>, //Remember last content shown within browser session (true/false)?
        speed: <{$block.speed}>00, //Glide animation duration (in milliseconds)
        direction: "<{$block.direction}>", //set direction of glide: "updown", "downup", "leftright", or "rightleft"
        autorotate: <{$block.autorotate}>, //Auto rotate contents (true/false)?
        autorotateconfig: [<{$block.speed}>000, <{$block.acycles}>] //if auto rotate enabled, set [milliseconds_btw_rotations, cycles_before_stopping]
    })

</script>

<div id="<{$block.divid}>" class="glidecontentwrapper<{$block.divid}>">
    <{foreach item=news from=$block.stories}>
        <div class="glidecontent<{$block.divid}>">
            <{*<{if $block.sort=='counter'}>
                  [<{$news.hits}>]
                <{elseif $block.sort=='published'}>
                  [<{$news.date}>]
                <{else}>
                  [<{$news.rating}>]
               <{/if}>
            *}>
            <{$news.topic_title}> - <a style="cursor:help;"
                                       href="<{$xoops_url}>/modules/news/article.php?storyid=<{$news.id}>" <{$news.infotips}>>
                <{$news.title}></a>
            <{if $block.includedate}>
            <div id="date"><{$news.date}></div><{/if}><br>
            <div><{$news.teaser}></div>
        </div>
    <{/foreach}>
</div>

<{if $block.navi == '0' }>
    <div id="p-select<{$block.divid}>" class="glidecontenttoggler">
        <a href="#" class="prev"><{$smarty.const._MB_NWS_BACK}></a>
        <a href="#" class="toc">News 1</a> <a href="#" class="toc">News 2</a> <a href="#" class="toc">News 3</a>
        <a href="#" class="next"><{$smarty.const._MB_NWS_FORWARD}></a>
    </div>
<{else}>
    <div id="p-select<{$block.divid}>" class="cssbuttonstoggler">
        <a href="#" class="prev"><span><{$smarty.const._MB_NWS_BACK}></span></a>
        <{foreach item=news from=$block.stories}>
            <a href="#" class="toc"><span><{$news.no}></span></A>
        <{/foreach}>
        <a href="#" class="next"><span><{$smarty.const._MB_NWS_FORWARD}></span></a>
    </div>
<{/if}>
