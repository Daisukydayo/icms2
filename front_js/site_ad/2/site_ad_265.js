/**
*   图片
*/
var str='';
var siteAdUrl = '';
str+='<div id="site_ad_265" idvalue="265" style="width:100%; height:auto;overflow:hidden;margin: 0px auto" class="icms_site_ad site_ad_show_type_0 show_once_0" title="0">';
    
            siteAdUrl = 'http://mp.weixin.qq.com/s?__biz=MjM5OTI5MjU1Mg==&mid=201556319&idx=1&sn=e25c5091d93188301cec90b8a92edb04#rd';
            str+='<div class="icms_ad_item" idvalue="861" id="2014-12-08 00:00:00_2016-01-01 00:00:00_861" title="关注长沙晚报微信">';
                if(siteAdUrl.length<=0){
                    str+='<img src="/upload/site_ad/265/548aa1ac7e172.jpg" alt="" />';
                }else{
                    str+='<a class="open_virtual_click_0 open_count_0" idvalue="861" href="http://mp.weixin.qq.com/s?__biz=MjM5OTI5MjU1Mg==&mid=201556319&idx=1&sn=e25c5091d93188301cec90b8a92edb04#rd" target="_blank" title="关注长沙晚报微信" style="line-height: 0px;display:block"><img src="/upload/site_ad/265/548aa1ac7e172.jpg" alt="" /></a>';
                }
                str+='</div>';
        
str+='</div>';
jQuery(".site_ad_265").html(str);


var showOnce=getcookie('show_once_265');
if(showOnce==1){
jQuery(".site_ad_265").hide();
}
setcookie('show_once_265', 0);