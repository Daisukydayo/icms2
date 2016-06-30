/**
*   图片
*/
var str='';
var siteAdUrl = '';
str+='<div id="site_ad_259" idvalue="259" style="width:1200px; height:367px;overflow:hidden;" class="icms_site_ad site_ad_show_type_0 show_once_0" title="0">';
    
            siteAdUrl = '';
            str+='<div class="icms_ad_item" idvalue="851" id="2014-12-08 00:00:00_2015-01-31 00:00:00_851" title="555">';
                if(siteAdUrl.length<=0){
                    str+='<img src="http://xzw.changsha.cn/images/21_14.jpg" alt="" height="367" width="1200" />';
                }else{
                    str+='<a class="open_virtual_click_1 open_count_1" idvalue="851" href="" target="_blank" title="555" style="line-height: 0px;display:block"><img src="http://xzw.changsha.cn/images/21_14.jpg" alt="" height="367" width="1200" /></a>';
                }
                str+='</div>';
        
str+='</div>';
jQuery(".site_ad_259").html(str);


var showOnce=getcookie('show_once_259');
if(showOnce==1){
jQuery(".site_ad_259").hide();
}
setcookie('show_once_259', 0);