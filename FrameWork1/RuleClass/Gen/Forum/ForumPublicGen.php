<?php

/**
 * 前台 论坛 生成类
 * @category iCMS
 * @package iCMS_FrameWork1_RuleClass_Gen_Forum
 * @author zhangchi
 */
class ForumPublicGen extends ForumBasePublicGen implements IBasePublicGen {

    /**
     * 引导方法
     * @return string 返回执行结果
     */
    public function GenPublic() {
        $action = Control::GetRequest("a", "");

        switch ($action) {
            case "search":
                $result = self::GenSearch();
                break;
            default:
                $result = self::GenDefault();
                break;
        }

        return $result;
    }

    /**
     * 生成论坛首页
     * @return string 论坛首页HTML
     */
    private function GenDefault() {
        $siteId = parent::GetSiteIdByDomain();

        /*******************页面级的缓存 begin********************** */
        $templateMode = 0;
        $defaultTemp = "forum_default";

        $tempContent = parent::GetDynamicTemplateContent(
            $defaultTemp, 0, "", $templateMode);//(site id 为0时，全系统搜索模板)

        $forumId = Control::GetRequest("forum_id", "");

        $forumPublicData = new ForumPublicData();

        $forumAccess = $forumPublicData->GetForumAccess($forumId, true);

        if($forumAccess == ForumData::FORUM_ACCESS_USER_GROUP){
            //按身份加密
            $userId = Control::GetUserId();


            $message = Language::Load("forum",6);
            $selfUrl = $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'];
            $selfUrl = urlencode($selfUrl);
            $message = str_ireplace("{re_url}", $selfUrl, $message);

            if($userId<=0){
                return $message;
            }

            $userRolePublicData = new UserRolePublicData();
            $userGroupId = $userRolePublicData->GetUserGroupId($siteId, $userId, true);

            if($userGroupId<=0){
                return $message;
            }

            $forumAccessLimit = $forumPublicData->GetForumAccessLimit($forumId, true);
            $arrAccessLimitContent = explode(',',$forumAccessLimit);
            $canExplore = false;
            if(is_array($arrAccessLimitContent)
                && !empty($arrAccessLimitContent)){

                if (in_array($userGroupId, $arrAccessLimitContent)){
                    $canExplore = true;
                }

            }else{

                if($userGroupId == $forumAccessLimit){
                    $canExplore = true;
                }

            }


            if(!$canExplore){

                return $message;

            }


        }


        $cacheDir = CACHE_PATH . DIRECTORY_SEPARATOR . 'forum_page';
        $cacheFile = 'forum_default_site_id_' . $siteId . '_forum_id_'.$forumId.'_mode_' . $templateMode;
        $withCache = true;
        if($withCache){
            $pageCache = parent::GetCache($cacheDir, $cacheFile);

            if ($pageCache === false) {
                $result = self::getDefaultTemplateContent($siteId, $forumId, $tempContent);
                parent::AddCache($cacheDir, $cacheFile, $result, 60);
            } else {
                $result = $pageCache;
            }
        }else{
            $result = self::getDefaultTemplateContent($siteId, $forumId, $tempContent);
        }

        /*******************页面级的缓存 end  ********************** */

        parent::ReplaceUserInfoPanel($result, $siteId, "forum_user_is_login", "forum_user_no_login");

        return $result;
    }

