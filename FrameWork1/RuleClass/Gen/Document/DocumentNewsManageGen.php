<?php

/**
 * 后台管理 资讯 生成类
 * @category iCMS
 * @package iCMS_FrameWork1_RuleClass_Gen_Document
 * @author zhangchi
 */
class DocumentNewsManageGen extends BaseManageGen implements IBaseManageGen
{

    /**
     * 引导方法
     * @return string 返回执行结果
     */
    public function Gen()
    {
        $result = "";
        $method = Control::GetRequest("m", "");
        switch ($method) {
            case "create":
                $result = self::GenCreate();
                break;
            case "modify":
                $result = self::GenModify();
                break;
            case "remove_to_bin":
                $result = self::GenRemoveToBin();
                break;
            case "list":
                $result = self::GenList();
                break;
            case "list_of_collection":
                $result = self::GenListOfCollection();
                break;
            case "search_for_manage":
                $result = self::GenSearchForManage();
                break;
            case "async_publish":
                $result = self::AsyncPublish();
                break;
            case "async_batch_publish_selected":
                $result = self::AsyncBatchPublishSelected();
                break;
            case "async_modify_sort":
                $result = self::AsyncModifySort();
                break;
            case "async_modify_sort_by_drag":
                $result = self::AsyncModifySortByDrag();
                break;
            case "async_modify_state":
                $result = self::AsyncModifyState();
                break;
            case "async_modify_manage_remark":
                $result = self::AsyncModifyManageRemark();
                break;
            case "copy":
                $result = self::GenDeal($method);
                break;
            case "move":
                $result = self::GenDeal($method);
                break;
        }
        $result = str_ireplace("{method}", $method, $result);
        return $result;
    }

