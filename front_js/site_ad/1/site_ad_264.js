/**
*   轮换
*/
var str='';
var siteAdUrl = '';
str+='<div id="site_ad_264" idvalue="264" style="width:222px; height:222px;overflow:hidden;" class="icms_site_ad site_ad_show_type_2" title="0">';
    
            str+='<div class="icms_ad_item switch_264 switch_264_1" idvalue="3" id="2014-12-03 00:00:00_2014-12-13 00:00:00_863" title="wb" style="display:none">';
                siteAdUrl = '';
                if(siteAdUrl.length<=0){
                str+='as';
                }else{
                    str+='<a class="open_virtual_click_0 open_count_0" idvalue="863" href="" target="_blank" title="wb" style="display: block;line-height: 0px">';
                    str+='as';
                    str+='</a>';
                }
                str+='</div>';
            
            str+='<div class="icms_ad_item switch_264 switch_264_2" idvalue="1" id="2014-11-02 00:00:00_2014-12-19 00:00:00_860" title="333" style="display:none">';
                siteAdUrl = 'http://www.baidu.com';
                if(siteAdUrl.length<=0){
                str+='<img src="/upload/ad/264/5456e4984bcda.jpg" alt="" />';
                }else{
                    str+='<a class="open_virtual_click_0 open_count_1" idvalue="860" href="http://www.baidu.com" target="_blank" title="333" style="display: block;line-height: 0px">';
                    str+='<img src="/upload/ad/264/5456e4984bcda.jpg" alt="" />';
                    str+='</a>';
                }
                str+='</div>';
        
str+='</div>';
jQuery(".site_ad_264").html(str);

//eAdId = "icms_ad_item";
//wType = "2";
//tchClassName = "switch_{f_SiteAdId}";
//runSiteAd(siteAdId,switchClassName);