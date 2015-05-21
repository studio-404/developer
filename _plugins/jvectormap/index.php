<!DOCTYPE html>
<html>
<head>
  <title>jVectorMap demo</title>
  <link rel="stylesheet" href="jquery-jvectormap-2.0.1.css" type="text/css" media="screen"/>
  <script src="jquery.js"></script>
  <script src="jquery-jvectormap-2.0.2.min.js"></script>
  <script src="jquery-jvectormap-world-mill-en.js"></script>
  <style type="text/css">
  @font-face {
  font-family: 'Roboto-Regular';
    src: url('Roboto-Regular.eot?#iefix') format('embedded-opentype'),  
    url('../roboto/Roboto-Regular.woff') format('woff'), 
    url('../roboto/Roboto-Regular.ttf')  format('truetype'), 
    url('../roboto/Roboto-Regular.svg#Roboto-Regular') format('svg');
    font-weight: normal;
    font-style: normal;
  }
  .clearfix{ clear: both; }
  body{ margin:0; padding:0; border:0; font-family: 'Roboto-Regular'; }
  .mymap{ margin:0; padding:0; border:0; width:100%; height:400px; position: relative; }
  .searchMap{ margin:0; padding: 0; border: 0; width: 100%; background: #424862; }
  .searchMap .general-title{ margin:0; padding: 10px 30px; font-size: 26px; line-height: 26px; color: #ffffff; font-weight: bold; }
  .searchMap .viewby{ margin: 10px 30px; padding: 5px; width: 30%; float: left; border: solid 1px #fea100; }
  .searchMap .viewby .title{ margin: 0; padding: 0; color:#fea100; }
  .searchMap .viewby .content{ margin: 5px 0 0 0; padding: 0; color:#ffffff; }
  .searchMap .viewby .content .input{ margin: 0 10px 0 0; padding: 0 0 0 30px; float: left; position: relative; cursor: pointer; }
  .searchMap .viewby .content .input:hover{ color: #fea100; }
  .searchMap .viewby .content .checked::after{ content:" "; margin:0; padding: 0; width: 14px; height: 14px; background-image: url('checked.png'); background-repeat: no-repeat; background-position: center center; position: absolute; top: 3px; left: 3px }
  .searchMap .viewby .content .unchecked::after{ content:" "; margin:0; padding: 0; width: 14px; height: 14px; background-image: url('uncheked.png'); background-repeat: no-repeat; background-position: center center; position: absolute; top: 3px; left: 3px; }

  .searchMap .traderegimes{ margin: 10px 30px; padding: 5px; width: 50%; float: left; border: solid 1px #fea100; }
  .searchMap .traderegimes .title{ margin: 0; padding: 0; color:#fea100; }
  .searchMap .traderegimes .content{ margin: 5px 0 0 0; padding: 0; color:#ffffff; }
  .searchMap .traderegimes .content .input{ margin: 0 10px 0 0; padding: 0 0 0 30px; float: left; position: relative; cursor: pointer; }
  .searchMap .traderegimes .content .input:hover{ color: #fea100; }
  .searchMap .traderegimes .content .checked::after{ content:" "; margin:0; padding: 0; width: 14px; height: 14px; background-image: url('checked.png'); background-repeat: no-repeat; background-position: center center; position: absolute; top: 3px; left: 3px }
  .searchMap .traderegimes .content .unchecked::after{ content:" "; margin:0; padding: 0; width: 14px; height: 14px; background-image: url('uncheked.png'); background-repeat: no-repeat; background-position: center center; position: absolute; top: 3px; left: 3px; }
  #map1{ width: 100%; height:400px; }
  </style>
</head>
<body>
  <div class="mymap">
    <div class="searchMap">
      <div class="general-title">Trade map of Georgia export</div>
      <div class="viewby">
      
        <div class="title">View by</div>
        <div class="content">
          <label class="input checked" data-type="viewby" id="country">Countries </label>
          <label class="input unchecked" data-type="viewby" id="groups">Country groups </label>
        </div>
      
      </div>

      <div class="traderegimes">

        <div class="title">Trade regimes</div>
        <div class="content">
          <label class="input unchecked" data-type="traderegime" id="freetrade">Free trade </label>
          <label class="input unchecked" data-type="traderegime" id="gsp">GSP+ </label>
          <label class="input unchecked" data-type="traderegime" id="ongoing">On going free trade negotiation </label>
        </div>

      </div>
      <div class="clearfix"></div>

    </div>
    <div id="map1"></div>
  </div>
  <script type="text/javascript" charset="utf-8">
    jQuery.noConflict();
    jQuery(function(){
    var $ = jQuery;
    var mapx = $('#map1').vectorMap({
        map: 'world_mill_en',
        backgroundColor: '#424862', 
        panOnDrag: true,
        regionsSelectable:true, 
        regionStyle:{
        initial: {
          fill: '#249fea',
          "fill-opacity": 1,
          stroke: 'none',
          "stroke-width": 0,
          "stroke-opacity": 1
          },
          hover: {
            "fill-opacity": 0.8,
            cursor: 'pointer'
          },
          selected: {
            fill: '#0278c1'
          },
          selectedHover: {
          }
        }, 
        series: {
          regions: [{
            values: {"GE":"#ffae00"},
            attribute: 'fill'
          }],
        }, 
        onRegionTipShow: function(e, el, code){
          el.html('<b style="font-size:12px; font-family:\'Roboto-Regular\'">'+el.html()+'</b> <br /> <font style="font-size:11px; font-family:\'Roboto-Regular\'">Export: 4 USS (+2% y-o-y)</font><br /> <font style="font-size:11px; font-family:\'Roboto-Regular\'">Import: 4 USS (+2% y-o-y)</font><br /> <font style="font-size:11px; font-family:\'Roboto-Regular\'">Trade regime: Free trade</font>');
        }
      });
    }); 


     jQuery(document).on("click",".input",function(){
      var type = jQuery(this).data("type");
      var idx = jQuery(this).attr("id"); 
      var mapx = jQuery('#map1').vectorMap('get', 'mapObject');
      if(type=="viewby" && idx=="country"){
        jQuery("#country").attr({"class":"input checked"});
        jQuery("#groups").attr({"class":"input unchecked"});
        resetColors();
      }else if(type=="viewby" && idx=="groups"){
        jQuery(".input").attr({"class":"input unchecked"});
        jQuery("#groups").attr({"class":"input checked"});
        mapx.series.regions[0].setValues({
          'RU':'#c0504d', // CIS START
          'AM':'#c0504d', 
          'AZ':'#c0504d', 
          'BY':'#c0504d', 
          'KZ':'#c0504d', 
          'KG':'#c0504d', 
          'MD':'#c0504d', 
          'TJ':'#c0504d', 
          'UZ':'#c0504d', 
          'AT':'#4f81bd', // EU START
          'BE':'#4f81bd', 
          'BG':'#4f81bd', 
          'HR':'#4f81bd', 
          'CY':'#4f81bd', 
          'CZ':'#4f81bd',
          'DK':'#4f81bd',
          'EE':'#4f81bd',
          'FI':'#4f81bd',
          'FR':'#4f81bd',
          'DE':'#4f81bd',
          'GR':'#4f81bd',
          'HU':'#4f81bd',
          'IE':'#4f81bd',
          'IT':'#4f81bd',
          'LV':'#4f81bd',
          'LT':'#4f81bd',
          'LU':'#4f81bd',
          'NL':'#4f81bd',
          'PL':'#4f81bd',
          'PT':'#4f81bd',
          'RO':'#4f81bd',
          'SK':'#4f81bd',
          'SI':'#4f81bd',
          'ES':'#4f81bd',
          'SE':'#4f81bd',
          'GB':'#4f81bd'
        });
      }else if(type=="traderegime" && idx=="freetrade"){
        jQuery("#freetrade").attr({"class":"input checked"});
        jQuery("#gsp").attr({"class":"input unchecked"});
        jQuery("#ongoing").attr({"class":"input unchecked"});
        jQuery("#country").click();
        resetColors();
        mapx.series.regions[0].setValues({
          'RU':'green'    
        });
      }else if(type=="traderegime" && idx=="gsp"){
        jQuery("#freetrade").attr({"class":"input unchecked"});
        jQuery("#gsp").attr({"class":"input checked"});
        jQuery("#ongoing").attr({"class":"input unchecked"});
        jQuery("#country").click();
        resetColors();
        mapx.series.regions[0].setValues({    
          'GY':'yellow'     
        });
      }else if(type=="traderegime" && idx=="ongoing"){
        jQuery("#freetrade").attr({"class":"input unchecked"});
        jQuery("#gsp").attr({"class":"input unchecked"});
        jQuery("#ongoing").attr({"class":"input checked"});
        jQuery("#country").click();
        resetColors();
        mapx.series.regions[0].setValues({
          'GL':'blank'      
        });
      }
    });

  function resetColors(){
     var mapx = jQuery('#map1').vectorMap('get', 'mapObject');
     //mapx.series.regions[0].setValues({'backgroundColor':'#249fea'});
     mapx.reset();
  }
  </script>
</body>
</html>