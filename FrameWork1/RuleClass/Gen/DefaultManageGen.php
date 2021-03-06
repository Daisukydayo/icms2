<?php

/**
 * 后台Gen总引导类
 * @category iCMS
 * @package iCMS_FrameWork1_RuleClass_Gen
 * @author zhangchi
 */
class DefaultManageGen extends BaseManageGen implements IBaseManageGen {

    /**
     * 引导方法
     * @return string 返回执行结果
     */
    public function Gen() {
        $result = "";
        $manageUserId = Control::GetManageUserId();
        if ($manageUserId <= 0) {
            Control::GoUrl(RELATIVE_PATH . "/default.php?mod=manage&a=login");
        } else {
            $module = Control::GetRequest("mod", "");
            switch ($module) {
                case "common":
                    $commonManageGen = new CommonManageGen();
                    $result = $commonManageGen->Gen();
                    break;
                case "manage_user":
                    $manageUserManageGen = new ManageUserManageGen();
                    $result = $manageUserManageGen->Gen();
                    break;
                case "manage_user_group":
                    $manageUserGroupManageGen = new ManageUserGroupManageGen();
                    $result = $manageUserGroupManageGen->Gen();
                    break;
                case "manage_user_authority":
                    $manageUserAuthorityManageGen = new ManageUserAuthorityManageGen();
                    $result = $manageUserAuthorityManageGen->Gen();
                    break;
                case "upload_file":
                    $uploadFileManageGen = new UploadFileManageGen();
                    $result = $uploadFileManageGen->Gen();
                    break;
                case "channel":
                    $channelManageGen = new ChannelManageGen();
                    $result = $channelManageGen->Gen();
                    break;
                case "channel_template":
                    $channelTemplateManageGen = new ChannelTemplateManageGen();
                    $result = $channelTemplateManageGen->Gen();
                    break;
                case "user":
                    $userManageGen = new UserManageGen();
                    $result = $userManageGen->Gen();
                    break;
                case "user_info":
                    $userInfoManageGen = new UserInfoManageGen();
                    $result = $userInfoManageGen->Gen();
                    break;
                case "user_album":
                    $userAlbumManageGen = new UserAlbumManageGen();
                    $result = $userAlbumManageGen->Gen();
                    break;
                case "user_group":
                    $userGroupManageGen = new UserGroupManageGen();
                    $result = $userGroupManageGen->Gen();
                    break;
                case "user_favorite":
                    $userFavoriteManageGen = new UserFavoriteManageGen();
                    $result = $userFavoriteManageGen->Gen();
                    break;
                case "user_level":
                    $userLevelManageGen = new UserLevelManageGen();
                    $result = $userLevelManageGen->Gen();
                    break;
                case "user_album_type":
                    $userAlbumTypeManageGen = new UserAlbumTypeManageGen();
                    $result = $userAlbumTypeManageGen->Gen();
                    break;
                case "user_order":
                    $userOrderManageGen = new UserOrderManageGen();
                    $result = $userOrderManageGen->Gen();
                    break;
                case "user_order_product":
                    $userOrderProductManageGen = new UserOrderProductManageGen();
                    $result = $userOrderProductManageGen->Gen();
                    break;
                case "user_order_pay":
                    $userOrderPayManageGen = new UserOrderPayManageGen();
                    $result = $userOrderPayManageGen->Gen();
                    break;
                case "user_order_send":
                    $userOrderSendManageGen = new UserOrderSendManageGen();
                    $result = $userOrderSendManageGen->Gen();
                    break;
                case "user_popedom":
                    $userPopedomManageGen = new UserPopedomManageGen();
                    $result = $userPopedomManageGen->Gen();
                    break;
                case "user_role":
                    $userRoleManageGen = new UserRoleManageGen();
                    $result = $userRoleManageGen->Gen();
                    break;
                case "document_news":
                    $documentNewsManageGen = new DocumentNewsManageGen();
                    $result = $documentNewsManageGen->Gen();
                    break;
                case "document_news_pic":
                    $documentNewsManageGen = new DocumentNewsPicManageGen();
                    $result = $documentNewsManageGen->Gen();
                    break;
                case "source":
                    $sourceManageGen = new SourceManageGen();
                    $result = $sourceManageGen->Gen();
                    break;
                case "set_template":
                    self::SetTemplate();
                    break;
                case "site":
                    $siteManageGen = new SiteManageGen();
                    $result = $siteManageGen->Gen();
                    break;
                case "site_config":
                    $siteConfigManageGen = new SiteConfigManageGen();
                    $result = $siteConfigManageGen->Gen();
                    break;
                case "site_filter":
                    $siteFilterManageGen = new SiteFilterManageGen();
                    $result = $siteFilterManageGen->Gen();
                    break;
                case "site_ad":
                    $siteAdManageGen = new SiteAdManageGen();
                    $result = $siteAdManageGen->Gen();
                    break;
                case "site_ad_content":
                    $siteAdContentManageGen = new SiteAdContentManageGen();
                    $result = $siteAdContentManageGen->Gen();
                    break;
                case "site_content":
                    $siteContentManageGen = new SiteContentManageGen();
                    $result = $siteContentManageGen->Gen();
                    break;
                case "site_tag":
                    $siteTagManageGen = new SiteTagManageGen();
                    $result = $siteTagManageGen->Gen();
                    break;
                case "manage_menu_of_user":
                    $manageMenuOfUserManageGen = new ManageMenuOfUserManageGen();
                    $result = $manageMenuOfUserManageGen->Gen();
                    break;
                case "forum":
                    $forumManageGen = new ForumManageGen();
                    $result = $forumManageGen->Gen();
                    break;
                case "forum_topic":
                    $forumTopicManageGen = new ForumTopicManageGen();
                    $result = $forumTopicManageGen->Gen();
                    break;
                case "forum_post":
                    $forumPostManageGen = new ForumPostManageGen();
                    $result = $forumPostManageGen->Gen();
                    break;
                case "custom_form":
                    $customFormManageGen = new CustomFormManageGen();
                    $result = $customFormManageGen->Gen();
                    break;
                case "custom_form_field":
                    $customFormFieldManageGen = new CustomFormFieldManageGen();
                    $result = $customFormFieldManageGen->Gen();
                    break;
                case "custom_form_record":
                    $customFormRecordManageGen = new CustomFormRecordManageGen();
                    $result = $customFormRecordManageGen->Gen();
                    break;
                case "custom_form_content":
                    $customFormContentManageGen = new CustomFormContentManageGen();
                    $result = $customFormContentManageGen->Gen();
                    break;
                case "forum_topic_type":
                    $forumTopicTypeManageGen = new ForumTopicTypeManageGen();
                    $result = $forumTopicTypeManageGen->Gen();
                    break;
                case "vote":
                    $voteManageGen = new VoteManageGen();
                    $result = $voteManageGen->Gen();
                    break;
                case "vote_item":
                    $voteItemManageGen = new VoteItemManageGen();
                    $result = $voteItemManageGen->Gen();
                    break;
                case "vote_select_item":
                    $voteSelectItemManageGen = new VoteSelectItemManageGen();
                    $result = $voteSelectItemManageGen->Gen();
                    break;
                case "product":
                    $productManageGen = new ProductManageGen();
                    $result = $productManageGen->Gen();
                    break;
                case "product_param":
                    $productParamManageGen = new ProductParamManageGen();
                    $result = $productParamManageGen->Gen();
                    break;
                case "product_param_type":
                    $productParamTypeManageGen = new ProductParamTypeManageGen();
                    $result = $productParamTypeManageGen->Gen();
                    break;
                case "product_param_type_class":
                    $productParamTypeClassManageGen = new ProductParamTypeClassManageGen();
                    $result = $productParamTypeClassManageGen->Gen();
                    break;
                case "product_param_type_option":
                    $productParamTypeOptionManageGen = new ProductParamTypeOptionManageGen();
                    $result = $productParamTypeOptionManageGen->Gen();
                    break;
                case "product_brand":
                    $productBrandManageGen = new ProductBrandManageGen();
                    $result = $productBrandManageGen->Gen();
                    break;
                case "product_price":
                    $productPriceManageGen = new ProductPriceManageGen();
                    $result = $productPriceManageGen->Gen();
                    break;
                case "product_pic":
                    $productPicManageGen = new ProductPicManageGen();
                    $result = $productPicManageGen->Gen();
                    break;
                case "activity":
                    $activityManageGen = new ActivityManageGen();
                    $result = $activityManageGen->Gen();
                    break;
                case "activity_user":
                    $activityUserManageGen = new ActivityUserManageGen();
                    $result = $activityUserManageGen->Gen();
                    break;
                case "activity_class":
                    $activityClassManageGen = new ActivityClassManageGen();
                    $result = $activityClassManageGen->Gen();
                    break;
                case "information":
                    $informationManageGen = new InformationManageGen();
                    $result = $informationManageGen->Gen();
                    break;
                case "pic_slider":
                    $picSliderManageGen = new PicSliderManageGen();
                    $result = $picSliderManageGen->Gen();
                    break;
                case "ftp":
                    $ftpManageGen = new FtpManageGen();
                    $result = $ftpManageGen->Gen();
                    break;
                case "newspaper":
                    $newspaperManageGen = new NewspaperManageGen();
                    $result = $newspaperManageGen->Gen();
                    break;
                case "newspaper_page":
                    $newspaperPageManageGen = new NewspaperPageManageGen();
                    $result = $newspaperPageManageGen->Gen();
                    break;
                case "newspaper_article":
                    $newspaperArticleManageGen = new NewspaperArticleManageGen();
                    $result = $newspaperArticleManageGen->Gen();
                    break;
                case "newspaper_article_pic":
                    $newspaperArticlePicManageGen = new NewspaperArticlePicManageGen();
                    $result = $newspaperArticlePicManageGen->Gen();
                    break;
                case "comment":
                    $commentManageGen = new CommentManageGen();
                    $result = $commentManageGen->Gen();
                    break;
                case "task":
                    $commentManageGen = new TaskManageGen();
                    $result = $commentManageGen->Gen();
                    break;
                case "interface":
                    $interfaceManageGen = new InterfaceManageGen();
                    $result = $interfaceManageGen->Gen();
                    break;
                case "visit":
                    $visitManageGen = new VisitManageGen();
                    $result = $visitManageGen->Gen();
                    break;
                case "template_library":
                    $templateLibraryGen = new TemplateLibraryManageGen();
                    $result = $templateLibraryGen->Gen();
                    break;
                case "template_library_content":
                    $templateLibraryContentGen = new TemplateLibraryContentManageGen();
                    $result = $templateLibraryContentGen->Gen();
                    break;
                case "template_library_channel":
                    $templateLibraryChannelGen = new TemplateLibraryChannelManageGen();
                    $result = $templateLibraryChannelGen->Gen();
                    break;
                case "template_library_channel_content":
                    $templateLibraryChannelContentGen = new TemplateLibraryChannelContentManageGen();
                    $result = $templateLibraryChannelContentGen->Gen();
                    break;
                case "exam_question_class":
                    $examQuestionClassManageGen = new ExamQuestionClassManageGen();
                    $result = $examQuestionClassManageGen->Gen();
                    break;
                case "exam_question":
                    $examQuestionManageGen = new ExamQuestionManageGen();
                    $result = $examQuestionManageGen->Gen();
                    break;
                case "exam_user_paper":
                    $examUserPaperManageGen = new ExamUserPaperManageGen();
                    $result = $examUserPaperManageGen->Gen();
                    break;
                case "exam_user_answer":
                    $examUserAnswerManageGen = new ExamUserAnswerManageGen();
                    $result = $examUserAnswerManageGen->Gen();
                    break;
                case "lottery":
                    $lotteryManageGen = new LotteryManageGen();
                    $result = $lotteryManageGen->Gen();
                    break;
                case "lottery_set":
                    $lotterySetManageGen = new LotterySetManageGen();
                    $result = $lotterySetManageGen->Gen();
                    break;
                case "lottery_award_user":
                    $lotteryAwardUserManageGen = new LotteryAwardUserManageGen();
                    $result = $lotteryAwardUserManageGen->Gen();
                    break;
                case "promotion_record":
                    $promotionRecordManageGen = new PromotionRecordManageGen();
                    $result = $promotionRecordManageGen->Gen();
                    break;


                case "league":
                    $leagueManageGen = new LeagueManageGen();
                    $result = $leagueManageGen->Gen();
                    break;
                case "match":
                    $matchManageGen = new MatchManageGen();
                    $result = $matchManageGen->Gen();
                    break;
                case "team":
                    $teamManageGen = new TeamManageGen();
                    $result = $teamManageGen->Gen();
                    break;
                case "member":
                    $memberManageGen = new MemberManageGen();
                    $result = $memberManageGen->Gen();
                    break;
                case "stadium":
                    $stadiumManageGen = new StadiumManageGen();
                    $result = $stadiumManageGen->Gen();
                    break;
                case "goal":
                    $goalManageGen = new GoalManageGen();
                    $result = $goalManageGen->Gen();
                    break;
                case "red_yellow_card":
                    $goalManageGen = new RedYellowCardManageGen();
                    $result = $goalManageGen->Gen();
                    break;
                case "member_change":
                    $goalManageGen = new MemberChangeManageGen();
                    $result = $goalManageGen->Gen();
                    break;
                case "other_event":
                    $goalManageGen = new OtherEventManageGen();
                    $result = $goalManageGen->Gen();
                    break;



                case "del_all_cache":
                    parent::DelAllCache();
                    echo "deleted!";
                    break;
                case "test":
                    echo "test ";
                    die();
                    break;
                default :
                    $result = self::GenDefault();
                    break;
            }
        }
        return $result;
    }

