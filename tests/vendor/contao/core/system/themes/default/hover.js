var Theme={hoverRow:function(e,t){for(var i=$(e).getChildren(),n=0;n<i.length;n++)"td"==i[n].nodeName.toLowerCase()&&i[n].setStyle("background-color",t?"#ebfdd7":"")},hoverDiv:function(e,t){t||e.removeAttribute("data-visited"),$(e).setStyle("background-color",t?"#ebfdd7":"")},fixLabelLastChild:function(){(Browser.ie7||Browser.ie8)&&$$(".tl_checkbox_container label:last-child").each(function(e){e.setStyle("margin-bottom",0)})},stopClickPropagation:function(){$$(".picker_selector").each(function(e){e.getElements("a").each(function(e){e.addEvent("click",function(e){e.stopPropagation()})})}),$$(".picker_selector,.click2edit").each(function(e){e.getElements('input[type="checkbox"]').each(function(e){e.addEvent("click",function(e){e.stopPropagation()})})})},setupCtrlClick:function(){$$(".click2edit").each(function(e){e.getElements("a").each(function(e){e.addEvent("click",function(e){e.stopPropagation()})}),Browser.Features.Touch?e.addEvent("click",function(){e.getAttribute("data-visited")?(e.getElements("a").each(function(e){e.hasClass("edit")&&(document.location.href=e.href)}),e.removeAttribute("data-visited")):e.setAttribute("data-visited","1")}):e.addEvent("click",function(t){var i=Browser.Platform.mac?t.event.metaKey:t.event.ctrlKey;i&&t.event.shiftKey?e.getElements("a").each(function(e){e.hasClass("editheader")&&(document.location.href=e.href)}):i&&e.getElements("a").each(function(e){e.hasClass("edit")&&(document.location.href=e.href)})})})},setupTextareaResizing:function(){$$(".tl_textarea").each(function(e){if(!(Browser.ie6||Browser.ie7||Browser.ie8||e.hasClass("noresize")||e.retrieve("autogrow"))){var t=new Element("div",{html:"X",styles:{position:"absolute",top:0,left:"-999em","overflow-x":"hidden"}}).setStyles(e.getStyles("font-size","font-family","width","line-height")).inject(document.body),i=t.clientHeight;e.addEvent("input",function(){t.set("html",this.get("value").replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/\n|\r\n/g,"<br>X"));var e=Math.max(i,t.getSize().y);this.clientHeight!=e&&this.tween("height",e)}).set("tween",{duration:100}).setStyle("height",i+"px"),e.fireEvent("input"),e.store("autogrow",!0)}})}};window.addEvent("domready",function(){Theme.fixLabelLastChild(),Theme.stopClickPropagation(),Theme.setupCtrlClick(),Theme.setupTextareaResizing()}),window.addEvent("ajax_change",function(){Theme.stopClickPropagation(),Theme.setupCtrlClick(),Theme.setupTextareaResizing()});