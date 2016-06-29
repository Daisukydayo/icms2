<?php
/**
 * 前台 论坛帖子 数据类
 * @category iCMS
 * @package  iCMS_FrameWork1_RuleClass_DataProvider_Forum
 * @author   xiao
 */
class ForumPostPublicData extends BasePublicData
{

    public function Create(
        $siteId,
        $forumId,
        $forumTopicId,
        $isTopic,
        $userId,
        $userName,
        $forumPostTitle,
        $forumPostContent,
        $postTime,
        $forumTopicAudit,
        $forumTopicAccess,
        $accessLimitNumber,
        $accessLimitContent,
        $showSign,
        $postIp,
        $isOneSale,
        $addMoney,
        $addScore,
        $addCharm,
        $addExp,
        $showBoughtUser,
        $sort,
        $state,
        $uploadFiles
    )
    {
        $result = -1;
        if ($siteId > 0 && $forumId > 0 && $userId > 0) {
            $sql = "INSERT INTO " . self::TableName_ForumPost . "
                    (
                    SiteId,
                    ForumId,
                    ForumTopicId,
                    IsTopic,
                    UserId,
                    UserName,
                    ForumPostTitle,
                    ForumPostContent,
                    PostTime,
                    ForumTopicAudit,
                    ForumTopicAccess,
                    AccessLimitNumber,
                    AccessLimitContent,
                    ShowSign,
                    PostIp,
                    IsOneSale,
                    AddMoney,
                    AddScore,
                    AddCharm,
                    AddExp,
                    ShowBoughtUser,
                    Sort,
                    State,
                    UploadFiles
                    )
                    VALUES
                    (
                    :SiteId,
                    :ForumId,
                    :ForumTopicId,
                    :IsTopic,
                    :UserId,
                    :UserName,
                    :ForumPostTitle,
                    :ForumPostContent,
                    :PostTime,
                    :ForumTopicAudit,
                    :ForumTopicAccess,
                    :AccessLimitNumber,
                    :AccessLimitContent,
                    :ShowSign,
                    :PostIp,
                    :IsOneSale,
                    :AddMoney,
                    :AddScore,
                    :AddCharm,
                    :AddExp,
                    :ShowBoughtUser,
                    :Sort,
                    :State,
                    :UploadFiles
                    );";
            $dataProperty = new DataProperty();
            $dataProperty->AddField("SiteId", $siteId);
            $dataProperty->AddField("ForumId", $forumId);
            $dataProperty->AddField("ForumTopicId", $forumTopicId);
            $dataProperty->AddField("IsTopic", $isTopic);
            $dataProperty->AddField("UserId", $userId);
            $dataProperty->AddField("UserName", $userName);
            $dataProperty->AddField("ForumPostTitle", $forumPostTitle);
            $dataProperty->AddField("ForumPostContent", $forumPostContent);
            $dataProperty->AddField("PostTime", $postTime);
            $dataProperty->AddField("ForumTopicAudit", $forumTopicAudit);
            $dataProperty->AddField("ForumTopicAccess", $forumTopicAccess);
            $dataProperty->AddField("AccessLimitNumber", $accessLimitNumber);
            $dataProperty->AddField("AccessLimitContent", $accessLimitContent);
            $dataProperty->AddField("ShowSign", $showSign);
            $dataProperty->AddField("PostIp", $postIp);
            $dataProperty->AddField("IsOneSale", $isOneSale);
            $dataProperty->AddField("AddMoney", $addMoney);
            $dataProperty->AddField("AddScore", $addScore);
            $dataProperty->AddField("AddCharm", $addCharm);
            $dataProperty->AddField("AddExp", $addExp);
            $dataProperty->AddField("ShowBoughtUser", $showBoughtUser);
            $dataProperty->AddField("Sort", $sort);
            $dataProperty->AddField("State", $state);
            $dataProperty->AddField("UploadFiles", $uploadFiles);
            $result = $this->dbOperator->LastInsertId($sql, $dataProperty);


        }

        return $result;

    }