    private function GenDefault() {
        //is login
        $manageUserId = Control::GetManageUserId();
        if ($manageUserId <= 0) {
            die();
        }
        $manageUserName = Control::GetManageUserName();
        $clientIp = Control::GetIp();

        $tempContent = Template::Load("manage/default.html","common");
        parent::ReplaceFirst($tempContent);

        $tempContent = str_ireplace("{manage_user_id}", $manageUserId, $tempContent);
        $tempContent = str_ireplace("{manage_user_name}", $manageUserName, $tempContent);
        $tempContent = str_ireplace("{client_ip_address}", $clientIp, $tempContent);



        //manage_menu_of_column
        $tagId = "manage_menu_of_column";
        $manageMenuOfColumnManageData = new ManageMenuOfColumnManageData();
        $manageUserGroupManageData = new ManageUserGroupManageData();
        $manageMenuOfColumnIdValue = $manageUserGroupManageData->GetManageMenuOfColumnIdValue($manageUserId);


        $arrManageMenuOfColumn = $manageMenuOfColumnManageData->GetList($manageMenuOfColumnIdValue);
        Template::ReplaceList($tempContent, $arrManageMenuOfColumn, $tagId);
        $tempContent = str_ireplace("{manage_menu_of_column_count}", count($arrManageMenuOfColumn), $tempContent);

        $manageMenuOfSiteChannelTemplateContent = Template::Load("manage/manage_menu_of_site_channel.html","common");
        $tempContent = str_ireplace("{manage_menu_of_site_channel}", $manageMenuOfSiteChannelTemplateContent, $tempContent);
        $manageMenuOfForumTemplateContent = Template::Load("manage/manage_menu_of_forum.html","common");
        $tempContent = str_ireplace("{manage_menu_of_forum}", $manageMenuOfForumTemplateContent, $tempContent);
        $manageMenuOfUserManageTemplateContent = Template::Load("manage/manage_menu_of_user_manage.html","common");
        $tempContent = str_ireplace("{manage_menu_of_user_manage}", $manageMenuOfUserManageTemplateContent, $tempContent);
        $manageMenuOfSearchTemplateContent = Template::Load("manage/manage_menu_of_search.html","common");
        $tempContent = str_ireplace("{manage_menu_of_search}", $manageMenuOfSearchTemplateContent, $tempContent);
        $manageMenuOfSystemConfigTemplateContent = Template::Load("manage/manage_menu_of_system_config.html","common");
        $tempContent = str_ireplace("{manage_menu_of_system_config}", $manageMenuOfSystemConfigTemplateContent, $tempContent);
        $manageMenuOfTaskTemplateContent = Template::Load("manage/manage_menu_of_task.html","common");
        $tempContent = str_ireplace("{manage_menu_of_task}", $manageMenuOfTaskTemplateContent, $tempContent);


        $tagId = "select_site";
        $siteManageData = new SiteManageData();
        $arrSiteList = $siteManageData->GetListForSelect($manageUserId);

        Template::ReplaceList($tempContent, $arrSiteList, $tagId);


        parent::ReplaceEnd($tempContent);
        return $tempContent;
    }

    private function SetTemplate(){
        $templateName = Control::GetRequest("tn", "default");
        Control::SetManageUserTemplateName($templateName);
    }
}

?>