    /**
     * 生成资讯管理新增页面
     * @return mixed|string
     */
    private function GenCreate()
    {
        $editorSet = 'tiny';
        $editorCookie = '';
        if (isset($_COOKIE["editor"])) {
            $editorCookie = $_COOKIE["editor"];
        }

        if ($editorCookie == "XH") {
            $editorSet = "xh";
        }

        if ($editorSet == "xh") {
            $templateContent = Template::Load("document/document_news_deal_editor_xh.html", "common");
        } else {
            $templateContent = Template::Load("document/document_news_deal_editor_tiny.html", "common");
        }
        $channelId = Control::GetRequest("channel_id", 0);
        $manageUserId = Control::GetManageUserId();
        $manageUserName = Control::GetManageUserName();
        $pageIndex = Control::GetRequest("p", 1);
        $tabIndex = Control::GetRequest("tab_index", 0);
        $resultJavaScript = "";
        parent::ReplaceFirst($templateContent);

        if ($channelId > 0) {

            $channelManageData = new ChannelManageData();
            $siteId = $channelManageData->GetSiteId($channelId, false);
            $channelName = $channelManageData->GetChannelName($channelId, false);

            ///////////////判断是否有操作权限///////////////////
            $manageUserAuthorityManageData = new ManageUserAuthorityManageData();
            $can = $manageUserAuthorityManageData->CanChannelCreate($siteId, $channelId, $manageUserId);
            if (!$can) {
                $resultJavaScript = Control::GetJqueryMessage(Language::Load('document', 26));

            } else {
                $documentNewsManageData = new DocumentNewsManageData();

                $siteManageData=new SiteManageData();
                $siteUrl=$siteManageData->GetSiteUrl($siteId,true);

                $templateContent = str_ireplace("{ChannelId}", $channelId, $templateContent);
                $templateContent = str_ireplace("{ChannelName}", $channelName, $templateContent);
                $templateContent = str_ireplace("{DocumentNewsId}", "", $templateContent);
                $templateContent = str_ireplace("{SiteId}", $siteId, $templateContent);
                $templateContent = str_ireplace("{SiteUrl}", $siteUrl, $templateContent);
                $templateContent = str_ireplace("{ManageUserId}", $manageUserId, $templateContent);
                $templateContent = str_ireplace("{ManageUserName}", $manageUserName, $templateContent);
                $templateContent = str_ireplace("{PageIndex}", $pageIndex, $templateContent);

                //pre content
                $documentPreContentManageData = new DocumentPreContentManageData();
                $tagId = "document_pre_content";
                $arrList = $documentPreContentManageData->GetList();
                if (count($arrList) > 0) {
                    Template::ReplaceList($templateContent, $arrList, $tagId);
                } else {
                    Template::RemoveCustomTag($templateContent, $tagId);
                }

                //source common
                $sourceCommonManageData = new SourceCommonManageData();
                $tagId = "source_common_list";
                $arrList = $sourceCommonManageData->GetList();
                if (count($arrList) > 0) {
                    Template::ReplaceList($templateContent, $arrList, $tagId);
                } else {
                    Template::RemoveCustomTag($templateContent, $tagId);
                }

                //document news pic
                $tagId = "document_news_pic";
                Template::RemoveCustomTag($templateContent, $tagId);


                parent::ReplaceWhenCreate($templateContent, $documentNewsManageData->GetFields());

                if (!empty($_POST)) {

                    $httpPostData = $_POST;

                    $timeBegin=Control::GetMicroTime();
                    $documentNewsId = $documentNewsManageData->Create($httpPostData, $manageUserId, $manageUserName);

                    $timeEnd=Control::GetMicroTime();
                    $publishLogManageData = new PublishLogManageData();
                    $publishLogManageData->Create(
                        PublishLogManageData::TRANSFER_TYPE_NO_DEFINE,
                        PublishLogManageData::TABLE_TYPE_DOCUMENT_NEWS,
                        $documentNewsId,
                        "",
                        "",
                        $timeEnd - $timeBegin,
                        "to database $documentNewsId"
                    );


                    //加入操作日志
                    $operateContent = 'Create DocumentNews,POST FORM:' . implode('|', $_POST) . ';\r\nResult:documentNewsId:' . $documentNewsId;
                    self::CreateManageUserLog($operateContent);

                    if ($documentNewsId > 0) {

                        parent::DelAllCache();
                        //title pic1
                        $fileElementName = "file_title_pic_1";
                        $tableType = UploadFileData::UPLOAD_TABLE_TYPE_DOCUMENT_NEWS_TITLE_PIC_1; //
                        $tableId = $documentNewsId;
                        $uploadFile1 = new UploadFile();
                        $uploadFileId1 = 0;
                        $titlePic1Result = self::Upload(
                            $fileElementName,
                            $tableType,
                            $tableId,
                            $uploadFile1,
                            $uploadFileId1
                        );

                        if (intval($titlePic1Result) <= 0) {
                            //上传出错或没有选择文件上传
                        } else {

                        }

                        //title pic2
                        $fileElementName = "file_title_pic_2";
                        $tableType = UploadFileData::UPLOAD_TABLE_TYPE_DOCUMENT_NEWS_TITLE_PIC_2;
                        $uploadFileId2 = 0;
                        $uploadFile2 = new UploadFile();
                        $titlePic2Result = self::Upload(
                            $fileElementName,
                            $tableType,
                            $tableId,
                            $uploadFile2,
                            $uploadFileId2
                        );
                        if (intval($titlePic2Result) <= 0) {
                            //上传出错或没有选择文件上传
                        } else {

                        }
                        //title pic3
                        $fileElementName = "file_title_pic_3";

                        $tableType = UploadFileData::UPLOAD_TABLE_TYPE_DOCUMENT_NEWS_TITLE_PIC_3;
                        $uploadFileId3 = 0;

                        $uploadFile3 = new UploadFile();

                        $titlePic3Result = self::Upload(
                            $fileElementName,
                            $tableType,
                            $tableId,
                            $uploadFile3,
                            $uploadFileId3);
                        if (intval($titlePic3Result) <= 0) {
                            //上传出错或没有选择文件上传
                        } else {

                        }

                        if ($uploadFileId1 > 0 || $uploadFileId2 > 0 || $uploadFileId3 > 0) {
                            $documentNewsManageData->ModifyTitlePic($documentNewsId, $uploadFileId1, $uploadFileId2, $uploadFileId3);
                        }

                        $siteConfigData = new SiteConfigData($siteId);
                        if ($uploadFileId1 > 0) {
                            $documentNewsTitlePic1MobileWidth = $siteConfigData->DocumentNewsTitlePic1MobileWidth;
                            if ($documentNewsTitlePic1MobileWidth > 0) {
                                self::GenUploadFileMobile($uploadFileId1, $documentNewsTitlePic1MobileWidth);
                            }

                            $documentNewsTitlePic1PadWidth = $siteConfigData->DocumentNewsTitlePic1PadWidth;
                            if ($documentNewsTitlePic1PadWidth > 0) {
                                self::GenUploadFilePad($uploadFileId1, $documentNewsTitlePic1PadWidth);
                            }

                            //资讯题图1压缩图宽度值
                            $documentNewsTitlePic1CompressWidth = $siteConfigData->DocumentNewsTitlePic1CompressWidth;
                            //资讯题图1压缩图高度值
                            $documentNewsTitlePic1CompressHeight = $siteConfigData->DocumentNewsTitlePic1CompressHeight;

                            if ($documentNewsTitlePic1CompressWidth > 0 || $documentNewsTitlePic1CompressHeight > 0) {
                                self::GenUploadFileCompress1(
                                    $uploadFileId1,
                                    $documentNewsTitlePic1CompressWidth,
                                    $documentNewsTitlePic1CompressHeight
                                );
                            }


                        }
                        if ($uploadFileId2 > 0) {
                            $documentNewsTitlePic2MobileWidth = $siteConfigData->DocumentNewsTitlePic2MobileWidth;
                            if ($documentNewsTitlePic2MobileWidth > 0) {
                                self::GenUploadFileMobile($uploadFileId2, $documentNewsTitlePic2MobileWidth);
                            }


                            $documentNewsTitlePic2PadWidth = $siteConfigData->DocumentNewsTitlePic2PadWidth;
                            if ($documentNewsTitlePic2PadWidth > 0) {
                                self::GenUploadFilePad($uploadFileId2, $documentNewsTitlePic2PadWidth);
                            }


                            //资讯题图2压缩图宽度值
                            $documentNewsTitlePic2CompressWidth = $siteConfigData->DocumentNewsTitlePic2CompressWidth;
                            //资讯题图2压缩图高度值
                            $documentNewsTitlePic2CompressHeight = $siteConfigData->DocumentNewsTitlePic2CompressHeight;

                            if ($documentNewsTitlePic2CompressWidth > 0 || $documentNewsTitlePic2CompressHeight > 0) {
                                self::GenUploadFileCompress1(
                                    $uploadFileId2,
                                    $documentNewsTitlePic2CompressWidth,
                                    $documentNewsTitlePic2CompressHeight
                                );
                            }
                        }
                        if ($uploadFileId3 > 0) {
                            $documentNewsTitlePic3MobileWidth = $siteConfigData->DocumentNewsTitlePic3MobileWidth;
                            if ($documentNewsTitlePic3MobileWidth > 0) {
                                self::GenUploadFileMobile($uploadFileId3, $documentNewsTitlePic3MobileWidth);
                            }

                            $documentNewsTitlePic3PadWidth = $siteConfigData->DocumentNewsTitlePic2PadWidth;
                            if ($documentNewsTitlePic3PadWidth > 0) {
                                self::GenUploadFilePad($uploadFileId3, $documentNewsTitlePic3PadWidth);
                            }

                        }

                        //新增文档时修改排序号到当前频道的最大排序

                        //2.0.1取得排序聚合频道id，并取值
                        $sortChannelId = $channelManageData->GetSortChannelId($channelId, true);

                        $documentNewsManageData->ModifySortWhenCreate($channelId, $documentNewsId, $sortChannelId);
                        //修改上传文件的tableId;
                        $uploadFiles = Control::PostRequest("f_UploadFiles", "");

                        $arrUploadFiles = explode(",", $uploadFiles);

                        $uploadFileData = new UploadFileData();
                        for ($i = 0; $i < count($arrUploadFiles); $i++) {
                            if (intval($arrUploadFiles[$i]) > 0) {
                                $uploadFileData->ModifyTableId(intval($arrUploadFiles[$i]), $documentNewsId);
                            }
                        }

                        //内容图片处理(DocumentNewsPic)
                        $documentNewsPicManageData = new DocumentNewsPicManageData();
                        $strCreatePicList = $_POST["create_pic_list"];  // 格式: 附件ID1_组图显示1,附件ID2_组图显示2....
                        //$strModifyPicList=Control::PostRequest("modify_pic_list","");
                        //$strDeletePicList=Control::PostRequest("delete_pic_list","");
                        $arrCreatePicList = explode(",", $strCreatePicList);
                        foreach ($arrCreatePicList as $strCreatePic) {
                            $picUploadFileId = substr($strCreatePic, 0, strpos($strCreatePic, "_"));
                            $picShowInPicSlider = substr($strCreatePic, strpos($strCreatePic, "_") + 1);
                            $documentNewsPicManageData->Create($documentNewsId, $picUploadFileId, $picShowInPicSlider);
                        }

                        //发布模式处理
                        $publishType = $channelManageData->GetPublishType($channelId, false);
                        if ($publishType > 0) {
                            switch ($publishType) {
                                case ChannelManageData::PUBLISH_TYPE_AUTO: //自动发布新稿

                                    ///////////////判断是否有操作权限///////////////////
                                    $nowManageUserId = Control::GetManageUserId();
                                    $manageUserAuthorityManageData = new ManageUserAuthorityManageData();
                                    //1 发布本频道文档权限
                                    $can = $manageUserAuthorityManageData->CanChannelPublish($siteId, $channelId, $nowManageUserId);

                                    if (!$can) {
                                        //无权限 跳过
                                        break;
                                    } else {
                                        //修改文档状态为终审
                                        $state = DocumentNewsData::STATE_FINAL_VERIFY;
                                        $documentNewsManageData->ModifyState($documentNewsId, $state);
                                        $executeTransfer = true; //是否执行发布
                                        $publishChannel = true; //是否同时发布频道
                                        $publishQueueManageData = new PublishQueueManageData();
                                        self::PublishDocumentNews($documentNewsId, $publishQueueManageData, $executeTransfer, $publishChannel);
                                        break;
                                    }
                            }
                        }

                        //javascript 处理

                        $closeTab = Control::PostRequest("CloseTab", 0);
                        if ($closeTab == 1) {
                            //$resultJavaScript .= Control::GetCloseTab();
                            Control::GoUrl("/default.php?secu=manage&mod=document_news&m=list&channel_id=$channelId&tab_index=$tabIndex&p=$pageIndex");
                        } elseif ($closeTab == 2) {
                            Control::GoUrl("/default.php?secu=manage&mod=document_news&m=modify&document_news_id=$documentNewsId&tab_index=$tabIndex&p=$pageIndex");

                        } else {
                            Control::GoUrl($_SERVER["PHP_SELF"] . "?" . $_SERVER['QUERY_STRING']);
                        }
                    } else {
                        $resultJavaScript = Control::GetJqueryMessage(Language::Load('document', 2));
                    }
                }
                //去掉s开头的标记 {s_xxx_xxx}
                $patterns = '/\{s_(.*?)\}/';
                $templateContent = preg_replace($patterns, "", $templateContent);
                //去掉c开头的标记 {c_xxx}
                $patterns = '/\{c_(.*?)\}/';
                $templateContent = preg_replace($patterns, "", $templateContent);
                //去掉r开头的标记 {r_xxx_xxx}
                $patterns = '/\{r_(.*?)\}/';
                $templateContent = preg_replace($patterns, "", $templateContent);
            }
            ////////////////////////////////////////////////////
        }

        parent::ReplaceEnd($templateContent);
        $templateContent = str_ireplace("{ResultJavascript}", $resultJavaScript, $templateContent);
        return $templateContent;
    }

