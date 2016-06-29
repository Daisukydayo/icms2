<?php
/**
 * 后端 邀请码 统计类
 * @category iCMS
 * @package iCMS_FrameWork1_RuleClass_Gen_Promotion
 * User: momo
 * Date: 16/3/25
 */
class PromotionRecordManageGen extends BaseManageGen implements IBaseManageGen
{
    public function Gen()
    {
        $method = Control::GetRequest("m", '');
        switch($method){
            case "list":
                $result = self::GenList();
                break;
            case "list_by_promotion_id":
                $result = self::GetListByPromotionId();
                break;
            default:
                $result = self::GenList();
                break;
        }
        return $result;
    }


    private function GenList()
    {
        $userId     = Control::GetManageUserId();
        $pageIndex  = Control::GetRequest('p', 1);
        $pageSize   = Control::GetRequest('ps', 25);
        $searchKey  = Control::GetRequest('search_key', '');
        $searchType = Control::GetRequest('search_type', '');

        $tempContent = "未找到结果";
        if($userId > 0 ){
            $pageBegin = ($pageIndex - 1) * $pageSize;
            $promotionRecordManageData = new PromotionRecordManageData();
            $arrList = $promotionRecordManageData->GetList($pageBegin, $pageSize, $allCount, $searchKey, $searchType);

            $tempContent = Template::Load('promotion/promotionList.html', 'common');
            parent::ReplaceEnd($tempContent);

            $tagId = 'promotion_list';
            Template::ReplaceList($tempContent, $arrList, $tagId);

            $styleNumber = 1;
            $pagerTemplate = Template::Load("pager/pager_style$styleNumber.html", "common");
            $isJs = FALSE;
            $navUrl = "default.php?secu=manage&mod=promotion_record&m=lis&p={0}&ps=$pageSize&search_key=$searchKey&search_type=$searchType";
            $jsFunctionName = "";
            $jsParamList = "";
            $pagerButton = Pager::ShowPageButton($pagerTemplate, $navUrl, $allCount, $pageSize, $pageIndex ,$styleNumber = 1, $isJs, $jsFunctionName, $jsParamList);
            $tempContent = str_ireplace("{pager_button}", $pagerButton, $tempContent);
        }

        return $tempContent;
    }

    private function GetListByPromotionId()
    {
        $userId      = Control::GetManageUserId();
        $promotionId = Control::GetRequest('promotion_id', '');
        $pageIndex   = Control::GetRequest('p', 1);
        $pageSize    = Control::GetRequest('ps', 25);
        $tempContent = "未找到结果";
        if($userId > 0 && $promotionId > 0){
            $pageBegin = ($pageIndex - 1) * $pageSize;
            $promotionRecordManageData = new PromotionRecordManageData();
            $arrList = $promotionRecordManageData->GetListByPromotionId($promotionId, $pageBegin, $pageSize, $allCount);
            $tempContent = Template::Load('promotion/promotionHistory.html', 'common');
            parent::ReplaceEnd($tempContent);

            $tagId = 'promotion_list';
            Template::ReplaceList($tempContent, $arrList, $tagId);

            $styleNumber = 1;
            $pagerTemplate = Template::Load("pager/pager_style$styleNumber.html", "common");
            $isJs = FALSE;
            $navUrl = "default.php?secu=manage&mod=promotion_record&m=list_by_promotion_id&p={0}&ps=$pageSize&promotion_id=$promotionId";
            $jsFunctionName = "";
            $jsParamList = "";
            $pagerButton = Pager::ShowPageButton($pagerTemplate, $navUrl, $allCount, $pageSize, $pageIndex ,$styleNumber = 1, $isJs, $jsFunctionName, $jsParamList);
            $tempContent = str_ireplace("{pager_button}", $pagerButton, $tempContent);

        }
        return $tempContent;
    }
}