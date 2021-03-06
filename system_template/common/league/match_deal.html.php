<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    {common_head}
    <script type="text/javascript" src="/system_js/jquery_ui/jquery-ui-timepicker-addon.js"></script>
    <style>
        /* css for timepicker */
        .ui-timepicker-div .ui-widget-header { margin-bottom: 8px; }
        .ui-timepicker-div dl { text-align: left; }
        .ui-timepicker-div dl dt { float: left; clear:left; padding: 0 0 0 5px; }
        .ui-timepicker-div dl dd { margin: 0 10px 10px 45%; }
        .ui-timepicker-div td { font-size: 90%; }
        .ui-tpicker-grid-label { background: none; border: none; margin: 0; padding: 0; }

        .ui-timepicker-rtl{ direction: rtl; }
        .ui-timepicker-rtl dl { text-align: right; padding: 0 5px 0 0; }
        .ui-timepicker-rtl dl dt{ float: right; clear: right; }
        .ui-timepicker-rtl dl dd { margin: 0 45% 10px 10px; }
    </style>

    <script>
        $(function(){

                $(".GetDate").datepicker({
                    showSecond: true,
                    dateFormat: 'yy-mm-dd',
                    numberOfMonths: 1
                });

                $(".GetTime").timepicker({
                    showSecond: true,
                    timeFormat: 'HH:mm:ss',
                    stepHour: 1,
                    stepMinute: 1,
                    stepSecond: 1
                });


            $(".get_team_id").click(function(){
            });


        });


        function GetTeamId(teamDomId,toDomId,leagueId){

            var teamName=$("#"+teamDomId).val();
            if(teamName==""){
                alert("请输入队名！");
            }else{
            $.ajax({
                type: "get",
                url: "/default.php?secu=manage&mod=team&m=async_get_id_by_name",
                data: {
                    team_name: teamName,
                    league_id:leagueId
                },
                dataType: "jsonp",
                jsonp: "jsonpcallback",
                success: function(data) {
                    var result=data["result"];
                    var teamId=data["team_id"];
                    switch(parseInt(result)){
                        case 1:
                            alert("获取成功");
                            $("#"+toDomId).val(teamId);
                            break;
                        case 0:
                            alert("队名为空");
                            break;
                        case -1:
                            alert("找不到队伍");
                            break;
                        case -2:
                            if(confirm("队伍没有参加该赛事,是否直接添加？")){
                                var groupName=prompt("请为新加入队伍安排分组");
                                $.ajax({
                                    type: "post",
                                    url: "/default.php?secu=manage&mod=team&m=async_join_league",
                                    data: {
                                        team_id: teamId,
                                        league_id: leagueId,
                                        group_name: groupName
                                    },
                                    dataType: "jsonp",
                                    jsonp: "jsonpcallback",
                                    success: function (data) {
                                        var result=data["result"];
                                        if(parseInt(result)>0){
                                            alert("添加成功！");
                                            $("#"+toDomId).val(teamId);
                                        }else{
                                            alert("添加失败！");
                                        }
                                    }
                                });
                            }
                            break;
                    }
                }
            });

            }
        }





        function GetStadiumId(stadiumDomId,toDomId,leagueId){

            var stadiumName=$("#"+stadiumDomId).val();
            if(stadiumName==""){
                alert("请输入球场名！");
            }else{
                $.ajax({
                    type: "get",
                    url: "/default.php?secu=manage&mod=stadium&m=async_get_id_by_name",
                    data: {
                        stadium_name: stadiumName,
                        league_id:leagueId

                    },
                    dataType: "jsonp",
                    jsonp: "jsonpcallback",
                    success: function(data) {
                        var result=data["result"];
                        var teamId=data["stadium_id"];
                        switch(parseInt(result)){
                            case 1:
                                alert("获取成功");
                                $("#"+toDomId).val(teamId);
                                break;
                            case 0:
                                alert("球场名为空");
                                break;
                            case -1:
                                alert("找不到球场");
                                break;
                        }
                    }
                });

            }
        }
        function submitForm(continueCreate) {
            var submit=1;
            if ($('#f_LotteryName').val() == '') {
                $("#dialog_box").dialog({width: 300, height: 100});
                $("#dialog_content").html("请输入名称");
                submit=0;
            }
            if(submit==1) {
                if (continueCreate == 1) {
                    $("#CloseTab").val("0");
                } else {
                    $("#CloseTab").val("1");
                }
                $('#main_form').submit();
            }
        }
    </script>