    /**
     * 生成资讯管理修改页面
     * @return mixed|string
     */
    private function GenModify()
    {
        $editorSet = 'tiny';//默认使用tinyMce编辑器
        $editorCookie = '';

        if (isset($_COOKIE["editor"])) {
            $editorCookie = $_COOKIE["editor"];
        }

        $editorGet = Control::GetRequest("editor", '');

        if ($editorGet == "xh" || $editorCookie == "XH") {
            $editorSet = "xh";
        }

        if ($editorSet == "xh") {
            $templateContent = Template::Load("document/document_news_deal_editor_xh.html", "common");
        } else {
            $templateContent = Template::Load("document/document_news_deal_editor_tiny.html", "common");
        }
        $documentNewsId = Control::GetRequest("document_news_id", 0);

        $nowManageUserId = Control::GetManageUserId();
        $pageIndex = Control::GetRequest("p", 1);
        $tabIndex = Control::GetRequest("tab_index", 0);
        $resultJavaScript = "";
        parent::ReplaceFirst($templateContent);
        if ($documentNewsId > 0) {
            $documentNewsManageData = new DocumentNewsManageData();
            $manageUserManageData = new ManageUserManageData();
            //检查编辑锁
            $lockEdit = $documentNewsManageData->GetLockEdit($documentNewsId, false);
            $lockEditDate = $documentNewsManageData->GetLockEditDate($documentNewsId, false);
            $lockEditManageUserId = $documentNewsManageData->GetLockEditManageUserId($documentNewsId, false);

            $dateNowSpan = strtotime(date("Y-m-d H:i:s", time()));
            $lockEditDateSpan = strtotime(date("Y-m-d H:i:s", strtotime($lockEditDate)) . " +5 minute");

            if ($lockEditManageUserId > 0 && $lockEdit > 0 && $lockEditDateSpan > $dateNowSpan && empty($_POST) && $lockEditManageUserId != $nowManageUserId) {
                //当前已经锁定，并且锁定时间在5分钟内

                $lockEditManageUserName = $manageUserManageData->GetManageUserName($lockEditManageUserId, true);
                $returnInfo = Language::Load('document', 36);
                $returnInfo = str_ireplace("{manage_user_name}", $lockEditManageUserName, $returnInfo);
                return $returnInfo;
            } else {
                //未锁定，则上锁
                $lockEdit = 1;
                $documentNewsManageData->ModifyLockEdit($documentNewsId, $lockEdit, $nowManageUserId);
            }


            $channelManageData = new ChannelManageData();
            $channelId = $documentNewsManageData->GetChannelId($documentNewsId, true);
            $withCache = FALSE;
            $siteId = $channelManageData->GetSiteId($channelId, $withCache);


            ///////////////判断是否有操作权限///////////////////
            $manageUserAuthorityManageData = new ManageUserAuthorityManageData();
            //1 编辑本频道文档权限
            $can = $manageUserAuthorityManageData->CanChannelModify($siteId, $channelId, $nowManageUserId);
            if ($can) { //有编辑本频道文档权限
                //2 检查是否有在本频道编辑他人文档的权限
                $documentNewsManageUserId = $documentNewsManageData->GetManageUserId($documentNewsId, true);
                if ($documentNewsManageUserId !== $nowManageUserId) { //发稿人与当前操作人不是同一人时才判断
                    $can = $manageUserAuthorityManageData->CanChannelDoOthers($siteId, $channelId, $nowManageUserId);
                } else {
                    //如果发稿人与当前操作人是同一人，则不处理
                }
                //3 检查是否有在本频道编辑同一管理组他人文档的权限
                if (!$can) {
                    //是否是同一管理组
                    $documentNewsManageUserGroupId = $manageUserManageData->GetManageUserGroupId($documentNewsManageUserId, true);
                    $nowManageUserGroupId = $manageUserManageData->GetManageUserGroupId($nowManageUserId, true);

                    if ($documentNewsManageUserGroupId == $nowManageUserGroupId) {
                        //是同一组才进行判断
                        $can = $manageUserAuthorityManageData->CanChannelDoSameGroupOthers($siteId, $channelId, $nowManageUserId);
                    }
                }
            }
            if (!$can) {
                return Language::Load('document', 26);
            }

            ////////////////////////////////////////////////////

            $siteManageData=new SiteManageData();
            $siteUrl=$siteManageData->GetSiteUrl($siteId,true);

            $templateContent = str_ireplace("{ChannelId}", $channelId, $templateContent);
            $templateContent = str_ireplace("{DocumentNewsId}", $documentNewsId, $templateContent);
            $templateContent = str_ireplace("{SiteId}", $siteId, $templateContent);
            $templateContent = str_ireplace("{SiteUrl}", $siteUrl, $templateContent);
            $templateContent = str_ireplace("{PageIndex}", $pageIndex, $templateContent);

            /////////////////////////////////////////////////
            //pre content
            $documentPreContentManageData = new DocumentPreContentManageData();
            $tagId = "document_pre_content";
            $arrList = $documentPreContentManageData->GetList();
            if (count($arrList) > 0) {
                Template::ReplaceList($templateContent, $arrList, $tagId);
            } else {
                Template::RemoveCustomTag($templateContent, $tagId);
            }

            //source common
            $sourceCommonManageData = new SourceCommonManageData();
            $tagId = "source_common_list";
            $arrList = $sourceCommonManageData->GetList();
            if (count($arrList) > 0) {
                Template::ReplaceList($templateContent, $arrList, $tagId);
            } else {
                Template::RemoveCustomTag($templateContent, $tagId);
            }

            //document news pic
            $documentNewsPicManageData = new DocumentNewsPicManageData();
            $tagId = "document_news_pic";
            $arrPicList = $documentNewsPicManageData->GetList($documentNewsId);
            if (count($arrPicList) > 0) {
                Template::ReplaceList($templateContent, $arrPicList, $tagId);
            } else {
                Template::RemoveCustomTag($templateContent, $tagId);
            }

            $arrOne = $documentNewsManageData->GetOne($documentNewsId);
            Template::ReplaceOne($templateContent, $arrOne, false, false);
            //去掉s开头的标记 {s_xxx_xxx}
            $patterns = '/\{s_(.*?)\}/';
            $templateContent = preg_replace($patterns, "", $templateContent);
            //去掉c开头的标记 {c_xxx}
            $patterns = '/\{c_(.*?)\}/';
            $templateContent = preg_replace($patterns, "", $templateContent);
            //去掉r开头的标记 {r_xxx_xxx}
            $patterns = '/\{r_(.*?)\}/';
            $templateContent = preg_replace($patterns, "", $templateContent);
            if (!empty($_POST)) {

                $httpPostData = $_POST;

                $result = $documentNewsManageData->Modify($httpPostData, $documentNewsId);

                //加入操作日志
                $operateContent = 'Modify DocumentNews,POST FORM:' . implode('|', $_POST) . ';\r\nResult:' . $result;
                self::CreateManageUserLog($operateContent);

                if ($result > 0) {
                    //删除缓冲

                    parent::DelAllCache();
                    //编辑完成后，解锁
                    $lockEdit = 0;
                    $documentNewsManageData->ModifyLockEdit($documentNewsId, $lockEdit, $nowManageUserId);

                    $state = DocumentNewsData::STATE_MODIFY; //修改状态为已编
                    $documentNewsManageData->ModifyState($documentNewsId, $state);

                    //题图操作
                    if (!empty($_FILES)) {

                        $tableId = $documentNewsId;

                        //title pic1
                        $fileElementName = "file_title_pic_1";
                        $tableType = UploadFileData::UPLOAD_TABLE_TYPE_DOCUMENT_NEWS_TITLE_PIC_1; //channel

                        $uploadFile1 = new UploadFile();
                        $uploadFileId1 = 0;
                        $titlePic1Result = self::Upload(
                            $fileElementName,
                            $tableType,
                            $tableId,
                            $uploadFile1,
                            $uploadFileId1
                        );

                        if (intval($titlePic1Result) <= 0 && $uploadFileId1 <= 0) {
                            //上传出错或没有选择文件上传
                        } else {
                            //删除原有题图
                            $oldUploadFileId1 = $documentNewsManageData->GetTitlePic1UploadFileId($documentNewsId, false);
                            parent::DeleteUploadFile($oldUploadFileId1);

                            //修改题图
                            $documentNewsManageData->ModifyTitlePic1UploadFileId($documentNewsId, $uploadFileId1);
                        }

                        //title pic2
                        $fileElementName = "file_title_pic_2";
                        $tableType = UploadFileData::UPLOAD_TABLE_TYPE_DOCUMENT_NEWS_TITLE_PIC_2;
                        $uploadFileId2 = 0;
                        $uploadFile2 = new UploadFile();
                        $titlePic2Result = self::Upload(
                            $fileElementName,
                            $tableType,
                            $tableId,
                            $uploadFile2,
                            $uploadFileId2
                        );
                        if (intval($titlePic2Result) <= 0) {
                            //上传出错或没有选择文件上传
                        } else {
                            //删除原有题图
                            $oldUploadFileId2 = $documentNewsManageData->GetTitlePic2UploadFileId($documentNewsId, false);
                            parent::DeleteUploadFile($oldUploadFileId2);

                            //修改题图
                            $documentNewsManageData->ModifyTitlePic2UploadFileId($documentNewsId, $uploadFileId2);
                        }
                        //title pic3
                        $fileElementName = "file_title_pic_3";

                        $tableType = UploadFileData::UPLOAD_TABLE_TYPE_DOCUMENT_NEWS_TITLE_PIC_3;
                        $uploadFileId3 = 0;

                        $uploadFile3 = new UploadFile();

                        $titlePic3Result = self::Upload(
                            $fileElementName,
                            $tableType,
                            $tableId,
                            $uploadFile3,
                            $uploadFileId3
                        );
                        if (intval($titlePic3Result) <= 0) {
                            //上传出错或没有选择文件上传
                        } else {
                            //删除原有题图
                            $oldUploadFileId3 = $documentNewsManageData->GetTitlePic3UploadFileId($documentNewsId, false);
                            parent::DeleteUploadFile($oldUploadFileId3);

                            //修改题图
                            $documentNewsManageData->ModifyTitlePic3UploadFileId($documentNewsId, $uploadFileId3);
                        }

                        //重新制作题图1的相关图片
                        $siteConfigData = new SiteConfigData($siteId);
                        if ($uploadFileId1 > 0) {
                            $documentNewsTitlePic1MobileWidth = $siteConfigData->DocumentNewsTitlePic1MobileWidth;
                            if ($documentNewsTitlePic1MobileWidth > 0) {
                                self::GenUploadFileMobile($uploadFileId1, $documentNewsTitlePic1MobileWidth);
                            }


                            $documentNewsTitlePic1PadWidth = $siteConfigData->DocumentNewsTitlePic1PadWidth;
                            if ($documentNewsTitlePic1PadWidth > 0) {
                                self::GenUploadFilePad($uploadFileId1, $documentNewsTitlePic1PadWidth);
                            }


                            //资讯题图1压缩图宽度值
                            $documentNewsTitlePic1CompressWidth = $siteConfigData->DocumentNewsTitlePic1CompressWidth;
                            //资讯题图1压缩图高度值
                            $documentNewsTitlePic1CompressHeight = $siteConfigData->DocumentNewsTitlePic1CompressHeight;

                            if ($documentNewsTitlePic1CompressWidth > 0 || $documentNewsTitlePic1CompressHeight > 0) {
                                self::GenUploadFileCompress1(
                                    $uploadFileId1,
                                    $documentNewsTitlePic1CompressWidth,
                                    $documentNewsTitlePic1CompressHeight
                                );
                            }

                        }

                        if ($uploadFileId2 > 0) {
                            $documentNewsTitlePic2MobileWidth = $siteConfigData->DocumentNewsTitlePic2MobileWidth;
                            if ($documentNewsTitlePic2MobileWidth > 0) {
                                self::GenUploadFileMobile($uploadFileId2, $documentNewsTitlePic2MobileWidth);
                            }


                            $documentNewsTitlePic2PadWidth = $siteConfigData->DocumentNewsTitlePic2PadWidth;
                            if ($documentNewsTitlePic2PadWidth > 0) {
                                self::GenUploadFilePad($uploadFileId2, $documentNewsTitlePic2PadWidth);
                            }


                            //资讯题图2压缩图宽度值
                            $documentNewsTitlePic2CompressWidth = intval($siteConfigData->DocumentNewsTitlePic2CompressWidth);
                            //资讯题图2压缩图高度值
                            $documentNewsTitlePic2CompressHeight = intval($siteConfigData->DocumentNewsTitlePic2CompressHeight);

                            if ($documentNewsTitlePic2CompressWidth > 0 || $documentNewsTitlePic2CompressHeight > 0) {
                                self::GenUploadFileCompress1(
                                    $uploadFileId2,
                                    $documentNewsTitlePic2CompressWidth,
                                    $documentNewsTitlePic2CompressHeight
                                );
                            }
                        }

                        if ($uploadFileId3 > 0) {
                            $documentNewsTitlePic3MobileWidth = $siteConfigData->DocumentNewsTitlePic3MobileWidth;
                            if ($documentNewsTitlePic3MobileWidth > 0) {
                                self::GenUploadFileMobile($uploadFileId3, $documentNewsTitlePic3MobileWidth);
                            }

                            $documentNewsTitlePic3PadWidth = $siteConfigData->DocumentNewsTitlePic3PadWidth;
                            if ($documentNewsTitlePic3PadWidth > 0) {
                                self::GenUploadFilePad($uploadFileId3, $documentNewsTitlePic3PadWidth);
                            }

                        }
                    }


                    //修改上传文件的tableId;
                    $uploadFileData = new UploadFileData();
                    $uploadFiles = Control::PostRequest("f_UploadFiles", "");
                    $arrUploadFiles = explode(",", $uploadFiles);
                    $isBatchUpload = 0;
                    if (isset($_POST['c_ShowPicMethod']) && $_POST['c_ShowPicMethod'] == 'on') {
                        $isBatchUpload = 1;
                    }
                    for ($i = 0; $i < count($arrUploadFiles); $i++) {
                        if (intval($arrUploadFiles[$i]) > 0) {
                            $uploadFileData->ModifyTableId(intval($arrUploadFiles[$i]), $documentNewsId);
                            if ($isBatchUpload > 0) {
                                $uploadFileData->ModifyIsBatchUpload(intval($arrUploadFiles[$i]), $isBatchUpload);
                            }
                        }
                    }


                    //内容图片处理(DocumentNewsPic)
                    $documentNewsPicManageData = new DocumentNewsPicManageData();
                    //处理新增
                    $strCreatePicList = $_POST["create_pic_list"];  // 格式: 附件ID1_组图显示1,附件ID2_组图显示2....
                    $arrCreatePicList = explode(",", $strCreatePicList);
                    foreach ($arrCreatePicList as $strCreatePic) {
                        $picUploadFileId = substr($strCreatePic, 0, strpos($strCreatePic, "_"));
                        $picShowInPicSlider = substr($strCreatePic, strpos($strCreatePic, "_") + 1);
                        $documentNewsPicManageData->Create($documentNewsId, $picUploadFileId, $picShowInPicSlider);
                    }
                    //处理修改
                    $strModifyPicList = $_POST["modify_pic_list"];  // 格式: 内容图ID1_组图显示1,内容图ID2_组图显示2....
                    $arrModifyPicList = explode(",", $strModifyPicList);
                    foreach ($arrModifyPicList as $strModifyPic) {
                        $picDocumentNewsPicId = substr($strModifyPic, 0, strpos($strModifyPic, "_"));
                        $picShowInPicSlider = substr($strModifyPic, strpos($strModifyPic, "_") + 1);
                        $documentNewsPicManageData->ChangeShowingState($picDocumentNewsPicId, $picShowInPicSlider);
                    }
                    //处理删除
                    $strDeletePicIdList = $_POST["delete_pic_list"];  // 格式: 内容图ID1_组图显示1,内容图ID2_组图显示2....
                    $arrDeletePicIdList = explode(",", $strDeletePicIdList);
                    foreach ($arrDeletePicIdList as $strDeletePicId) {
                        $documentNewsPicManageData->Delete($strDeletePicId);
                    }


                    //发布模式处理
                    $publishType = $channelManageData->GetPublishType($channelId, false);
                    if ($publishType > 0) {
                        switch ($publishType) {
                            case ChannelManageData::PUBLISH_TYPE_AUTO: //自动发布新稿

                                ///////////////判断是否有操作权限///////////////////
                                $nowManageUserId = Control::GetManageUserId();
                                $manageUserAuthorityManageData = new ManageUserAuthorityManageData();
                                //1 发布本频道文档权限
                                $can = $manageUserAuthorityManageData->CanChannelPublish($siteId, $channelId, $nowManageUserId);

                                if (!$can) {
                                    //无权限 跳过
                                    break;
                                } else {
                                    //修改文档状态为终审
                                    $state = DocumentNewsData::STATE_FINAL_VERIFY;
                                    $documentNewsManageData->ModifyState($documentNewsId, $state);
                                    $executeTransfer = true; //是否执行发布
                                    $publishChannel = true; //是否同时发布频道
                                    $publishQueueManageData = new PublishQueueManageData();
                                    self::PublishDocumentNews($documentNewsId, $publishQueueManageData, $executeTransfer, $publishChannel);
                                    break;
                                }
                        }
                    }

                    //javascript 处理

                    $closeTab = Control::PostRequest("CloseTab", 0);
                    if ($closeTab == 1) {
                        //$resultJavaScript .= Control::GetCloseTab();
                        Control::GoUrl("/default.php?secu=manage&mod=document_news&m=list&channel_id=$channelId&tab_index=$tabIndex&p=$pageIndex");
                    } elseif ($closeTab == 2) {

                        //确认并编辑
                        Control::GoUrl("/default.php?secu=manage&mod=document_news&m=modify&document_news_id=$documentNewsId&tab_index=$tabIndex&p=$pageIndex");


                    } else {
                        Control::GoUrl($_SERVER["PHP_SELF"] . "?" . $_SERVER['QUERY_STRING']);
                    }
                } else {
                    $resultJavaScript = Control::GetJqueryMessage(Language::Load('document', 4));
                }
            }
        }
        parent::ReplaceEnd($templateContent);
        $templateContent = str_ireplace("{ResultJavascript}", $resultJavaScript, $templateContent);
        return $templateContent;
    }

