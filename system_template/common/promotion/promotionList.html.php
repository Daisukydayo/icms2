<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    {common_head}
    <script type="text/javascript" src="/system_js/manage/document_news/document_news.js"></script>

    <script>
        $(function(){
            $("#search_type_box").find('option[search_type=' + getcookie('searchOption')+ ']').attr("selected", true);

            $("#btn_search").click(function(){
                var key = $("#search_key").val();
                var search_type = $("#search_type_box").find("option:selected").attr('search_type');
                setcookie('searchOption',search_type);
        
                if(key == ''){
                    alert("请输入搜素内容");
                }
                else{
                    window.location.href = '/default.php?secu=manage&mod=promotion_record&m=list&search_key=' + key + '&search_type=' + search_type;
                }
            })
        })
    </script>
</head>
<body>

<div id="dialog_resultbox" title="" style="display: none;">
    <div id="result_table" style="font-size: 14px;">
        <iframe id="dialog_frame" src=""  style="border: 0; " width="100%" height="460"></iframe>
    </div>
</div>

<div class="div_list">
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>

            <td style="text-align: right; margin-right: 8px;">
                <div id="search_box">
                    <label for="search_type_box"></label>
                    <select name="search_type_box" id="search_type_box">
                        <option value="promotion_id_search" search_type="0">精确搜索</option>
                        <option value="promotion_id_like" search_type="1">分区统计</option>
                    </select>
                    <label for="search_key"></label><input type="text" id="search_key" name="search_key" class="input_box"/>
                    <input id="btn_search" class="btn2"  value="查 询" type="button"/>
                </div>
            </td>
        </tr>
    </table>
    <table class="grid" width="100%" cellpadding="0" cellspacing="0">
        <tr class="grid_title">

            <td style="width: 20%; text-align:center">推广人</td>
            <td style="width: 20%; text-align:center">推广码</td>
            <td style="width: 20%; text-align:center">手机号</td>
            <td style="width: 20%; text-align:center">推广人所属单位</td>
            <td style="width: 20%; text-align:center">已推广人数</td>
        </tr>
    </table>
    <ul id="sort_grid">
        <icms id="promotion_list" type="list">
            <item>
                <![CDATA[
                <li id="">
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tr class="grid_item">

                            <td class="spe_line2 promotionName" style="width:20%;text-align:center;" title="推广人：{f_PromoterName}">
                                <a href="/default.php?secu=manage&mod=promotion_record&m=list_by_promotion_id&promotion_id={f_PromoterId}">{f_PromoterName}</a>
                            </td>
                            <td class="spe_line2 promotionCode" style="width:20%;text-align:center;" title="推广码：{f_PromoterId}">{f_PromoterId}</td>
                            <td class="spe_line2" style="width:20%;text-align:center;" title="手机号：{f_PromoterMobile}">{f_PromoterMobile}</td>
                            <td class="spe_line2" style="width:20%;text-align:center;" title="推广人所属单位：{f_PromoterCompany}">{f_PromoterCompany}</td>
                            <td class="spe_line2" style="width:20%;text-align:center;" title="已推广人数：{f_Sum}">{f_Sum}</td>
                        </tr>
                    </table>
                </li>
                ]]>
            </item>
        </icms>
    </ul>
    <div>{pager_button}</div>
</div>
<div id="dialog_box" title="" style="display:none;">
    <div id="dialog_content">

    </div>
</div>
</body>
</html>
