<html>
    <head>
        <!-- this should go after your </body> -->
        <link rel="stylesheet" type="text/css" href="st_includes/css/magicsuggest-min.css" >
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.0/jquery.js"></script>
        
        <script src="st_includes/js/picker2.js"></script>
        <script src="st_includes/js/timer.js"></script>
        
        
<style>.wrapper { max-width: 1200px; }
a, .wk-slideshow .caption a { color: #007ED2; }
a:hover, #toolbar ul.menu li a:hover span, .menu-sidebar a.current, #Kunena dl.tabs dt:hover, .menu-sidebar a:hover, menu-sidebar li > span:hover, .footer-body a:hover  {color: #009AD2}
body { color: #606060; }
#toolbar time, #toolbar p, #toolbar ul.menu li span { color: #606060; }
#showcase .module-title, #showcase .module-title span.subtitle, #showcase, #showcase h1, #showcase h2, #showcase h3 { color: #FFFFFF; }
body { background-color: #EDEDED !important; }
::selection{ background: #B5DAFF !important;}
::-moz-selection{ background: #B5DAFF !important;}
::-webkit-selection { background: #B5DAFF !important;}
#copyright p, #footer p { color: #8C8C8C; }
#copyright a { color: #007ED2; }
#copyright a:hover { color: #009AD2; }
.menu-dropdown .dropdown-bg > div { background-color: #FCFCFC; }
.menu-dropdown a.level1, .menu-dropdown span.level1, .menu-dropdown a.level2, .menu-dropdown span.level2, .menu-dropdown a.level3, .menu-dropdown span.level3, #call-us h1 { color: #404040; }
.level1 span.subtitle { color: #505050; }
.menu-dropdown li.level2 a:hover { background-color: #3B8BDA; }
.menu-dropdown a.level2:hover, .menu-dropdown a.level3:hover, .menu-dropdown a.level2:hover span.subtitle { color: #FFFFFF; }
.menu-dropdown a.current.level2, .menu-dropdown a.current.level3 { background-color: #3B8BDA; }
.menu-dropdown a.current.level2, .menu-dropdown a.current.level3, .menu-dropdown a.current.level2 span.subtitle { color: #FFFFFF; }
.colored .menu-sidebar a, .colored .menu-sidebar li > span { color: #404040; }
.colored .menu-sidebar a:hover, .colored .menu-sidebar li > span:hover { color: #FFFFFF; }
.colored .menu-sidebar li.level1:hover, .colored .menu-sidebar a.level1:hover > span, .colored .menu-sidebar span.level1:hover > span { color: #FFFFFF; }
.colored .menu-sidebar a.level1.active > span, .colored .menu-sidebar span.level1:hover > span, .menu-sidebar .level2.active a > span { color: #FFFFFF; }
.colored .menu-sidebar a.level1:hover, .colored .menu-sidebar span.level1:hover, .colored .menu-sidebar a.level2:hover, .colored .menu-sidebar span.level2:hover{ background-color: #007ED2 !important; }
.colored .menu-sidebar li.level1.active, .colored .menu-sidebar a.level2.active, .colored .menu-sidebar span.level2.active { background-color: #007ED2; }
h1 strong, h2 strong, h3 strong, h4 strong, h5 strong, h6 strong, .module-title .color { color: #808080; }
.module .module-title span.subtitle { color: #808080; }
h1, h2, h3, h4, h5, h6, blockquote strong, blockquote p strong, .result h3, header h1.title a{ color: #007ED2 !important; }
.header-content .module-title, .header-content { color: #132; }
a.button-color, button.button-color, input[type="submit"].button-color, input[type="submit"].subbutton, input[type="reset"].button-color, input[type="button"].button-color, #content .pagination strong, .event-time .month, .block-number .bottom, .section-title,  ul.white-top a.current, ul.white-top a.current:hover,  #kunena input[type="submit"].kbutton, #Kunena .klist-markallcatsread input.kbutton, #Kunena .kicon-button.kbuttoncomm, #kunena .kbutton.kreply-submit, #Kunena .kbutton-container button.validate, #kpost-buttons input[type="submit"].kbutton, #Kunena span.kheadbtn a{ background-color: #007ED2 !important; }
a.button-color, button.button-color, input[type="submit"].button-color, input[type="submit"].subbutton, input[type="reset"].button-color, input[type="button"].button-color, #content .pagination strong, .event-time .month, .block-number .bottom, .section-title,  ul.white-top a.current, ul.white-top a.current:hover,  #kunena input[type="submit"].kbutton, #Kunena .klist-markallcatsread input.kbutton, #Kunena .kicon-button.kbuttoncomm span, #kunena .kbutton.kreply-submit, #Kunena .kbutton-container button.validate,  #kpost-buttons input[type="submit"].kbutton, #Kunena span.kheadbtn a, li.price-tag, .th .title { color: #FFFFFF !important; }
a.button-color, button.button-color, input[type="submit"].button-color, input[type="submit"].subbutton, input[type="reset"].button-color, input[type="button"].button-color, #content .pagination strong, .event-time .month, .block-number .bottom, #kunena input[type="submit"].kbutton, #Kunena .klist-markallcatsread input.kbutton, #Kunena .kicon-button.kbuttoncomm, #kunena .kbutton.kreply-submit,  #Kunena .kbutton-container button.validate, #kpost-buttons input[type="submit"].kbutton, #Kunena span.kheadbtn a { border-color: #0070BA !important; }
.sprocket-mosaic-filter li.active, .sprocket-mosaic-hover, .sprocket-mosaic-filter li.active, .gkTabsWrap.vertical ol li.active, .gkTabsWrap.vertical ol li.active:hover { background: #000 !important; }
.gkTabsWrap.vertical ol li.active, .gkTabsWrap.vertical ol li.active:hover, .sprocket-mosaic-filter li.active { border-color: #000 !important; }
.sprocket-mosaic-filter li.active, .sprocket-mosaic-hover, .gkTabsWrap.vertical ol li.active, .gkTabsWrap.vertical ol li.active:hover { color: #000 !important; }
.tag-body, .tag-body:hover, .tag-body, .tag-body .tag:before { color: #FFFFFF !important; }
.tag-body, .tag-body .tag:before { background-color: #2579D5; }
.mejs-controls .mejs-time-rail .mejs-time-loaded { background-color: #007ED2 !important; }
.mod-color { background-color: #007ED2 !important; }
.mod-color { border: 1px solid #0063A6 !important; }
.mod-color, .mod-color h1 { color: #FFFFFF !important; }
.sprocket-mosaic-image-container img { border-bottom-color: #000; }
.price-tag { background-color: #1B77D2 !important; }
.th .bottom, .th { background-color: #1971B5; }
#Kunena .kwho-admin { color: #FF7014; }
#Kunena .kwho-globalmoderator { color: #586900; }
#Kunena .kwho-moderator { color: #9E1600; }
#Kunena .kwho-user { color: #3463AA; }
#Kunena .kwho-banned, #Kunena a.kwho-banned { color: #A39D49; }
#Kunena .kwho-guest { color: #808080; }
#sidebar-b { width: 26%; }
#maininner { width: 74%; }
#menu .dropdown { width: 200px; }
#menu .columns2 { width: 400px; }
#menu .columns3 { width: 600px; }
#menu .columns4 { width: 800px; }</style>        
        
    </head>
    <body>
        <input id="datetimepicker_mask" type="text" value="">
    </body>
</html>
<?php
echo "Hola";
?>