    private function GenRemoveToBin()
    {
        $result = "";
        return $result;
    }


    /**
     * 发布资讯详细页面
     * @return string 返回发布结果
     */
    private function AsyncPublish()
    {
        $result = '';
        $documentNewsId = Control::GetRequest("document_news_id", -1);
        if ($documentNewsId > 0) {
            $documentNewsManageData = new DocumentNewsManageData();
            $channelId = $documentNewsManageData->GetChannelId($documentNewsId, true);

            $channelManageData = new ChannelManageData();
            $siteId = $channelManageData->GetSiteId($channelId, true);

            $nowManageUserId = Control::GetManageUserId();
            ///////////////判断是否有操作权限///////////////////
            $manageUserAuthorityManageData = new ManageUserAuthorityManageData();
            //1 发布本频道文档权限
            $can = $manageUserAuthorityManageData->CanChannelPublish($siteId, $channelId, $nowManageUserId);

            if (!$can) {
                $result = $result = DefineCode::PUBLISH + self::PUBLISH_DOCUMENT_NEWS_RESULT_NO_RIGHT;
            } else {

                //删除缓冲
                parent::DelAllCache();

                $publishQueueManageData = new PublishQueueManageData();
                $executeTransfer = true;
                $publishChannel = true;
                $result = parent::PublishDocumentNews($documentNewsId, $publishQueueManageData, $executeTransfer, $publishChannel);
                if ($result == (abs(DefineCode::PUBLISH) + BaseManageGen::PUBLISH_DOCUMENT_NEWS_RESULT_FINISHED)) {
                    $result = '';
                    $siteManageData=new SiteManageData();
                    $siteUrl=$siteManageData->GetSiteUrl($siteId,true);
                    for ($i = 0; $i < count($publishQueueManageData->Queue); $i++) {

                        $publishResult = "";

                        if (intval($publishQueueManageData->Queue[$i]["Result"]) ==
                            abs(DefineCode::PUBLISH) + BaseManageGen::PUBLISH_TRANSFER_RESULT_SUCCESS
                        ) {
                            $publishResult = "Ok";
                        }
                        if (intval($publishQueueManageData->Queue[$i]["Result"]) ==
                            abs(DefineCode::FTP) + FtpTools::FTP_TRANSFER_SUCCESS
                        ) {
                            $publishResult = "FtpOk";
                        }


                        $result .= '<a href="'.$siteUrl.'/'.$publishQueueManageData->Queue[$i]["DestinationPath"].'" target="_blank">'.$publishQueueManageData->Queue[$i]["DestinationPath"].'</a> -> '.$publishResult
                            . '<br />';
                    }
                }
            }


        }
        return $result;
    }


