/**
*   图片
*/
var str='';
var siteAdUrl = '';
str+='<div id="site_ad_275" idvalue="275" style="width:600px; height:90px;overflow:hidden;margin: 0px auto" class="icms_site_ad site_ad_show_type_0 show_once_0" title="0">';
    
            siteAdUrl = '';
            str+='<div class="icms_ad_item" idvalue="880" id="0000-00-00 00:00:00_0000-00-00 00:00:00_880" title="new">';
                if(siteAdUrl.length<=0){
                    str+='<img src="/upload/site_ad/275/555058ea44a49.jpg" alt="" />';
                }else{
                    str+='<a class="open_virtual_click_0 open_count_0" idvalue="880" href="" target="_blank" title="new" style="line-height: 0px;display:block"><img src="/upload/site_ad/275/555058ea44a49.jpg" alt="" /></a>';
                }
                str+='</div>';
        
str+='</div>';
jQuery(".site_ad_275").html(str);
jQuery(".site_ad_275 img").css("width","600px");
jQuery(".site_ad_275 img").css("height","90px");


var showOnce=getcookie('show_once_275');
if(showOnce==1){
jQuery(".site_ad_275").hide();
}
setcookie('show_once_275', 0);