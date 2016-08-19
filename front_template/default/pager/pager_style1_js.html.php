<script type="text/javascript">
    $(function() {
        var pb1 = $(".pb1");
        pb1.mouseover(function() {
            $(this).attr("class", "pb1_over");
        });
        pb1.mouseleave(function() {
            $(this).attr("class", "pb1");
        });
        var pb3 = $(".pb3");
        pb3.mouseover(function() {
            $(this).attr("class", "pb3_over");
        });
        pb3.mouseleave(function() {
            $(this).attr("class", "pb3");
        });
    });

</script>
<div id="pager_btn">
    <div class="pb3" onclick="{JsFunctionName}({firstindex})"><a>首页</a></div>
    <div {ShowPre} class="pb3" onclick="{JsFunctionName}({preindex})" ><a>上页</a></div>
    {PageList}
    <div {shownext} class="pb3" onclick="{JsFunctionName}({nextindex})"><a><span id="linkNext">下页</span></a></div>
    <div class="pb3" onclick="{JsFunctionName}({EndIndex})"><a>末页</a></div>
    <div class="pb5">{NowIndex}/{AllIndex}</div>
    <div class="pb5">总共{AllCount}/每页{PageSize}</div>
    <div class="pb4" style="display:{ShowGoTo}"><label>
            <input type="text" maxlength="6" value="输入页码" class="pager_input" onfocus="this.value = '';" onkeypress="if (event.keyCode == 13) {
            if (!isNaN(parseInt(this.value))) {
                {JsFunctionName}(this.value.replace('.', ''));
            } else {
                alert('请输入数字');
            }
        }"/>
        </label></div>
    <div class="spe2"></div>
</div>