    public function Modify(
        $siteId,
        $forumTopicId,
        $isTopic,
        $forumPostTitle,
        $forumPostContent,
        $postTime,
        $forumTopicAudit,
        $forumTopicAccess,
        $accessLimitNumber,
        $accessLimitContent,
        $showSign,
        $postIp,
        $isOneSale,
        $addMoney,
        $addScore,
        $addCharm,
        $addExp,
        $showBoughtUser,
        $sort,
        $state,
        $uploadFiles
    )
    {
        $result = -1;
        if (
            strlen($forumPostTitle) > 0
        ) {

            $dataProperty = new DataProperty();
            $dataProperty->AddField("SiteId", $siteId);
            $dataProperty->AddField("IsTopic", $isTopic);
            $dataProperty->AddField("ForumPostTitle", $forumPostTitle);
            $dataProperty->AddField("ForumPostContent", $forumPostContent);
            $dataProperty->AddField("PostTime", $postTime);
            $dataProperty->AddField("ForumTopicAudit", $forumTopicAudit);
            $dataProperty->AddField("ForumTopicAccess", $forumTopicAccess);
            $dataProperty->AddField("AccessLimitNumber", $accessLimitNumber);
            $dataProperty->AddField("AccessLimitContent", $accessLimitContent);
            $dataProperty->AddField("ShowSign", $showSign);
            $dataProperty->AddField("PostIp", $postIp);
            $dataProperty->AddField("IsOneSale", $isOneSale);
            $dataProperty->AddField("AddMoney", $addMoney);
            $dataProperty->AddField("AddScore", $addScore);
            $dataProperty->AddField("AddCharm", $addCharm);
            $dataProperty->AddField("AddExp", $addExp);
            $dataProperty->AddField("ShowBoughtUser", $showBoughtUser);
            $dataProperty->AddField("Sort", $sort);
            $dataProperty->AddField("State", $state);
            $dataProperty->AddField("UploadFiles", $uploadFiles);
            $fieldNames = "SiteId=:SiteId,IsTopic=:IsTopic,ForumPostTitle=:ForumPostTitle,ForumPostContent=:ForumPostContent,PostTime=:PostTime,ForumTopicAudit=:ForumTopicAudit,ForumTopicAccess=:ForumTopicAccess,AccessLimitNumber=:AccessLimitNumber,AccessLimitContent=:AccessLimitContent,ShowSign=:ShowSign,PostIp=:PostIp,IsOneSale=:IsOneSale,AddMoney=:AddMoney,AddScore=:AddScore,AddCharm=:AddCharm,AddExp=:AddExp,ShowBoughtUser=:ShowBoughtUser,Sort=:Sort,State=:State,UploadFiles=:UploadFiles";
            $sql = 'UPDATE ' . self::TableName_ForumPost .
                ' SET ' . $fieldNames .
                ' WHERE forumTopicId =' . $forumTopicId . ' AND IsTopic=:IsTopic;';
            $result = $this->dbOperator->Execute($sql, $dataProperty);
        }

        return $result;
    }

    public function ModifyContent($forumPostId, $forumPostTitle, $forumPostContent)
    {
        $result = -1;
        if (
            strlen($forumPostContent) > 0
        ) {

            $sql = 'UPDATE ' . self::TableName_ForumPost .
                ' SET ForumPostContent=:ForumPostContent, ForumPostTitle=:ForumPostTitle ' .
                ' WHERE ForumPostId=:ForumPostId ;';
            $dataProperty = new DataProperty();
            $dataProperty->AddField("ForumPostId", $forumPostId);
            $dataProperty->AddField("ForumPostContent", $forumPostContent);
            $dataProperty->AddField("ForumPostTitle", $forumPostTitle);
            $result = $this->dbOperator->Execute($sql, $dataProperty);
        }
        return $result;
    }

    /**
     * 取得一条信息
     * @param int $forumPostId 帖子id
     * @return array 帖子信息数组
     */
    public function GetOne($forumPostId)
    {
        $sql = "SELECT * FROM " . self::TableName_ForumPost . " WHERE " . self::TableId_ForumPost . "=:" . self::TableId_ForumPost . ";";
        $dataProperty = new DataProperty();
        $dataProperty->AddField(self::TableId_ForumPost, $forumPostId);
        $result = $this->dbOperator->GetArray($sql, $dataProperty);
        return $result;
    }

    /**
     * 取得一条信息
     * @param int $forumTopicId 主题id
     * @param int $isTopic      是否主题
     * @return array 帖子信息数组
     */
    public function GetOneForTopicId($forumTopicId, $isTopic)
    {
        $sql = "SELECT * FROM " . self::TableName_ForumPost . " WHERE " . self::TableId_ForumTopic . "=:" . self::TableId_ForumTopic . " AND isTopic=$isTopic;";
        $dataProperty = new DataProperty();
        $dataProperty->AddField(self::TableId_ForumTopic, $forumTopicId);
        $result = $this->dbOperator->GetArray($sql, $dataProperty);
        return $result;
    }

    /**
     * 取得列表信息
     * @param int $forumTopicId 帖子id
     * @param int $pageBegin
     * @param int $pageSize
     * @param int $allCount
     * @return array 帖子信息数组
     */

