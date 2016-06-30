/**
*   随机
*/
var str='';
var siteAdUrl = '';
str+='<div id="site_ad_263" idvalue="263" style="width:300px; height:300px;overflow:hidden;" class="icms_site_ad site_ad_show_type_3" title="0">';
    
            str+='<div class="icms_ad_item random_263 random_263_1" idvalue="4" id="0000-00-00 00:00:00_2014-12-09 00:00:00_858" title="fff" style="display:none">';
                siteAdUrl = '';
                if(siteAdUrl.length<=0){
                str+='<img src="/upload/ad/263/54378a31aedb2.jpg" title="点击查看源网页" style="width: 335px; left: 545px; height: 274px; display: block; top: 159px;" alt="" />';
                }else{
                    str+='<a class="open_virtual_click_0 open_count_1" idvalue="858" href="" target="_blank" title="fff" style="display: block;line-height: 0px">';
                    str+='<img src="/upload/ad/263/54378a31aedb2.jpg" title="点击查看源网页" style="width: 335px; left: 545px; height: 274px; display: block; top: 159px;" alt="" />';
                    str+='</a>';
                }
                str+='</div>';
            
str+='</div>';

jQuery(".site_ad_263").html(str);