    /**
     *批量发布已选
     */
    private function AsyncBatchPublishSelected(){

        $result = '';
        //$documentNewsId = Control::GetRequest("document_news_id_str", "");
        $documentNewsIdStr=$_GET["document_news_id_str"];

        $currentChannelId=0;//在循环内赋值，供循环外发布文件用
        $currentSiteId=0;

        if($documentNewsIdStr !=""&&$documentNewsIdStr!=null){

            $documentNewsManageData = new DocumentNewsManageData();
            $channelManageData = new ChannelManageData();
            $manageUserAuthorityManageData = new ManageUserAuthorityManageData();
            $publishQueueManageData = new PublishQueueManageData();

            $arrayOfDocumentNewsIds=explode(",",$documentNewsIdStr);
            for($i=0;$i<count($arrayOfDocumentNewsIds);++$i){
                $documentNewsId=$arrayOfDocumentNewsIds[$i];

                if ($documentNewsId > 0) {
                    $channelId = $documentNewsManageData->GetChannelId($documentNewsId, true);
                    $siteId = $channelManageData->GetSiteId($channelId, true);


                    $currentChannelId=$channelId;
                    $currentSiteId=$siteId;

                    $nowManageUserId = Control::GetManageUserId();
                    ///////////////判断是否有操作权限///////////////////
                    //1 发布本频道文档权限
                    $can = $manageUserAuthorityManageData->CanChannelPublish($siteId, $channelId, $nowManageUserId);

                    if (!$can) {
                        //$result = $result = DefineCode::PUBLISH + self::PUBLISH_DOCUMENT_NEWS_RESULT_NO_RIGHT;
                        $result.="没有权限！<br />";
                    } else {

                        //删除缓冲
                        parent::DelAllCache();

                        $executeTransfer = false;//不分别进行传输
                        $publishChannel=false;
                        parent::PublishDocumentNews($documentNewsId, $publishQueueManageData, $executeTransfer, $publishChannel);

                        sleep(0.1);
                    }


                }
            }

            //执行传输
            $siteManageData=new SiteManageData();
            $siteUrl=$siteManageData->GetSiteUrl($currentSiteId,true);

            parent::TransferPublishQueue($publishQueueManageData, $currentSiteId);
            for ($i = 0;$i< count($publishQueueManageData->Queue); $i++) {

                $publishResult = "";

                if(intval($publishQueueManageData->Queue[$i]["Result"]) ==
                    abs(DefineCode::PUBLISH) + BaseManageGen::PUBLISH_TRANSFER_RESULT_SUCCESS
                ){
                    $publishResult = "Ok";
                    $result .= '<a href="'.$siteUrl.'/'.$publishQueueManageData->Queue[$i]["DestinationPath"].'" target="_blank">'.$publishQueueManageData->Queue[$i]["DestinationPath"].'</a> -> '.$publishResult
                        .'<br />'
                    ;
                }else if(intval($publishQueueManageData->Queue[$i]["Result"]) ==
                    abs(DefineCode::FTP) + FtpTools::FTP_TRANSFER_SUCCESS
                ) {
                    $publishResult = "FtpOk";
                    $result .= '<a href="'.$siteUrl.'/'.$publishQueueManageData->Queue[$i]["DestinationPath"].'" target="_blank">'.$publishQueueManageData->Queue[$i]["DestinationPath"].'</a> -> '.$publishResult
                        .'<br />'
                    ;

                }else{
                    $result .= "<span style='color:red'>ERROR</span><br />";
                }
            }

            //同步发布节点
            $channelPublishResult=self::PublishChannel($currentChannelId, $publishQueueManageData);

            if($channelPublishResult == (abs(DefineCode::PUBLISH) + BaseManageGen::PUBLISH_CHANNEL_RESULT_FINISHED)){
                $channelPublishResult = '';
                for ($i = 0;$i< count($publishQueueManageData->Queue); $i++) {

                    $channelPublishResult = "";

                    if(intval($publishQueueManageData->Queue[$i]["Result"]) ==
                        abs(DefineCode::PUBLISH) + BaseManageGen::PUBLISH_TRANSFER_RESULT_SUCCESS
                    ){
                        $channelPublishResult = "Ok";
                    }else if(intval($publishQueueManageData->Queue[$i]["Result"]) ==
                        abs(DefineCode::FTP) + FtpTools::FTP_TRANSFER_SUCCESS
                    ) {
                        $channelPublishResult = "FtpOk";

                    }


                    $result .= '<a href="'.$siteUrl.'/'.$publishQueueManageData->Queue[$i]["DestinationPath"].'" target="_blank">'.$publishQueueManageData->Queue[$i]["DestinationPath"].'</a> -> '.$channelPublishResult
                        .'<br />'
                    ;
                }
                //print_r($publishQueueManageData->Queue);
            }
            $result.=$channelPublishResult;

        }
        return $result;
    }