    public function GetListPager($forumTopicId, $pageBegin, $pageSize, &$allCount)
    {
        $sql = "SELECT fp.*,
                        ui.AvatarUploadFileId,
                        ui.NickName,
                        uf.UploadFilePath AS AvatarUploadFilePath,
                        uf.UploadFileMobilePath AS AvatarUploadFileMobilePath,
                        uf.UploadFilePadPath AS AvatarUploadFilePadPath,
                        usl.UserLevel,
                        usl.UserLevelName,
                        usl.UserLevelPic
                FROM " . self::TableName_ForumPost . " fp, " . self::TableName_UserInfo . " ui

                LEFT OUTER JOIN " . self::TableName_UploadFile . " uf ON (ui.AvatarUploadFileId=uf.UploadFileId)
                LEFT OUTER JOIN " . self::ViewName_UserLevel . " usl ON (ui.UserId = usl.UserId)

                WHERE fp." . self::TableId_ForumTopic . "=:" . self::TableId_ForumTopic . "
                AND ui.UserId=fp.UserId
                AND fp.state=0

                ORDER BY fp.IsTopic DESC, fp.PostTime

                LIMIT " . $pageBegin . "," . $pageSize . ";";
        $dataProperty = new DataProperty();
        $dataProperty->AddField(self::TableId_ForumTopic, $forumTopicId);
        $result = $this->dbOperator->GetArrayList($sql, $dataProperty);

        //统计总数
        $sql = "SELECT count(*)" .
            " FROM " . self::TableName_ForumPost . " fp" .
            " WHERE ForumTopicId=:ForumTopicId AND fp.state=0;";


        $allCount = $this->dbOperator->GetInt($sql, $dataProperty);

        return $result;
    }

    /**
     * 取得会员id
     * @param int $forumPostId 帖子id
     * @param bool $withCache  是否从缓冲中取
     * @return int 论坛id
     */
    public function GetUserId($forumPostId, $withCache)
    {
        $result = -1;
        if ($forumPostId > 0) {
            $cacheDir = CACHE_PATH . DIRECTORY_SEPARATOR . 'forum_post_data';
            $cacheFile = 'forum_post_get_user_id.cache_' . $forumPostId . '';
            $sql = "SELECT UserId FROM " . self::TableName_ForumPost . " WHERE ForumPostId =:ForumPostId;";
            $dataProperty = new DataProperty();
            $dataProperty->AddField(self::TableId_ForumPost, $forumPostId);
            $result = $this->GetInfoOfIntValue($sql, $dataProperty, $withCache, $cacheDir, $cacheFile);
        }
        return $result;
    }

    /**
     * 修改帖子状态
     * @param int $forumPostId 帖子id
     * @param int $state       状态
     * @return int 操作结果
     */
    public function ModifyState($forumPostId, $state)
    {
        $result = -1;
        if ($forumPostId > 0) {
            $dataProperty = new DataProperty();
            $sql = "UPDATE " . self::TableName_ForumPost . " SET State=:State WHERE ForumPostId=:ForumPostId;";
            $dataProperty->AddField("State", $state);
            $dataProperty->AddField("ForumPostId", $forumPostId);
            $result = $this->dbOperator->Execute($sql, $dataProperty);
        }

        return $result;
    }

    /**
     * @param $forumTopicId     int    帖子id
     * @param $state            int    状态
     * @return int              in     回复数
     */
    public function GetReplayCount($forumTopicId, $state)
    {
        $result = -1;
        if ($forumTopicId > 0) {
            $dataProperty = new DataProperty();
            $dataProperty->AddField('ForumTopicId', $forumTopicId);
            $dataProperty->AddField('State', $state);
            $sql = 'SELECT COUNT(ForumPostId) FROM ' . self::TableName_ForumPost .
                ' WHERE ForumTopicId=:ForumTopicId ' .
                ' AND State=:State ;';
            $result = $this->dbOperator->GetInt($sql, $dataProperty);
        }
        return $result;
    }

    /**
     * @param $forumTopicId     int    帖子id
     * @param $state            int    状态
     * @return int              in     回复数
     */
    public function GetHitCount($forumTopicId, $state)
    {
        $result = -1;
        if ($forumTopicId > 0) {
            $dataProperty = new DataProperty();
            $dataProperty->AddField('ForumTopicId', $forumTopicId);
            $dataProperty->AddField('State', $state);
            $sql = 'SELECT HitCount FROM ' . self::TableName_ForumTopic .
                ' WHERE ForumTopicId=:ForumTopicId ' .
                ' AND State=:State ;';
            $result = $this->dbOperator->GetInt($sql, $dataProperty);
        }
        return $result;
    }

    /**
     * @param $forumTopicId     int    帖子id
     * @param $replayCount      int    回复数
     * @param $hitCount         int    点击数
     * @param $result           int    执行结果
     */
    public function AddHitCount($forumTopicId, $replayCount, $hitCount)
    {
        $result = -1;

        $dataProperty = new DataProperty();
        $dataProperty->AddField('ForumTopicId', $forumTopicId);
        $sql = '';
        if ($forumTopicId > 0) {

            if ($hitCount < $replayCount) { //点击数不能少于回复数
                $hitCount = $replayCount + 2;

                $dataProperty->AddField('HitCount', $hitCount);

                $sql = 'UPDATE ' .self::TableName_ForumTopic.
                    ' SET HitCount=:HitCount' .
                    ' WHERE ForumTopicId=:ForumTopicId ;';
            }
            else{   //不少于时+1
                $sql = 'UPDATE ' .self::TableName_ForumTopic.
                        ' SET HitCount=HitCount + 1 '.
                        ' WHERE ForumTopicId=:ForumTopicId ;';
            }

            $result = $this->dbOperator->Execute($sql, $dataProperty);
        }

        return $result;
    }
} 