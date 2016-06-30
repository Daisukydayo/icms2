<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    {common_head}
    <script type="text/javascript" src="/system_js/manage/document_news/document_news.js"></script>

    <script>
        $(function(){
            $(".deviceType").each(function(){
                if($(this).text() == 0){
                    $(this).text("IOS")
                }
                else if($(this).text() == 1){
                    $(this).text("Android")
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
    <table class="grid" width="100%" cellpadding="0" cellspacing="0">
        <tr class="grid_title">

            <td style="width: 10%; text-align:center">来源</td>
            <td style="width: 20%; text-align:center">注册日期</td>
            <td style="width: 10%; text-align:center">设备类型</td>
            <td style="text-align:center">设备识别码</td>
            <td style="width: 10%; text-align:center">用户ID</td>
            <td style="width: 20%; text-align:center">注册IP</td>
        </tr>
    </table>
    <ul id="sort_grid">
        <icms id="promotion_list" type="list">
            <item>
                <![CDATA[
                <li id="">
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tr class="grid_item">
                            <td class="spe_line2" style="width:10%;text-align:center;" title="来源：{f_PromoterId}">{f_PromoterId}</td>
                            <td class="spe_line2" style="width:20%;text-align:center;" title="注册日期：{f_CreateDate}">{f_CreateDate}</td>
                            <td class="spe_line2 deviceType" style="width:10%;text-align:center;" title="设备类型：{f_DeviceType}">{f_DeviceType}</td>
                            <td class="spe_line2" style="text-align:center;" title="设备识别码：{f_DeviceNumber}">{f_DeviceNumber}</td>
                            <td class="spe_line2" style="width:10%;text-align:center;" title="用户ID：{f_UserId}">{f_UserId}</td>
                            <td class="spe_line2" style="width:20%;text-align:center;" title="注册IP：{f_IpAddress}">{f_IpAddress}</td>
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