    /**
     * 生成资讯管理列表页面
     */
    private function GenList()
    {
        $channelId = Control::GetRequest("channel_id", 0);
        if ($channelId <= 0) {
            return null;
        }
        $manageUserId = Control::GetManageUserId();
        $channelManageData = new ChannelManageData();
        $siteId = $channelManageData->GetSiteId($channelId, false);
        if ($siteId <= 0) {
            return null;
        }

        ///////////////判断是否有操作权限///////////////////
        $manageUserAuthorityManageData = new ManageUserAuthorityManageData();
        $canExplore = $manageUserAuthorityManageData->CanChannelExplore($siteId, $channelId, $manageUserId);
        if (!$canExplore) {
            die(Language::Load('channel', 4));
        }

        //load template
        $templateContent = Template::Load("document/document_news_list.html", "common");


        parent::ReplaceFirst($templateContent);

        ////////////////////////////////////////////////////
        ///////////////输出权限到页面///////////////////
        ////////////////////////////////////////////////////
        $canRework = $manageUserAuthorityManageData->CanChannelRework($siteId, $channelId, $manageUserId);
        $canAudit1 = $manageUserAuthorityManageData->CanChannelAudit1($siteId, $channelId, $manageUserId);
        $canAudit2 = $manageUserAuthorityManageData->CanChannelAudit2($siteId, $channelId, $manageUserId);
        $canAudit3 = $manageUserAuthorityManageData->CanChannelAudit3($siteId, $channelId, $manageUserId);
        $canAudit4 = $manageUserAuthorityManageData->CanChannelAudit4($siteId, $channelId, $manageUserId);
        $canRefused = $manageUserAuthorityManageData->CanChannelRefused($siteId, $channelId, $manageUserId);
        $canPublish = $manageUserAuthorityManageData->CanChannelPublish($siteId, $channelId, $manageUserId);
        $canModify = $manageUserAuthorityManageData->CanChannelModify($siteId, $channelId, $manageUserId);
        $canCreate = $manageUserAuthorityManageData->CanChannelCreate($siteId, $channelId, $manageUserId);


        $templateContent = str_ireplace("{CanRework}", $canRework == 1 ? "" : "display:none", $templateContent);
        $templateContent = str_ireplace("{CanAudit1}", $canAudit1 == 1 ? "" : "display:none", $templateContent);
        $templateContent = str_ireplace("{CanAudit2}", $canAudit2 == 1 ? "" : "display:none", $templateContent);
        $templateContent = str_ireplace("{CanAudit3}", $canAudit3 == 1 ? "" : "display:none", $templateContent);
        $templateContent = str_ireplace("{CanAudit4}", $canAudit4 == 1 ? "" : "display:none", $templateContent);
        $templateContent = str_ireplace("{CanRefused}", $canRefused == 1 ? "" : "display:none", $templateContent);
        $templateContent = str_ireplace("{CanPublish}", $canPublish == 1 ? "" : "display:none", $templateContent);
        $templateContent = str_ireplace("{CanModify}", $canModify == 1 ? "" : "display:none", $templateContent);
        $templateContent = str_ireplace("{CanCreate}", $canCreate == 1 ? "" : "display:none", $templateContent);

        $pageSize = Control::GetRequest("ps", 20);
        $pageIndex = Control::GetRequest("p", 1);
        $searchKey = Control::GetRequest("search_key", "");
        $searchType = Control::GetRequest("search_type", -1);
        $searchKey = urldecode($searchKey);

        $sort = Control::GetRequest("sort", "");
        $hit = Control::GetRequest("hit", "");

        if (isset($searchKey) && strlen($searchKey) > 0) {
            $canSearch = $manageUserAuthorityManageData->CanChannelSearch($siteId, $channelId, $manageUserId);
            if (!$canSearch) {
                die(Language::Load('channel', 4));
            }
        }

        if ($pageIndex > 0 && $channelId > 0) {

            $templateContent = str_ireplace("{ChannelId}", $channelId, $templateContent);
            $templateContent = str_ireplace("{SiteId}", $siteId, $templateContent);

            $pageBegin = ($pageIndex - 1) * $pageSize;
            $tagId = "document_news_list";
            $allCount = 0;
            $isSelf = Control::GetRequest("is_self", 0);
            $documentNewsManageData = new DocumentNewsManageData();
            $arrDocumentNewsList = $documentNewsManageData->GetList(
                $channelId,
                $pageBegin,
                $pageSize,
                $allCount,
                $searchKey,
                $searchType,
                $isSelf,
                $manageUserId,
                $sort,
                $hit
            );
            if (count($arrDocumentNewsList) > 0) {
                Template::ReplaceList($templateContent, $arrDocumentNewsList, $tagId);

                $styleNumber = 1;
                $pagerTemplate = Template::Load("pager/pager_style$styleNumber.html", "common");
                $isJs = FALSE;
                $navUrl = "default.php?secu=manage&mod=document_news&m=list&channel_id=$channelId&p={0}&ps=$pageSize&isself=$isSelf&sort=$sort&hit=$hit";
                $jsFunctionName = "";
                $jsParamList = "";
                $pagerButton = Pager::ShowPageButton($pagerTemplate, $navUrl, $allCount, $pageSize, $pageIndex, $styleNumber, $isJs, $jsFunctionName, $jsParamList);

                $templateContent = str_ireplace("{pager_button}", $pagerButton, $templateContent);

            } else {
                Template::RemoveCustomTag($templateContent, $tagId);
                $templateContent = str_ireplace("{pager_button}", Language::Load("document", 7), $templateContent);
            }
        }

        parent::ReplaceEnd($templateContent);
        return $templateContent;
    }
    /**
     * 生成资讯搜索管理列表页面
     */
    private function GenSearchForManage()
    {
        $siteId = Control::GetRequest("site_id", 0);
        $lastDocumentNewsId=Control::GetRequest("last_document_news_id", 999999999);
        $manageUserName=Control::GetRequest("manage_user_name", "");
        $userName=Control::GetRequest("user_name", "");
        $beginDate=Control::GetRequest("begin_date", "");
        $endDate=Control::GetRequest("end_date", "");
        $state=Control::GetRequest("state", "0");

        $manageUserId = Control::GetManageUserId();

        ///////////////判断是否有操作权限///////////////////
        $manageUserAuthorityManageData = new ManageUserAuthorityManageData();
        $canExplore = $manageUserAuthorityManageData->CanChannelExplore($siteId, 0, $manageUserId);
        if (!$canExplore) {
            //die(Language::Load('channel', 4));
        }

        //load template
        $templateContent = Template::Load("document/document_news_search.html", "common");


        parent::ReplaceFirst($templateContent);


        $pageSize = Control::GetRequest("ps", 20);
        $searchKey = Control::GetRequest("search_key", "");
        $searchKey = urldecode($searchKey);

        $searchKey = str_ireplace("　"," ",$searchKey);//多个关键字空格隔开
        $arrayOfSearchKey=explode(" ",$searchKey);
        if(count($arrayOfSearchKey)<=1){
            $arrayOfSearchKey=null;
        }


        //$searchType = Control::GetRequest("search_type", -1);
        //$sort = Control::GetRequest("sort", "");
        //$hit = Control::GetRequest("hit", "");

        if (isset($searchKey) && strlen($searchKey) > 0) {
            $canSearch = $manageUserAuthorityManageData->CanChannelSearch($siteId, 0, $manageUserId);
            if (!$canSearch) {
                //die(Language::Load('channel', 4));
            }
        }



        $templateContent = str_ireplace("{ManageUserId}", $siteId, $templateContent);
        $templateContent = str_ireplace("{SiteId}", $siteId, $templateContent);
        $templateContent = str_ireplace("{State}", $state, $templateContent);
        $tagId = "document_news_list";
        $isSelf = Control::GetRequest("is_self", 0);
        $documentNewsManageData = new DocumentNewsManageData();
        $arrDocumentNewsList = $documentNewsManageData->GetSearchListForManage(
            $siteId,
            $pageSize,
            $lastDocumentNewsId,
            $searchKey,
            $arrayOfSearchKey,
            $manageUserName,
            $userName,
            $beginDate,
            $endDate,
            0, //manage user id
            $state
        );

        $lengthCount=count($arrDocumentNewsList);
        if ($lengthCount > 0) {
            Template::ReplaceList($templateContent, $arrDocumentNewsList, $tagId);
            $templateContent = str_ireplace("{pager_button}", "", $templateContent);
            $templateContent = str_ireplace("{LastDocumentNewsId}", $arrDocumentNewsList[$lengthCount-1]["DocumentNewsId"], $templateContent);

        } else {
            Template::RemoveCustomTag($templateContent, $tagId);
            $templateContent = str_ireplace("{pager_button}", Language::Load("document", 7), $templateContent);
            $templateContent = str_ireplace("{LastDocumentNewsId}", "", $templateContent);
        }

        $templateContent = str_ireplace("{SearchKey}", $searchKey, $templateContent);
        $templateContent = str_ireplace("{ManageUserName}", $manageUserName, $templateContent);
        $templateContent = str_ireplace("{UserName}", $userName, $templateContent);
        $templateContent = str_ireplace("{BeginDate}", $beginDate, $templateContent);
        $templateContent = str_ireplace("{EndDate}", $endDate, $templateContent);
        parent::ReplaceEnd($templateContent);
        return $templateContent;
    }


