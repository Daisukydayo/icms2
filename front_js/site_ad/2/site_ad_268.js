/**
*   落幕
*/

var str='';
var siteAdUrl = '';
str+='<div id="site_ad_268" idvalue="268" style="width:100%; height:auto;overflow:hidden;display:none" class="icms_site_ad site_ad_show_type_4 show_once_1" title="0" >';
    
            str+='<div class="icms_ad_item pull_268" idvalue="5" id="2015-01-01 00:00:00_2015-03-31 00:00:00_864" title="t" style="">';
                siteAdUrl = '';
                if(siteAdUrl.length<=0){
                str+='<img src="/upload/site_ad/268/54a8fd7db4cd7.jpg" alt="" />';
                }else{
                    str+='<a class="open_virtual_click_0 open_count_0" idvalue="864" href="" target="_blank" title="t" style="display: block;line-height: 0px">';
                    str+='<img src="/upload/site_ad/268/54a8fd7db4cd7.jpg" alt="" />';
                    str+='</a>';
                }
                str+='</div>';
            
str+='</div>';

jQuery(".site_ad_268").html(str);


var showOnce=getcookie('show_once_268');
if(showOnce==1){
jQuery(".site_ad_268").hide();
}
setcookie('show_once_268', 1);