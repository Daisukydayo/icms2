/**
*   落幕
*/
var str='';
var siteAdUrl = '';
str+='<div id="site_ad_261" idvalue="261" style="width:1000px; height:500px;overflow:hidden;display:none" class="icms_site_ad site_ad_show_type_4" title="0" >';
    
            str+='<div class="icms_ad_item pull_261" idvalue="5" id="0000-00-00 00:00:00_2014-12-11 00:00:00_856" title="11" style="">';
                siteAdUrl = '#';
                if(siteAdUrl.length<=0){
                str+='<img src="/upload/ad/261/5435eaa5d4b3f.jpg" alt="" />';
                }else{
                    str+='<a class="open_virtual_click_0 open_count_1" idvalue="856" href="#" target="_blank" title="11" style="display: block;line-height: 0px">';
                    str+='<img src="/upload/ad/261/5435eaa5d4b3f.jpg" alt="" />';
                    str+='</a>';
                }
                str+='</div>';
            
str+='</div>';

jQuery(".site_ad_261").html(str);