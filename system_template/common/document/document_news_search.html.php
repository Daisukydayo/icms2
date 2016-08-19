<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    {common_head}
    <script type="text/javascript" src="/system_js/manage/document_news/document_news.js"></script>

    <script type="text/javascript">
        $(function() {

            var siteId = "{SiteId}";
            siteId=0;
            var lastDocumentNewsId = "{LastDocumentNewsId}";
            var searchKey = "{SearchKey}";

            if(lastDocumentNewsId==""||lastDocumentNewsId==undefined){
                lastDocumentNewsId="999999999";
                $(".pager").hide();
            }


            $("#begin_date").datepicker({
                dateFormat: 'yy-mm-dd',
                numberOfMonths: 3,
                showButtonPanel: true
            });


            $("#end_date").datepicker({
                dateFormat: 'yy-mm-dd',
                numberOfMonths: 3,
                showButtonPanel: true
            });

            //var inputSearchKey = $("#search_key");
            //if(searchKey!=""&&searchKey!="undefined"){
            //    inputSearchKey.val(searchKey);
            //}


            //当前页提示
            var nowPage=Request["now_page"];
            if(nowPage==""||nowPage==undefined){
                nowPage="0";
            }
            nowPage=parseInt(nowPage)+1;
            $("#btn_now_page").val("当前第"+nowPage+"页");


            //关键字飘红
            var str_searchKey=decodeURI(Request["search_key"]);
            if(str_searchKey!=""&&str_searchKey!="undefined"){
                str_searchKey=str_searchKey.replaceAll("　"," ")
                var arr_searchKey=str_searchKey.split(" ");
                for(var i=0;i<arr_searchKey.length;i++){
                    if(arr_searchKey[i]!=""&&arr_searchKey[i]!=undefined){
                        $(".link_view").each(function(){
                            $(this).html($(this).html().replaceAll(arr_searchKey[i],'<span style="color:red">'+arr_searchKey[i]+'</span>'));
                        });
                    }
                }
            }

            //$(".input_box").click(function(){
            //    $(this).val("");
            //});


            var btnSearch = $(".btn_search_for_manage");

            btnSearch.css("cursor", "pointer");
            btnSearch.click(function(event) {
                event.preventDefault();
                var searchKey = $("#search_key").val();
                var act_lastDocumentNewsId=lastDocumentNewsId;
                if($(this).attr("id")=="btn_search_for_manage"){
                    act_lastDocumentNewsId=999999999;
                }
                //if(searchKey!=""){
                    var manageUserName=$("#manage_user_name").val();
                    var userName=$("#user_name").val();
                    var beginDate=$("#begin_date").val();
                    var endDate=$("#end_date").val();
                    var state=$("#state_condition").val();
                    window.location.href="/default.php?secu=manage&mod=document_news&m=search_for_manage&search_key="+searchKey+
                        "&last_document_news_id="+act_lastDocumentNewsId+
                        "&manage_user_name="+manageUserName+
                        "&user_name="+userName+
                        "&begin_date="+beginDate+
                        "&end_date="+endDate+
                        "&siteid="+siteId+
                        "&state="+state+
                        "&now_page="+nowPage;
                //}else{
                //    alert("请输入关键字");
                //}


            });
            $(".btn_back").click(function(event) {
                event.preventDefault();
                history.back();
            });





            $(".link_view").click(function(){
                if($(this).attr("href")==undefined){
                    var documentNewsId = $(this).attr("idvalue");
                    var publishDate = $(this).attr("pub_date");
                    var channelId = $(this).attr("channel_id");
                    var siteId=$(this).attr("site_id");
                    var id=$(this).attr("id");
                    if(publishDate.length>0){
                        $.ajax({
                            url: "/default.php?secu=manage&mod=site&m=async_get_site_url&site_id="+siteId,
                            dataType: "jsonp",
                            jsonp: "jsonpcallback",
                            success: function(data) {
                                var siteUrl=data["result"];
                                var a=$("#"+id);
                                var link=a[0]
                                a.attr("href",siteUrl+"/h/"+channelId+"/"+publishDate+"/"+documentNewsId+".html");

                                var e = document.createEvent('MouseEvents');
                                e.initEvent('click', true, true);
                                link.dispatchEvent(e);
                                //setInterval('$("#'+id+'").click()',200);
                                //$(this).attr("href",siteUrl+"/h/"+channelId+"/"+publishDate+"/"+documentNewsId+".html");
                            }
                        });
                    }
                }
            });

            $(".state_view").each(function(){
                var value=$(this).attr("idvalue");
                $(this).html(formatDocumentNewsState(value));
            });


        });
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
            <td id="td_main_btn">
                <label for="search_key">检索内容:</label>
                <input id="search_key" class="input_box"  value="{SearchKey}"  type="text"/>
                <label for="manage_user_name">发稿人:</label>
                <input id="manage_user_name" class="input_box"  value="{ManageUserName}"  type="text"/>
                <!--<label for="user_name">投稿人:</label>
                <input id="user_name" class="input_box" value="{UserName}"  type="text"/>-->
                <label for="begin_date">起始时间:</label>
                <input id="begin_date" class="input_box" value="{BeginDate}"  type="text"/>
                <label for="end_date">结束时间:</label>
                <input id="end_date" class="input_box" value="{EndDate}"  type="text"/>
                <label for="state_condition"></label>
                <select name="state_condition" id="state_condition">
                    <option value="-1">所有</option>
                    <option value="0">新稿</option>
                    <option value="1">已编</option>
                    <option value="2">返工</option>
                    <option value="11">一审</option>
                    <option value="12">二审</option>
                    <option value="13">三审</option>
                    <option value="14">终审</option>
                    <option value="20">已否</option>
                    <option value="30">已发</option>
                    <option value="100">已删</option>
                </select>
                <script type="text/javascript">
                    $("#state_condition").find("option[value='{State}']").attr("selected",true);
                </script>

                <input id="btn_search_for_manage" class="btn2 btn_search_for_manage" value="搜索" title="搜索" type="button"/>
            </td>
            <td style="text-align: right; margin-right: 8px;">
            </td>
        </tr>
    </table>
    <table class="grid" width="100%" cellpadding="0" cellspacing="0">
        <tr class="grid_title">
            <td style="width: 180px; text-align: center;">创建时间</td>
            <td style="width: 180px; text-align: center;">发稿时间</td>
            <td style="width: 80px; text-align: center;">状态</td>
            <td style="width: 100px; text-align: center;">发稿人</td>
            <td style="padding-left:10px;">标题</td>
            <!--<td style="width: 200px;padding-left:10px;">摘要</td>-->
        </tr>
    </table>
    <ul id="">
        <icms id="document_news_list" type="list">
            <item>
                <![CDATA[
                <li id="sort_{f_DocumentNewsId}">
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tr class="grid_item">
                            <td class="spe_line2" style="width:180px;text-align:center;" title="文档创建时间">{f_CreateDate}</td>
                            <td class="spe_line2" style="width:180px;text-align:center;" title="文档发稿时间">{f_PublishDate}</td>
                            <td class="spe_line2 state_view" style="width:80px;text-align:center;" title="{f_State}" idvalue="{f_State}"></td>
                            <td class="spe_line2" style="width:100px;text-align:center;" title="发稿人：{f_ManageUserName}">{f_ManageUserName}</td>
                            <td class="spe_line2" style="padding-left:10px;">
                                <a target="_blank" id="d_{f_DocumentNewsId}" class="link_view" title='{f_DocumentNewsIntro}' style="cursor: pointer" site_id="{f_SiteId}" channel_id="{f_ChannelId}" idvalue="{f_DocumentNewsId}" pub_date="{f_year}{f_month}{f_day}">
                                    {f_DocumentNewsTitle}
                                </a>
                            </td>
                            <!--<td class="spe_line2" style="width:200px;height:30px" title='{f_DocumentNewsIntro}'><div style="height:29px;width:200px;overflow: hidden;padding-left:10px;text-align: left">{f_DocumentNewsIntro}</div></td>-->
                        </tr>
                    </table>
                </li>
                ]]>
            </item>
        </icms>
    </ul>
    <div>{pager_button}</div>
    <div class="pager" style="margin-top: 10px">
        <input id="btn_back" class="btn2 btn_back" value="上一页" title="搜索" type="button"/>
        <input id="btn_now_page" class="btn2 " value="" title="搜索" type="button"/>
        <input id="btn_forward" class="btn2 btn_search_for_manage" value="下一页" title="搜索" type="button"/>
    </div>
</div>
<div id="dialog_box" title="" style="display:none;">
    <div id="dialog_content">

    </div>
</div>
</body>
</html>