    /**
     * 生成集合资讯管理列表页面
     */
    private function GenListOfCollection(){
        $channelId = Control::GetRequest("channel_id", 0);
        if ($channelId <= 0) {
            return null;
        }
        $manageUserId = Control::GetManageUserId();
        $channelManageData = new ChannelManageData();
        $siteId = $channelManageData->GetSiteId($channelId, false);
        if ($siteId <= 0) {
            return null;
        }

        ///////////////判断是否有操作权限///////////////////
        $manageUserAuthorityManageData = new ManageUserAuthorityManageData();
        $canExplore = $manageUserAuthorityManageData->CanChannelExplore($siteId, $channelId, $manageUserId);
        if (!$canExplore) {
            die(Language::Load('channel', 4));
        }

        //load template
        $templateContent = Template::Load("document/document_news_list.html", "common");


        parent::ReplaceFirst($templateContent);

        ////////////////////////////////////////////////////
        ///////////////输出权限到页面///////////////////
        ////////////////////////////////////////////////////
        $canRework = $manageUserAuthorityManageData->CanChannelRework($siteId, $channelId, $manageUserId);
        $canAudit1 = $manageUserAuthorityManageData->CanChannelAudit1($siteId, $channelId, $manageUserId);
        $canAudit2 = $manageUserAuthorityManageData->CanChannelAudit2($siteId, $channelId, $manageUserId);
        $canAudit3 = $manageUserAuthorityManageData->CanChannelAudit3($siteId, $channelId, $manageUserId);
        $canAudit4 = $manageUserAuthorityManageData->CanChannelAudit4($siteId, $channelId, $manageUserId);
        $canRefused = $manageUserAuthorityManageData->CanChannelRefused($siteId, $channelId, $manageUserId);
        $canPublish = $manageUserAuthorityManageData->CanChannelPublish($siteId, $channelId, $manageUserId);
        $canModify = $manageUserAuthorityManageData->CanChannelModify($siteId, $channelId, $manageUserId);
        $canCreate = $manageUserAuthorityManageData->CanChannelCreate($siteId, $channelId, $manageUserId);


        $templateContent = str_ireplace("{CanRework}", $canRework == 1 ? "" : "display:none", $templateContent);
        $templateContent = str_ireplace("{CanAudit1}", $canAudit1 == 1 ? "" : "display:none", $templateContent);
        $templateContent = str_ireplace("{CanAudit2}", $canAudit2 == 1 ? "" : "display:none", $templateContent);
        $templateContent = str_ireplace("{CanAudit3}", $canAudit3 == 1 ? "" : "display:none", $templateContent);
        $templateContent = str_ireplace("{CanAudit4}", $canAudit4 == 1 ? "" : "display:none", $templateContent);
        $templateContent = str_ireplace("{CanRefused}", $canRefused == 1 ? "" : "display:none", $templateContent);
        $templateContent = str_ireplace("{CanPublish}", $canPublish == 1 ? "" : "display:none", $templateContent);
        $templateContent = str_ireplace("{CanModify}", $canModify == 1 ? "" : "display:none", $templateContent);
        $templateContent = str_ireplace("{CanCreate}", $canCreate == 1 ? "" : "display:none", $templateContent);

        $pageSize = Control::GetRequest("ps", 20);
        $pageIndex = Control::GetRequest("p", 1);
        $searchKey = Control::GetRequest("search_key", "");
        $searchType = Control::GetRequest("search_type", -1);
        $searchKey = urldecode($searchKey);

        $sort = Control::GetRequest("sort", "");
        $hit = Control::GetRequest("hit", "");

        if (isset($searchKey) && strlen($searchKey) > 0) {
            $canSearch = $manageUserAuthorityManageData->CanChannelSearch($siteId, $channelId, $manageUserId);
            if (!$canSearch) {
                die(Language::Load('channel', 4));
            }
        }

        if ($pageIndex > 0 && $channelId > 0) {

            $templateContent = str_ireplace("{ChannelId}", $channelId, $templateContent);
            $templateContent = str_ireplace("{SiteId}", $siteId, $templateContent);

            $pageBegin = ($pageIndex - 1) * $pageSize;
            $tagId = "document_news_list";
            $allCount = 0;
            $isSelf = Control::GetRequest("is_self", 0);

            $channelIds = $channelManageData->GetCollectChannelId($channelId, true);


            $documentNewsManageData = new DocumentNewsManageData();
            $arrDocumentNewsList = $documentNewsManageData->GetListOfCollection(
                $channelIds,
                $pageBegin,
                $pageSize,
                $allCount,
                $searchKey,
                $searchType,
                $isSelf,
                $manageUserId,
                $sort,
                $hit
            );
            if (count($arrDocumentNewsList) > 0) {
                Template::ReplaceList($templateContent, $arrDocumentNewsList, $tagId);

                $styleNumber = 1;
                $pagerTemplate = Template::Load("pager/pager_style$styleNumber.html", "common");
                $isJs = FALSE;
                $navUrl = "default.php?secu=manage&mod=document_news&m=list&channel_id=$channelId&p={0}&ps=$pageSize&isself=$isSelf&sort=$sort&hit=$hit";
                $jsFunctionName = "";
                $jsParamList = "";
                $pagerButton = Pager::ShowPageButton($pagerTemplate, $navUrl, $allCount, $pageSize, $pageIndex, $styleNumber, $isJs, $jsFunctionName, $jsParamList);

                $templateContent = str_ireplace("{pager_button}", $pagerButton, $templateContent);

            } else {
                Template::RemoveCustomTag($templateContent, $tagId);
                $templateContent = str_ireplace("{pager_button}", Language::Load("document", 7), $templateContent);
            }
        }

        parent::ReplaceEnd($templateContent);
        return $templateContent;
    }
    /**
     * 修改排序号
     * @return int 修改结果
     */
    private function AsyncModifySort()
    {
        $result = -1;
        $documentNewsId = Control::GetRequest("document_news_id", 0);
        $sort = Control::GetRequest("sort", 0);
        if ($documentNewsId > 0) {

            parent::DelAllCache();

            $documentNewsManageData = new DocumentNewsManageData();
            $result = $documentNewsManageData->ModifySort($sort, $documentNewsId);
        }
        return $result;
    }


    /**
     * 批量修改排序号
     * @return string 返回Jsonp修改结果
     */
    private function AsyncModifySortByDrag()
    {
        $arrDocumentNewsId = Control::GetRequest("sort", null);
        if (!empty($arrDocumentNewsId)) {

            parent::DelAllCache();
            $documentNewsManageData = new DocumentNewsManageData();
            $result = $documentNewsManageData->ModifySortForDrag($arrDocumentNewsId);
            return Control::GetRequest("jsonpcallback", "") . '({"result":' . $result . '})';
        } else {
            return "";
        }
    }

    /**
     * 修改ManageRemark
     * @return int 修改结果
     */
    private function AsyncModifyManageRemark()
    {
        $result = -1;
        $documentNewsId = Control::getRequest("document_news_id", 0);
        $manageRemark = Control::getRequest("manage_remark", "");
        if ($documentNewsId > 0) {
            $documentNewsManageData = new DocumentNewsManageData();
            $result = $documentNewsManageData->ModifyManageRemark($documentNewsId, $manageRemark);
        }
        return $result;
    }

    /**
     * 修改文档状态 状态值定义在Data类中
     * @return string 返回Jsonp修改结果
     */
    private function AsyncModifyState()
    {
        $result = -1;
        $documentNewsId = Control::GetRequest("document_news_id", 0);
        $state = Control::GetRequest("state", -1);
        if ($documentNewsId > 0 && $state >= 0) {

            parent::DelAllCache();
            $documentNewsManageData = new DocumentNewsManageData();
            $manageUserManageData = new ManageUserManageData();
            $channelId = $documentNewsManageData->GetChannelId($documentNewsId, true);
            $manageUserId = Control::GetManageUserId();
            $siteId = $documentNewsManageData->GetSiteId($documentNewsId, true);
            /**********************************************************************
             ******************************判断是否有操作权限**********************
             **********************************************************************/
            $manageUserAuthorityManageData = new ManageUserAuthorityManageData();
            $can = false;
            switch ($state) {
                case DocumentNewsData::STATE_REDO :
                    $can = $manageUserAuthorityManageData->CanChannelRework($siteId, $channelId, $manageUserId);
                    break;
                case DocumentNewsData::STATE_FIRST_VERIFY :
                    $can = $manageUserAuthorityManageData->CanChannelAudit1($siteId, $channelId, $manageUserId);
                    break;
                case DocumentNewsData::STATE_SECOND_VERIFY :
                    $can = $manageUserAuthorityManageData->CanChannelAudit2($siteId, $channelId, $manageUserId);
                    break;
                case DocumentNewsData::STATE_THIRD_VERIFY :
                    $can = $manageUserAuthorityManageData->CanChannelAudit3($siteId, $channelId, $manageUserId);
                    break;
                case DocumentNewsData::STATE_FINAL_VERIFY :
                    $can = $manageUserAuthorityManageData->CanChannelAudit4($siteId, $channelId, $manageUserId);
                    break;
                case DocumentNewsData::STATE_REFUSE :
                    $can = $manageUserAuthorityManageData->CanChannelRefused($siteId, $channelId, $manageUserId);
                    break;
            }
            if ($can) { //有修改状态权限
                //2 检查是否有在本频道编辑他人文档的权限
                $documentNewsManageUserId = $documentNewsManageData->GetManageUserId($documentNewsId, true);
                if ($documentNewsManageUserId !== $manageUserId) { //发稿人与当前操作人不是同一人时才判断
                    $can = $manageUserAuthorityManageData->CanChannelDoOthers($siteId, $channelId, $manageUserId);
                } else {
                    //如果发稿人与当前操作人是同一人，则不处理
                }
                //3 检查是否有在本频道编辑同一管理组他人文档的权限
                if (!$can) {
                    //是否是同一管理组
                    $documentNewsManageUserGroupId = $manageUserManageData->GetManageUserGroupId($documentNewsManageUserId, true);
                    $nowManageUserGroupId = $manageUserManageData->GetManageUserGroupId($manageUserId, true);
                    if ($documentNewsManageUserGroupId == $nowManageUserGroupId) {
                        //是同一组才进行判断
                        $can = $manageUserAuthorityManageData->CanChannelDoSameGroupOthers($siteId, $channelId, $manageUserId);
                    }
                }
            }
            if (!$can) {
                $result = -2; //没有权限
            }
            ////////////////////////////////////////////////////
            ////////////////////////////////////////////////////
            ////////////////////////////////////////////////////
            ////////////////////////////////////////////////////
            $oldState = $documentNewsManageData->GetState($documentNewsId, false);
            if (($oldState === DocumentNewsData::STATE_PUBLISHED
                    || $oldState === DocumentNewsData::STATE_REFUSE
                )
                && intval($state) === DocumentNewsData::STATE_REFUSE
            ) {
                $publishQueueManageData = new PublishQueueManageData();
                parent::CancelPublishDocumentNews($publishQueueManageData, $documentNewsId, $siteId);
                for ($i = 0; $i < count($publishQueueManageData->Queue); $i++) {
                    $deleteResult = intval($publishQueueManageData->Queue[$i]["Result"]);
                    if (
                        $deleteResult == abs(DefineCode::FTP) + FtpTools::FTP_DELETE_SUCCESS
                        ||
                        $deleteResult == abs(DefineCode::PUBLISH) + self::PUBLISH_DELETE_RESULT_SUCCESS
                    ) {
                        //修改状态
                        $result = $documentNewsManageData->ModifyState($documentNewsId, $state);
                    } else {
                        $result = intval($publishQueueManageData->Queue[$i]["Result"]);
                    }
                }
            } else {
                //修改状态
                $result = $documentNewsManageData->ModifyState($documentNewsId, $state);
            }

            //加入操作日志
            $operateContent = 'Modify State DocumentNews,GET PARAM:' . implode('|', $_GET) . ';\r\nResult:' . $result;
            self::CreateManageUserLog($operateContent);
        }
        return $result;
    }


