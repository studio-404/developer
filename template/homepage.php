<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>title</title>
</head>
<body>
<div id="generalinfo"></div>
<div id="components"></div>
<div id="languages"></div>
<div id="language_data"></div>
<div id="main_menu"></div>
<div id="multimedia"></div>
<div id="news"></div>
<div id="events"></div>


<script type="text/javascript" charset="utf-8">

/*
* page general information
*/
var data1 = '<?=$data["pagegeneralinfo"]?>';
var obj1 = JSON.parse(data1);
console.log(obj1);
document.getElementById("generalinfo").innerHTML = '<h2>General info</h2> '+ obj1[0].title;

/*
* Social networks
* Slider
* Banners
* Big homepage banner
*/
var data2 = '<?=$data["components"]?>';
var obj2 = JSON.parse(data2);
console.log(obj2);
document.getElementById("components").innerHTML = '<h2>Components</h2> '+ obj2[0].title;

/*
* languages
*/
var data3 = '<?=$data["languages"]?>';
var obj3 = JSON.parse(data3);
console.log(obj3);
document.getElementById("languages").innerHTML = '<h2>Languages</h2> '+ obj3[0].text;

/*
* language data Variables
*/
var data4 = '<?=$data["language_data"]?>';
var obj4 = JSON.parse(data4);
console.log(obj4);
document.getElementById("language_data").innerHTML = '<h2>Language data</h2> '+ obj4[0].text;

/*
* main manu, footer menu
*/
var data5 = '<?=$data["main_menu"]?>';
var obj5 = JSON.parse(data5);
console.log(obj5);
document.getElementById("main_menu").innerHTML = '<h2>Main menu</h2> '+ obj5.title[0];

/*
* Multimedia, last two videos
*/
var data6 = '<?=$data["multimedia"]?>';
var obj6 = JSON.parse(data6);
console.log(obj6);
document.getElementById("multimedia").innerHTML = '<h2>Multimedia</h2> '+ obj6[0].title;


/*
* last 15 news
*/
var data7 = '<?=$data["news"]?>';
var obj7 = JSON.parse(data7);
console.log(obj7);
document.getElementById("news").innerHTML = '<h2>News</h2> '+ obj7[0].title;

/*
* last 15 events
*/
var data8 = '<?=$data["events"]?>';
var obj8 = JSON.parse(data8);
console.log(obj8);
document.getElementById("events").innerHTML = '<h2>Events</h2> '+ obj8[0].title;
</script>


</body>
</html>