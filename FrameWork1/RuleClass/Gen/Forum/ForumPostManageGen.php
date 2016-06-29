<?php

/**
 * 后台管理 论坛帖子 生成类
 * @category iCMS
 * @package iCMS_FrameWork1_RuleClass_Gen_Forum
 * @author zhangchi
 */
class ForumPostManageGen extends BaseManageGen implements IBaseManageGen {
    /**
     * 引导方法
     * @return string 返回执行结果
     */
    public function Gen()
    {
        $result = "";
        $method = Control::GetRequest("m", "");
        switch ($method) {
            case "list":
                $result = self::GenList();
                break;
            case "create":
                $result = self::GenCreate();
                break;
            case "modify":
                $result = self::GenModify();
                break;
            case "async_modify_state":
                $result = self::AsyncModifyState();
                break;
        }
        $result = str_ireplace("{method}", $method, $result);
        return $result;
    }

    private function GenList(){
        $result = "";
        $forumTopicId = Control::GetRequest("forum_topic_id", 0);
        $resultJavaScript="";

        if($forumTopicId>0){
            $tempContent = Template::Load("forum/forum_post_list.html","common");
            $forumPostManageData = new ForumPostManageData();
            $pageSize = Control::GetRequest("ps", 200);
            $pageIndex = Control::GetRequest("p", 1);
            $searchKey = Control::GetRequest("search_key", "");
            $pageBegin = ($pageIndex - 1) * $pageSize;
            $allCount = 0;
            $listName = "forum_topic_list";

                $forumPostArray=$forumPostManageData->GetListPager(
                    $forumTopicId,
                    $pageBegin,
                    $pageSize,
                    $allCount,
                    $searchKey);

                if(count($forumPostArray)>0){
                    Template::ReplaceList($tempContent, $forumPostArray, $listName);
                    $styleNumber = 1;
                    $pagerTemplate = Template::Load("pager/pager_style$styleNumber.html", "common");
                    $isJs = FALSE;
                    $navUrl = "default.php?secu=manage&mod=forum_post&a=list&forum_topic_id=$forumTopicId&p={0}&ps=$pageSize";
                    $jsFunctionName = "";
                    $jsParamList = "";
                    $pagerButton = Pager::ShowPageButton($pagerTemplate, $navUrl, $allCount, $pageSize, $pageIndex ,$styleNumber = 1, $isJs, $jsFunctionName, $jsParamList);

                    $tempContent = str_ireplace("{PagerButton}", $pagerButton, $tempContent);
                }else{
                    Template::RemoveCustomTag($tempContent, $listName);
                }
            parent::ReplaceEnd($tempContent);
            $tempContent = str_ireplace("{ResultJavascript}", $resultJavaScript, $tempContent);
            $result = $tempContent;
        }
        else{

        }



        return $result;
    }
    
    private function GenModify(){
        $result = -1;

        $forumTopicId = Control::GetRequest("forum_topic_id", 0);
        $forumPostId = Control::GetRequest("forum_post_id", 0);
        if ($forumPostId <= 0) {
            die("");
        }
        $siteId = Control::GetRequest("site_id", 0);

        $tempContent = Template::Load("forum/forum_post_deal.html","common");

        $forumPostManageData = new ForumPostManageData();
        $arrOne = $forumPostManageData->GetOne($forumPostId);

        Template::ReplaceOne($tempContent, $arrOne, false, false);

        $tempContent = str_ireplace("{f_ForumPostTitle}", $arrOne["ForumPostTitle"], $tempContent);
        $tempContent = str_ireplace("{f_ForumPostContent}", $arrOne["ForumPostContent"], $tempContent);
        if (!empty($_POST)) {
            $forumPostTitle = Control::PostRequest("f_ForumPostTitle", "");
            $forumPostTitle = Format::FormatHtmlTag($forumPostTitle);

            $forumPostContent = Control::PostRequest("f_ForumPostContent", "");
            //内容中不允许脚本等
            $forumPostContent = Format::RemoveScript($forumPostContent);
                $forumPostManageData = new ForumPostManageData();
                $result = $forumPostManageData->Modify($forumTopicId,$forumPostContent,$forumPostTitle,$forumPostId);
                if($result > 0 && $isTopic=1){
                    Control::GoUrl("/default.php?secu=manage&mod=forum_post&m=list&forum_topic_id=".$forumTopicId."&site_id=".$siteId);
                }
        }

        parent::ReplaceEnd($tempContent);
        $result = $tempContent;
        return $result;
    }
} 