<{if $block.style == '0'}>
    <marquee onmouseover="this.stop();"
             onmouseout="this.start();"
             direction='<{$block.direction}>'
             style='width:100%;height:160px;'
             bgcolor='<{$block.bgcolor}>'
             scrollamount='<{$block.speed}>'
             scrolldelay='5'
            <{if $block.alternate}>
                behavior='alternate'
            <{/if}>
    >

        <{foreach item=news from=$block.stories}>
            <li style="display:outline; margin:5px; padding:0;list-style-type: none;list-style-position: outside;">
                <{$news.topic_title}> - <a style="cursor:help;"
                                           href="<{$xoops_url}>/modules/news/article.php?storyid=<{$news.id}>" <{$news.infotips}>><{$news.title}></a>
                <{if $block.includedate}>
                    <div style='color: gray; font-size: 85%;'><{$term.date}></div>
                <{/if}>
                <div><{$news.teaser}></div>
                <br>
            </li>
            <br>
        <{/foreach}>
    </marquee>
<{elseif $block.style=='1'}>
    <style type="text/css">
        #pscroller<{$block.divid}> {
            width: 99%;
            height: 160px;
            padding: 4px;
            background-color: <{$block.bgcolor}>;
        }

        #pscroller<{$block.divid}> a {
            background-color: #e6e6e6;
            display: inline;
            margin: 0;
            padding: 2px;
            text-decoration: none;
        }

        #date {
            color: gray;
            font-size: 85%;
        }

        .someclass { /*class to apply to your scroller(s) if desired*/
        }
    </style>
    <script type="text/javascript">
        var newsslidercontent = new Array()
        $i = 0;
        <{foreach item=news from=$block.stories}>
        newsslidercontent[++$i] = '<{$news.url}><{$news.topic_title}> - <{$news.title}></a><{if $block.includedate}><div id="date"><{$news.date}></div><{/if}><br><br><div><{$news.teaser}></div>'
        <{/foreach}>
    </script>
    <script type="text/javascript" src="<{$xoops_url}>/modules/newsslider/assets/js/pausescroller.js"></script>
    <script type="text/javascript">
        //new pausescroller(name_of_message_array, CSS_ID, CSS_classname, pause_in_miliseconds)
        new pausescroller(newsslidercontent, "pscroller<{$block.divid}>", "someclass", <{$block.speed}>000)
    </script>
<{else}>
    <style type="text/css">
        #domcontent<{$block.divid}> {
            width: 98%;
            height: 160px;
            padding: 4px;
            background-color: <{$block.bgcolor}>;
        }

        #domcontent<{$block.divid}> a {
            background-color: #e6e6e6;
            display: inline;
            margin: 0;
            padding: 2px;
            text-decoration: none;
        }

        #domcontent<{$block.divid}> div { /*IE6 bug fix when text is bold and fade effect (alpha filter) is enabled. Style inner DIV with same color as outer DIV*/
            background-color: <{$block.bgcolor}>;
        }

        #date {
            color: gray;
            font-size: 85%;
        }

        .someclass { /*class to apply to your scroller(s) if desired*/
        }
    </style>
    <script type="text/javascript">
        var domcontent = new Array()
        $i = 0;
        <{foreach item=news from=$block.stories}>
        domcontent[++$i] = '<{$news.url}><{$news.topic_title}> - <{$news.title}></a><{if $block.includedate}><div id="date"><{$news.date}></div><{/if}><br><br><div><{$news.teaser}></div>'
        <{/foreach}>
    </script>
    <script type="text/javascript" src="<{$xoops_url}>/modules/newsslider/assets/js/domticker.js"></script>
    <script type="text/javascript">
        //new domticker(name_of_message_array, CSS_ID, CSS_classname, pause_in_miliseconds, optionalfadeswitch)
        new domticker(domcontent, "domcontent<{$block.divid}>", "someclass", <{$block.speed}>000, "fadeit")
    </script>
<{/if}>
