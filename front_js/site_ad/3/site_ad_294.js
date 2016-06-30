/**
*   图片
*/
var str='';
var siteAdUrl = '';
str+='<div id="site_ad_294" idvalue="294" style="width:px; height:px;overflow:hidden;margin: 0px auto" class="icms_site_ad site_ad_show_type_0 show_once_0" title="0">';
    
            siteAdUrl = '';
            str+='<div class="icms_ad_item" idvalue="934" id="0000-00-00 00:00:00_0000-00-00 00:00:00_934" title="dd">';
                if(siteAdUrl.length<=0){
                    str+='';
                }else{
                    str+='<a class="open_virtual_click_0 open_count_0" idvalue="934" href="" target="_blank" title="dd" style="line-height: 0px;display:block"></a>';
                }
                str+='</div>';
        
str+='</div>';
jQuery(".site_ad_294").html(str);
jQuery(".site_ad_294 img").css("width","px");
jQuery(".site_ad_294 img").css("height","px");


var showOnce=getcookie('show_once_294');
if(showOnce==1){
jQuery(".site_ad_294").hide();
}
setcookie('show_once_294', 0);