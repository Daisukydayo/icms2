<!--<div class="template_default{template_selected_default} btn_set_template" idvalue="default" title="默认样式"></div>
<div class="template_deepblue{template_selected_deepblue} btn_set_template" idvalue="deepblue" title="深蓝样式"></div>-->

<script type="text/javascript">
    $().ready(function () {
        $(".span_document_search_for_manage_all_site").click(function (event) {
            event.preventDefault();
            parent.G_TabUrl = '/default.php?secu=manage&mod=document_news&m=search_for_manage&site_id=0';
            parent.G_TabTitle = '全站点-稿件检索';
            parent.addTab();
        });


    });




</script>
<div class="btn span_document_search_for_manage_all_site" style="width:70px;font-weight:normal;cursor: pointer">稿件检索</div>
<div class="spe"></div>