    /**
     * 复制，移动文档等处理
     * @param string $method 操作类型名称
     * @return string 返回Jsonp修改结果
     */
    private function GenDeal($method)
    {
        $tempContent = Template::Load("document/document_news_list_deal.html", "common");
        parent::ReplaceFirst($tempContent);
        $mod = Control::GetRequest("mod", "");
        $channelId = Control::GetRequest("channel_id", 0);
        $toSiteId = Control::GetRequest("to_site_id", 0); //跨站点，站点id
        $docIdString = $_GET["doc_id_string"]; //GetRequest中的过滤会消去逗号
        $manageUserId = Control::GetManageUserID();
        $manageUserName = Control::GetManageUserName();
        if ($channelId > 0) {
            $channelManageData = new ChannelManageData();
            $documentNewsManageData = new DocumentNewsManageData();
            $arrayOfDocumentNewsList = $documentNewsManageData->GetListByIDString($docIdString);
            $channelType = $channelManageData->GetChannelType($channelId, true);
            if (!empty($_POST)) { //提交
                $targetCid = Control::PostRequest("pop_cid", 0); //目标频道ID
                $targetSiteId = $channelManageData->GetSiteId($targetCid, true);

                if ($targetCid > 0) {
                    /**********************************************************************
                     ******************************判断是否有操作权限**********************
                     **********************************************************************/
                    $manageUserAuthorityManageData = new ManageUserAuthorityManageData();
                    $siteId = $channelManageData->GetSiteId($targetCid, true);
                    $can = $manageUserAuthorityManageData->CanChannelCreate($siteId, $targetCid, $manageUserId);
                    if (!$can) {
                        $result = -10;
                        Control::ShowMessage(Language::Load('document', 26));
                    } else {


                        $targetChannelType = $channelManageData->GetChannelType($targetCid, true);

                        if (strlen($docIdString) > 0) {
                            if ($targetChannelType === 1) {   //新闻资讯类
                                switch ($method) {
                                    case "copy":
                                        $date = date("Y-m-d H:i:s", time());
                                        $date1 = explode(' ', $date);
                                        $date2 = explode(':', $date1[1]);
                                        $hour = $date2[0];
                                        $minute = $date2[1];
                                        $second = $date2[2];
                                        $strResultId = $documentNewsManageData->Copy($targetSiteId, $targetCid, $arrayOfDocumentNewsList, $manageUserId, $manageUserName, $date, $hour, $minute, $second);

                                        if (strlen($strResultId) > 0) {
                                            $result = 1;
                                            /** 处理DocumentNewsPic */
                                            $uploadFileManageData = new UploadFileManageData();
                                            $documentNewsPicManageData = new DocumentNewsPicManageData();
                                            $arrResultId = explode(",", $strResultId);
                                            foreach ($arrResultId as $oneResultId) {
                                                $strUploadFiles = $documentNewsManageData->GetUploadFiles($oneResultId);
                                                $arrayOfUploadFiles = $uploadFileManageData->GetListById(substr($strUploadFiles, 1));
                                                if (count($arrayOfUploadFiles) > 0) {
                                                    foreach ($arrayOfUploadFiles as $oneArticlePic) {
                                                        $documentNewsPicManageData->Create($oneResultId, $oneArticlePic["UploadFileId"], 0);//加入DocumentNewsPic表
                                                    }
                                                }
                                            }
                                        } else {
                                            $result = -1;
                                        }

                                        break;
                                    case "move":
                                        $result = $documentNewsManageData->Move($targetSiteId, $targetCid, $arrayOfDocumentNewsList, $manageUserId, $manageUserName);
                                        break;
                                    default:
                                        $result = -1;
                                        break;
                                }

                                //加入操作日志
                                $operateContent = 'copy Newspaper Article,POST FORM:' . implode('|', $_POST) . ';\r\nResult:result:' . $result;
                                self::CreateManageUserLog($operateContent);


                                if ($result > 0) {
                                    $jsCode = 'parent.location.reload();';//parent.$("#dialog_resultbox").dialog("close");';
                                    Control::RunJavascript($jsCode);
                                } else {
                                    Control::ShowMessage(Language::Load('document', 17));
                                }
                            } else if ($targetChannelType === 4) {   //产品类
                                $productManageData = new ProductManageData();
                                switch ($method) {
                                    case "move":
                                        $arrayOfProductId = explode(",", $docIdString);
                                        $result = $productManageData->Move($targetSiteId, $targetCid, $arrayOfProductId, $manageUserId, $manageUserName);
                                        break;
                                    default:
                                        $result = -1;
                                        break;
                                }
                                //加入操作日志
                                $operateContent = 'Move Product,POST FORM:' . implode('|', $_POST) . ';\r\nResult:result:' . $result;
                                self::CreateManageUserLog($operateContent);


                                if ($result > 0) {
                                    $jsCode = 'parent.location.reload();';//parent.$("#dialog_resultbox").dialog("close");';
                                    Control::RunJavascript($jsCode);
                                } else {
                                    Control::ShowMessage(Language::Load('document', 17));
                                }
                            }
                        }
                    }
                }
            }

            $documentList = "";

            //显示操作文档的标题
            //for ($i = 0; $i < count($arrList); $i++) {
            //    $columns = $arrList[$i];
            foreach ($arrayOfDocumentNewsList as $columnName => $columnValue) {
                $documentList = $documentList . $columnValue["DocumentNewsTitle"] . '<br>';
            }
            //}

            //显示有权限的站点树
            $siteManageData = new SiteManageData();
            $siteList = $siteManageData->GetListForSelect($manageUserId);
            $listName = "site_list";
            Template::ReplaceList($tempContent, $siteList, $listName);


            //显示当前站点的节点树
            if ($toSiteId > 0) {
                $siteId = $toSiteId;
            } else {
                $siteId = $channelManageData->GetSiteID($channelId, true);
            }
            $order = "";
            $arrayChannelTree = $channelManageData->GetListForManageLeft($siteId, $manageUserId, $order);
            $listName = "channel_tree";
            Template::ReplaceList($tempContent, $arrayChannelTree, $listName);

            $methodName = "复制";
            $replaceArr = array(
                "{mod}" => $mod,
                "{method}" => $method,
                "{SiteId}" => $siteId,
                "{ChannelId}" => $channelId,
                "{ChannelName}" => "",
                "{ChannelType}" => $channelType,
                "{Method}" => $methodName,
                "{MethodName}" => $methodName,
                "{DealType}" => $methodName,
                "{DocumentList}" => $documentList,
                "{DocIdString}" => $docIdString,
                "{PicStyleSelector}" => "none"
            );

            $tempContent = strtr($tempContent, $replaceArr);
        }

        parent::ReplaceEnd($tempContent);
        return $tempContent;
    }


}

?>
