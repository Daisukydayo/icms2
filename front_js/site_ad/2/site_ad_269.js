/**
*   图片
*/
var str='';
var siteAdUrl = '';
str+='<div id="site_ad_269" idvalue="269" style="width:100%; height:auto;overflow:hidden;" class="icms_site_ad site_ad_show_type_0 show_once_0" title="0">';
    
            siteAdUrl = '';
            str+='<div class="icms_ad_item" idvalue="865" id="2015-01-16 00:00:00_2015-03-31 00:00:00_865" title="两会">';
                if(siteAdUrl.length<=0){
                    str+='<img src="/upload/site_ad/269/54b8b5ff86a6c.gif" alt="" />';
                }else{
                    str+='<a class="open_virtual_click_0 open_count_0" idvalue="865" href="" target="_blank" title="两会" style="line-height: 0px;display:block"><img src="/upload/site_ad/269/54b8b5ff86a6c.gif" alt="" /></a>';
                }
                str+='</div>';
        
str+='</div>';
jQuery(".site_ad_269").html(str);


var showOnce=getcookie('show_once_269');
if(showOnce==1){
jQuery(".site_ad_269").hide();
}
setcookie('show_once_269', 0);