</head>
<body>
{common_body_deal}
<form id="main_form" action="/default.php?secu=manage&mod=match&m={method}&match_id={MatchId}&league_id={LeagueId}&site_id={SiteId}&tab_index={TabIndex}" method="post">

    <input id="CloseTab" name="CloseTab" type="hidden" value="0"/>
    <table width="99%" align="center" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td class="spe_line" height="40" align="right">
                <input class="btn" value="确认并关闭" type="button" onclick="submitForm(0)"/>
                <input class="btn" value="确认并继续新增" style="display:{display}" type="button" onclick="submitForm(1)"/>
                <input class="btn" value="取 消" type="button" onclick="closeTab()"/>
            </td>
        </tr>
    </table>
    <div style="margin: 0 auto 10px;">
        <table width="99%" class="doc_grid" cellpadding="0" cellspacing="0">
            <tr class="grid_item">
                <td class="spe_line" style="height:30px;width:200px;text-align:right"><label for="f_MatchName">名称：</label></td>
                <td class="spe_line"><input type="text" id="f_MatchName" name="f_MatchName" value="{MatchName}"/></td>
            </tr>
            <tr class="grid_item">
                <td class="spe_line" style="height:30px;text-align:right"><label for="f_BeginDate">日期：</label></td>
                <td class="spe_line"><input type="text" class="GetDate" id="f_BeginDate" name="f_BeginDate" value="{BeginDate}"/></td>
            </tr>
            <tr class="grid_item">
                <td class="spe_line" style="height:30px;text-align:right"><label for="f_BeginTime">时间：</label></td>
                <td class="spe_line"><input type="text" class="GetTime" id="f_BeginTime" name="f_BeginTime" value="{BeginTime}"/></td>
            </tr>
            <tr class="grid_item">
                <td class="spe_line" style="height:30px;text-align:right"><label for="f_IsKnockout">比赛类型：</label></td>
                <td class="spe_line">
                    <select name="f_IsKnockout" id="f_IsKnockout">
                        <option value="0">循环赛</option>
                        <option value="1">淘汰赛</option>
                    </select>(循环赛记入积分统计，淘汰赛不计入）
                    {s_IsKnockout}
                </td>
            </tr>
            <tr class="grid_item">
                <td class="spe_line" style="height:30px;text-align:right"><label for="f_StadiumId">球场：</label></td>
                <td class="spe_line">
                    <input type="number" class="" id="f_StadiumId" name="f_StadiumId" value="{StadiumId}"/>
                    <input type="text" class="" id="StadiumName"  value="{StadiumName}"/>
                    <input type="button" class="btn" onclick="GetStadiumId('StadiumName','f_StadiumId','{LeagueId}')" value="获取id"/>
                </td>
            </tr>
            <tr class="grid_item">
                <td class="spe_line" style="height:30px;text-align:right"><label for="f_HomeTeamId">主队：</label></td>
                <td class="spe_line">
                    <input type="number" class="" id="f_HomeTeamId" name="f_HomeTeamId" value="{HomeTeamId}"/>
                    <input type="text" class="" id="HomeTeamName"  value="{HomeTeamName}"/>
                    <input type="button" class="btn" onclick="GetTeamId('HomeTeamName','f_HomeTeamId','{LeagueId}')" value="获取id"/>
                </td>
            </tr>
            <tr class="grid_item">
                <td class="spe_line" style="height:30px;text-align:right"><label for="f_HomeTeamId">客队：</label></td>
                <td class="spe_line">
                    <input type="number" class="" id="f_GuestTeamId" name="f_GuestTeamId" value="{GuestTeamId}"/>
                    <input type="text" class="" id="GuestTeamName"  value="{GuestTeamName}"/>
                    <input type="button" class="btn" onclick="GetTeamId('GuestTeamName','f_GuestTeamId','{LeagueId}')" value="获取id"/>
                </td>
            </tr>
            <tr class="grid_item">
                <td class="spe_line" style="height:30px;text-align:right"><label for="f_HomeTeamGoal">主队进球：</label></td>
                <td class="spe_line">
                    <input type="number" class="" id="f_HomeTeamGoal" name="f_HomeTeamGoal" value="{HomeTeamGoal}"/>
                </td>
            </tr>
            <tr class="grid_item">
                <td class="spe_line" style="height:30px;text-align:right"><label for="f_GuestTeamGoal">客队进球：</label></td>
                <td class="spe_line">
                    <input type="number" class="" id="f_GuestTeamGoal" name="f_GuestTeamGoal" value="{GuestTeamGoal}"/>
                </td>
            <tr class="grid_item">
                <td class="spe_line" style="height:30px;text-align:right"><label for="f_HomeTeamPenalty">主队点球：</label></td>
                <td class="spe_line">
                    <input type="number" class="" id="f_HomeTeamPenalty" name="f_HomeTeamPenalty" value="{HomeTeamPenalty}"/>
                </td>
            </tr>
            <tr class="grid_item">
                <td class="spe_line" style="height:30px;text-align:right"><label for="f_HomeTeamPenalty">客队点球：</label></td>
                <td class="spe_line">
                    <input type="number" class="" id="f_HomeTeamPenalty" name="f_HomeTeamPenalty" value="{HomeTeamPenalty}"/>
                </td>
            </tr>
            <tr class="grid_item">
                <td class="spe_line" style="height:30px;text-align:right"><label for="f_State">状态：</label></td>
                <td class="spe_line">
                    <input type="number" class="" id="f_State" name="f_State" value="{State}"/>(0:一般 1：已结束)
                </td>
            </tr>
            <tr class="grid_item">
                <td class="spe_line" style="height:30px;text-align:right"><label for="f_Result">结果：</label></td>
                <td class="spe_line">
                    <input type="number" class="" id="f_Result" name="f_Result" value="{Result}"/>（1:主队胜 2:客队胜 3:平 4:主队点球胜 5:客队点球胜）
                </td>
            </tr>

        </table>
        <div id="bot_button">
            <div style="padding-top:3px;">
                <table width="99%" align="center" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td colspan="2" height="30" align="center">
                            <input class="btn" value="确认并关闭" type="button" onclick="submitForm(0)"/>
                            <input class="btn" value="确认并继续新增" style="display:{display}" type="button" onclick="submitForm(1)"/>
                            <input class="btn" value="取 消" type="button" onclick="closeTab()"/>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</form>
</body>
</html>