    private function getDefaultTemplateContent($siteId, $forumId, $tempContent){

        parent::ReplaceFirst($tempContent);
        parent::ReplaceFirstForForum($tempContent);

        $tempContent = str_ireplace("{SiteId}", $siteId, $tempContent);

        $forumPublicData = new ForumPublicData();

        if(strlen($forumId)>0){
            if(stripos("_",$forumId)){ //能找到 _

                //多个一级版块
                $forumId = str_ireplace("_",",",$forumId);

                $arrRankOneList = $forumPublicData->GetListInForumId($forumId);
                $arrRankTwoList = $forumPublicData->GetListInParentId($siteId, $forumId);


            }else{


                $arrRankOneList = $forumPublicData->GetListByForumId($forumId);
                $arrRankTwoList = $forumPublicData->GetListByParentId($forumId);

                $backgroundUrl = $forumPublicData->GetBackgroundUrl($forumId, true);
                $tempContent = str_ireplace("{BackgroundUrl}", $backgroundUrl, $tempContent);

                $backgroundColor = $forumPublicData->GetBackgroundColor($forumId, true);
                $tempContent = str_ireplace("{BackgroundColor}", $backgroundColor, $tempContent);

                $topImageUrl = $forumPublicData->GetTopImageUrl($forumId, true);
                $tempContent = str_ireplace("{TopImageUrl}", $topImageUrl, $tempContent);

            }




        }else{

            $forumRank = 0;
            $arrRankOneList = $forumPublicData->GetListByForumRank($siteId, $forumRank, true);

            $forumRank = 1;
            $arrRankTwoList = $forumPublicData->GetListByForumRank($siteId, $forumRank, true);
        }


        $tagId = "forum_".$siteId;
        $tagName = Template::DEFAULT_TAG_NAME;
        $tableIdName = BaseData::TableId_Forum;
        $parentIdName = "ParentId";

        $arrRankThreeList = null;
        $thirdTableIdName = null;
        $thirdParentIdName = null;

        $childArrayFieldName = "LastPostInfo";
        $thirdArrayFieldName = "";

        Template::ReplaceList(
            $tempContent,
            $arrRankOneList,
            $tagId,
            $tagName,
            $arrRankTwoList,
            $tableIdName,
            $parentIdName,
            $arrRankThreeList,
            $thirdTableIdName,
            $thirdParentIdName,
            $childArrayFieldName,
            $thirdArrayFieldName
        );


        parent::ReplaceTemplate($tempContent);
        parent::ReplaceEndForForum($tempContent);
        parent::ReplaceEnd($tempContent);



        parent::ReplaceSiteConfig($siteId, $tempContent);

        /*******************过滤字符 begin********************** */

        $multiFilterContent = array();
        $multiFilterContent[0] = $tempContent;
        $useArea = 4; //过滤范围 4:评论
        $stop = FALSE; //是否停止执行
        $filterContent = null;
        $stopWord = parent::DoFilter($siteId, $useArea, $stop, $filterContent, $multiFilterContent);
        $tempContent = $multiFilterContent[0];

        /*******************过滤字符 end  ********************** */

        return $tempContent;
    }

    private function GenSearch(){
        $key = trim(Control::GetRequest("key", ''));
        $pageIndex = Control::GetRequest("p", 1);
        $pageSize = Control::GetRequest("ps", 30);

        $siteId = parent::GetSiteIdByDomain();

        $TemplateName = 'forum_search_result';
        $templateMode = 0;
        $tempContent = parent::GetDynamicTemplateContent($TemplateName, 0, "", $templateMode);

        parent::ReplaceFirst($tempContent);
        parent::ReplaceFirstForForum($tempContent);
        parent::ReplaceUserInfoPanel($tempContent, $siteId, 'forum_user_is_login', 'forum_user_no_login');

        $allCount=0;
        $pageBegin = ($pageIndex - 1) * $pageSize;
        $forumPublicDate = new ForumPublicData();
        $arrSearchResult = $forumPublicDate->GetSearchResultArray($siteId, $pageBegin, $pageSize, $allCount,$key);


        $tagId = "forum_search_list";
        if(count($arrSearchResult) > 0){
            Template::ReplaceList($tempContent, $arrSearchResult, $tagId);

            $templateMode = 0;
            $pagerTemplate = parent::GetDynamicTemplateContent("pager_button", 0, '',$templateMode);

            $navUrl = "/default.php?mod=forum&a=search&SiteId=$siteId&p={n}&ps=$pageSize&key=$key";
            $pagerButtonListTemplateContent = Template::Load('pager_new/pager_list_style_default.html', 'default', 'front_template');

            $pagerButton = Pager::CreatePageButtons($pagerTemplate,true,true,'',$pageIndex,$pageSize,$allCount,$pagerButtonListTemplateContent,$navUrl);

            $tempContent = str_ireplace("{pager_button}", $pagerButton, $tempContent);
            return $tempContent;

        }
        else{
            $arrSearchResult=[];
            Template::ReplaceList($tempContent, $arrSearchResult, $tagId);
            $tempContent = str_ireplace("{pager_button}", '未找包含关键词到结果', $tempContent);
            return $tempContent;


        }

    }


}

?>
