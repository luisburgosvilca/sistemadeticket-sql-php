<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>jQuery Simple Datepicker</title>
<style>
#page {
    width: 980px;
    margin: 0 auto;
}
#header {
    height: 100px;
	border:1px solid #CCCCCC;
	margin-bottom:10px;
	text-align:center;
}
#content {
    width: 100%;
    float: left;
}

#footer {
    border: 1px solid #CCCCCC;
    float: left;
    height: 50px;
    margin-top: 10px;
    padding: 10px;
    width: 960px;
}
@media screen and (max-width: 980px) {

    #page { width: 100%; }
    #content { width: 100%; }
}

@media screen and (max-width: 700px) {

    #content, #footer {
        width: auto;
        float: none;
	height:auto;
    }
	
    #header h1 {
            font-size:small;
    }
}
</style>
<!--[if lt IE 9]>
<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
<![endif]-->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript" src="st_includes/js/jquery.simple-dtpicker.js"></script>
<link type="text/css" href="st_includes/css/jquery.simple-dtpicker.css" rel="stylesheet">
<script type="text/javascript">
$(function(){
    $('#date_picker').dtpicker();
});
</script>
</head>

<body style="">
<div id="page">
    <div id="header">
    	<h1>jQuery Simple Datepicker</h1>
    </div>
    <div id="content">
<input id="date_picker" name="date" value="" type="text">
<script type="text/javascript">
$(function(){
    $('*[name=date]').appendDtpicker({"locale": "es"});
});
</script>
    </div>

    <div id="footer">
    	<iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.facebook.com%2Fpages%2FBlog-Jose-Aguilar-Desarrollo-Web%2F269898786396364&amp;send=false&amp;layout=standard&amp;width=450&amp;show_faces=false&amp;font=lucida+grande&amp;colorscheme=light&amp;action=like&amp;height=35&amp;appId=283652475068166" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:35px;" allowtransparency="true"></iframe>
    </div>
</div>


<div style="position: absolute; z-index: 100000; top: 142px; left: 310px;"><div class="datepicker" style="width: auto; display: none;"><div class="datepicker_header"><a class="icon-home" title="Today"><!--?xml version="1.0" encoding="UTF-8" standalone="no"?--><svg xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:cc="http://creativecommons.org/ns#" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" version="1.1" width="100%" height="100%" viewBox="0 0 10 10"><g transform="translate(-5.5772299,-26.54581)"><path d="m 14.149807,31.130932 c 0,-0.01241 0,-0.02481 -0.0062,-0.03721 L 10.57723,28.153784 7.0108528,31.093719 c 0,0.01241 -0.0062,0.02481 -0.0062,0.03721 l 0,2.97715 c 0,0.217084 0.1798696,0.396953 0.3969534,0.396953 l 2.3817196,0 0,-2.38172 1.5878132,0 0,2.38172 2.381719,0 c 0.217084,0 0.396953,-0.179869 0.396953,-0.396953 l 0,-2.97715 m 1.383134,-0.427964 c 0.06823,-0.08063 0.05582,-0.210882 -0.02481,-0.279108 l -1.358324,-1.128837 0,-2.530576 c 0,-0.111643 -0.08683,-0.198477 -0.198477,-0.198477 l -1.190859,0 c -0.111643,0 -0.198477,0.08683 -0.198477,0.198477 l 0,1.209467 -1.513384,-1.265289 c -0.2605,-0.217083 -0.682264,-0.217083 -0.942764,0 L 5.6463253,30.42386 c -0.080631,0.06823 -0.093036,0.198476 -0.024809,0.279108 l 0.3845485,0.458976 c 0.031012,0.03721 0.080631,0.06203 0.1302503,0.06823 0.055821,0.0062 0.1054407,-0.01241 0.1488574,-0.04342 l 4.2920565,-3.578782 4.292058,3.578782 c 0.03721,0.03101 0.08063,0.04342 0.13025,0.04342 0.0062,0 0.01241,0 0.01861,0 0.04962,-0.0062 0.09924,-0.03101 0.130251,-0.06823 l 0.384549,-0.458976"></path></g></svg></a><a title="Previous month">&lt;</a><span>2019 - may</span><a title="Next month">&gt;</a></div><div class="datepicker_inner_container"><div class="datepicker_calendar"><table class="datepicker_table"><tbody><tr><th>dom</th><th>lun</th><th>mar</th><th>miér</th><th>jue</th><th>vié</th><th>sáb</th></tr><tr><td class="day_another_month wday_sun">28</td><td class="day_another_month">29</td><td class="day_another_month">30</td><td>1</td><td>2</td><td>3</td><td class="wday_sat">4</td></tr><tr><td class="wday_sun">5</td><td>6</td><td>7</td><td>8</td><td>9</td><td>10</td><td class="wday_sat">11</td></tr><tr><td class="wday_sun">12</td><td>13</td><td class="active">14</td><td>15</td><td>16</td><td class="today">17</td><td class="wday_sat">18</td></tr><tr><td class="wday_sun">19</td><td>20</td><td>21</td><td>22</td><td>23</td><td>24</td><td class="wday_sat">25</td></tr><tr><td class="wday_sun">26</td><td>27</td><td>28</td><td>29</td><td>30</td><td>31</td><td class="day_another_month wday_sat">1</td></tr></tbody></table></div><div class="datepicker_timelist" style="height: 0px;"><div class="timelist_item">00:00</div><div class="timelist_item">00:30</div><div class="timelist_item">01:00</div><div class="timelist_item">01:30</div><div class="timelist_item">02:00</div><div class="timelist_item">02:30</div><div class="timelist_item">03:00</div><div class="timelist_item">03:30</div><div class="timelist_item">04:00</div><div class="timelist_item">04:30</div><div class="timelist_item">05:00</div><div class="timelist_item">05:30</div><div class="timelist_item">06:00</div><div class="timelist_item">06:30</div><div class="timelist_item">07:00</div><div class="timelist_item">07:30</div><div class="timelist_item">08:00</div><div class="timelist_item">08:30</div><div class="timelist_item">09:00</div><div class="timelist_item">09:30</div><div class="timelist_item">10:00</div><div class="timelist_item">10:30</div><div class="timelist_item">11:00</div><div class="timelist_item">11:30</div><div class="timelist_item">12:00</div><div class="timelist_item">12:30</div><div class="timelist_item">13:00</div><div class="timelist_item">13:30</div><div class="timelist_item">14:00</div><div class="timelist_item">14:30</div><div class="timelist_item">15:00</div><div class="timelist_item">15:30</div><div class="timelist_item">16:00</div><div class="timelist_item">16:30</div><div class="timelist_item">17:00</div><div class="timelist_item">17:30</div><div class="timelist_item">18:00</div><div class="timelist_item">18:30</div><div class="timelist_item">19:00</div><div class="timelist_item">19:30</div><div class="timelist_item">20:00</div><div class="timelist_item">20:30</div><div class="timelist_item">21:00</div><div class="timelist_item">21:30</div><div class="timelist_item">22:00</div><div class="timelist_item">22:30</div><div class="timelist_item">23:00</div><div class="timelist_item">23:30</div></div></div></div></div></body></html>