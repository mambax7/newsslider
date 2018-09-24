/* Expandable Drop Down Ticker
* Author: Dynamic Drive at http://www.dynamicdrive.com/
* Visit http://www.dynamicdrive.com/ for full source code
* Last Edited: Jan 25th, 2010
*/

var expandticker={
    buttonhtml: '<img src="expand.jpg" style="width:70px; height:17px; cursor:pointer" />', //HTML of "expand" button
    buttonoffset: [5, -10], //offset of button from lower left edge of ticker
    //No need to edit beyond here

    dsetting: {snippetlength:30, manual:false, timers: {rotatepause:3000, fxduration:300}},
    effectfuncts: ['fadeIn', 'slideDown'],

fetchajaxcontent:function($, s){
window.status+='x'
    clearTimeout(s.playtimer) //clear timers and remove $button, $menu if fetchajaxcontent() is being called more than once
    clearTimeout(s.pausetimer)
    clearTimeout(s.refreshtimer)
    if (s.$button){
        s.$button.remove()
        s.$menu.remove()
    }
    s.$ticker.html("(Re)Fetching Ticker Contents...")
    $.ajax({
        url: s.remotecontent[0],
        dataType: 'html',
        error:function(ajaxrequest){
            s.$ticker.html('Error fetching content.<br />Server Response: '+ajaxrequest.responseText)
        },
        success:function(content){
            s.$ticker.html(content)
            expandticker.setup($, s)
            if (s.remotecontent[1]>5000) //5 secs minimum time allowed between updates
                s.refreshtimer=setTimeout(function(){expandticker.fetchajaxcontent($, s)}, s.remotecontent[1])
            else if (s.remotecontent[1]>0) //if value is NOT 0 (0=never refetch)
                alert("Please Enter a value larger than 5 (sec) for the time between Ajax updates")
        }
    })
},

getmsgtitles:function(s){
    var titlearray=[]
    for (var i=0; i<s.msglength; i++){
        var title=s.$contents.eq(i).attr('title') || s.$contents.eq(i).text().substring(0, s.snippetlength)+' ...' //extract snippet of message
        titlearray.push(title)
    }
    return titlearray
},

adddropmenu:function($, s){
    var titles=this.getmsgtitles(s)
    var $lis=$([])
    var $menu=$('<ul class="dropdownlist"></ul>')
    for (var i=0; i<s.msglength; i++){ //construct a new LI element for each ticker message title
        $lis=$lis.add($('<li/>').html((i+1)+". "+titles[i]).wrapInner('<a href="#message'+(i+1)+'" data-pos="'+i+'"></a>'))
    }
    $menu.append($lis).hide().unbind('click').click(function(e){ //go to particular message when menu title is clicked on
        if (e.target.tagName=="A"){
            clearTimeout(s.playtimer)
            s.curmsg=parseInt(e.target.getAttribute('data-pos'))
            expandticker.selectmsg($, s, s.curmsg)
            if (!s.manual)
                s.playtimer=setTimeout(function(){expandticker.rotatemsg($, s)}, s.timers.rotatepause)
            e.preventDefault()
        }
    })
    $menu.appendTo(document.body)
    $menu.data('state', 'closed') //indicate menu is currently closed
    s.$menu=$menu //remember $menu
    s.$menulis=$lis //remember $menu LIs
},

positionbutton:function($, s){
    var toffset=s.$ticker.offset()
    var buttonpos=[toffset.left+this.buttonoffset[0], toffset.top+s.$ticker.outerHeight()+this.buttonoffset[1]]
    s.$button.css({left:buttonpos[0], top:buttonpos[1]})
},

addexpandbutton:function($, s){
    s.$button=$(this.buttonhtml).css({position:'absolute', zIndex:1000}).appendTo(document.body) //create expand button, add it to page, and remember it
    this.positionbutton($, s)
    this.adddropmenu($, s)
    s.$button.unbind('click').bind('click', function(e){ //show menu when expand button is clicked
        s.$menu.css({left:s.$button.css('left'), top:parseInt(s.$button.css('top'))-expandticker.buttonoffset[1]}).show()
        s.$menulis.removeClass('selected').eq(s.curmsg).addClass('selected') //highlight current message within menu
        s.$menu.data('state', 'open') //indicate menu is open
        e.stopPropagation()
    })
},


selectmsg:function($, s, selected){
    s.$contents.stop(true,true).hide().eq(selected)[s.effectfunct](s.timers.fxduration, function(){  //animate message into view
        if (this.style && this.style.removeAttribute)
            this.style.removeAttribute('filter') //fix IE clearType problem when animation is fade-in
    })
    s.curmsg=selected
    if (s.$menu.data('state')=="open")
        s.$menulis.removeClass('selected').eq(selected).addClass('selected') //highlight current message within menu
},

rotatemsg:function($, s){
    if (s.$ticker.data('state')=="over"){ //pause ticker onMouseover
        clearTimeout(s.pausetimer)
        s.pausetimer=setTimeout(function(){expandticker.rotatemsg($, s)}, 100)
        return
    }
    s.nextmsg=(s.curmsg<s.msglength-1)? s.curmsg+1 : 0 //go to next message
    this.selectmsg($, s, s.nextmsg)
    s.playtimer=setTimeout(function(){expandticker.rotatemsg($, s)}, s.timers.rotatepause)
},

setup:function($, s){
        s.$contents=s.$ticker.find('.expandcontent').hide()
        s.msglength=s.$contents.length
        s.curmsg=0
        expandticker.addexpandbutton($, s)
        expandticker.selectmsg($, s, s.curmsg)
        if (!s.manual){
            s.$ticker.unbind('mouseenter').bind('mouseenter', function(){$(this).data('state', 'over')})
            s.$ticker.unbind('mouseleave').bind('mouseleave', function(){$(this).data('state', 'out')})
            s.playtimer=setTimeout(function(){expandticker.rotatemsg($, s)}, s.timers.rotatepause)
        }
},


init:function(setting){
    jQuery(document).ready(function($){ //fire on DOM ready
        var s=setting
        s=jQuery.extend({}, expandticker.dsetting, s)
        s.timers.rotatepause+=s.timers.fxduration //add slide duration to rotate timer
        s.$ticker=$('#'+s.id)
        if (s.$ticker.length==0)
            return
        s.effectfunct=s.fx=="fade"? expandticker.effectfuncts[0] : expandticker.effectfuncts[1]
        if (s.remotecontent && s.remotecontent[0].length>0){
            s.remotecontent[1]=s.remotecontent[1]*1000 //convert units into seconds
            expandticker.fetchajaxcontent($, s)
        }
        else
            expandticker.setup($, s)
        $(window).bind('load resize', function(e){ //reposition enlarge images when window has loaded or is resized
            if (s.$button)
                setTimeout(function(){expandticker.positionbutton($, s)}, (e.type=="load")? 200 : 0)
        })
        $(document).click(function(){
            if (s.$menu){ //hide menu when user clicks anywhere on page
                s.$menu.hide()
                s.$menu.data('state', 'closed')
            }
        })

    })
}
}