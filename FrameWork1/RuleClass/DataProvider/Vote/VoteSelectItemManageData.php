<?php

/**
 * 投票调查 题目选项 数据类
 * @category iCMS
 * @package iCMS_Rules_DataProvider_Vote
 * @author hy
 */
class VoteSelectItemManageData extends BaseManageData
{
    /**
     * 取得字段数据集
     * @param string $tableName 表名
     * @return array 字段数据集
     */
    public function GetFields($tableName = self::TableName_VoteSelectItem){
        return parent::GetFields(self::TableName_VoteSelectItem);
    }

    /**
     * 新建选项
     * @param array $httpPostData $_post数组
     * @return int  返回选项Id
     */
    public function Create($httpPostData) {
        $dataProperty = new DataProperty();
        $sql = parent::GetInsertSql($httpPostData, self::TableName_VoteSelectItem, $dataProperty);
        $result = $this->dbOperator->LastInsertId($sql, $dataProperty);
        return $result;
    }

    /**
     * 批量新建投票选项
     * @param array $ItemDetailArray 选项记录数组
     * @return int 返回执行结果
     */
    public function CreateVoteItemBatch($ItemDetailArray)
    {
        $sql = array();
        $dataPropertyList = array();
        foreach ($ItemDetailArray as $value) {

            $dataProperty = new DataProperty();
            $dataProperty->ArrayField = $value;
            $dataPropertyList[] = $dataProperty;

            $sql[] = "INSERT INTO " . self::TableName_VoteSelectItem . " (Type, VoteSelectItemTitle, Author, Editor, PublishDate, PageNo, Email,VoteItemId)
                       VALUES (:Type, :VoteSelectItemTitle, :Author, :Editor, :PublishDate, :PageNo, :Email,:VoteItemId)";


        }
        $result = $this->dbOperator->ExecuteBatch($sql, $dataPropertyList);
        return $result;
    }

    /**
     * @param $voteItemId int 投票选项id
     * @return int 执行结果
     */
    public function RemoveDataBeforeImportFromTxt($voteItemId){

        $removeData  = new DataProperty();
        $removeData->AddField("VoteItemId",$voteItemId);

        $sql = "DELETE FROM " . self::TableName_VoteSelectItem .
               " WHERE VoteItemId = :VoteItemId";
        $result = $this->dbOperator->Execute($sql, $removeData);
        return $result;
    }


    /**
     * 获取一个选项的数据
     * @param int $voteSelectItemId  选项Id
     * @return array  选项一维数组
     */
    public function GetOne($voteSelectItemId) {
        $sql = "SELECT VoteSelectItemId,VoteItemId,Sort,State,VoteSelectItemTitle,RecordCount,AddCount,TitlePic1UploadFileId,DirectUrl,Type,Author,Editor,PublishDate,PageNo
        FROM " . self::TableName_VoteSelectItem . "
        WHERE voteSelectItemId=:voteSelectItemId";
        $dataProperty = new DataProperty();
        $dataProperty->AddField("voteSelectItemId", $voteSelectItemId);
        $result = $this->dbOperator->GetArray($sql, $dataProperty);
        return $result;
    }

    /**
     * 修改选项
     * @param array $httpPostData $_post数组
     * @param int $voteSelectItemId
     * @return int  返回执行结果
     */
    public function Modify($httpPostData,$voteSelectItemId) {
        $dataProperty = new DataProperty();
        $sql = parent::GetUpdateSql($httpPostData, self::TableName_VoteSelectItem, self::TableId_VoteSelectItem, $voteSelectItemId, $dataProperty);
        $result = $this->dbOperator->Execute($sql, $dataProperty);
        return $result;
    }

    /**
     * 异步修改状态
     * @param string $voteSelectItemId 选项Id
     * @param string $state 状态
     * @return int 执行结果
     */
    public function ModifyState($voteSelectItemId,$state) {
        $result = -1;
        if ($voteSelectItemId < 0) {
            return $result;
        }
        $sql = "UPDATE " . self::TableName_VoteSelectItem . " SET State=:State WHERE VoteSelectItemId=:VoteSelectItemId";
        $dataProperty = new DataProperty();
        $dataProperty->AddField("VoteSelectItemId", $voteSelectItemId);
        $dataProperty->AddField("State", $state);
        $result = $this->dbOperator->Execute($sql, $dataProperty);
        return $result;
    }

    /**
     * 获取一道题的所有选项列表（按比例加票）
     * @param int $voteItemId  题目ID
     * @param int $state   题目选项状态值
     * @return array  返回数据集结果
     */
    public function GetListForAddCount($voteItemId, $state) {
        $sql = "SELECT VoteSelectItemId,VoteSelectItemTitle,RecordCount,AddCount
        FROM " . self::TableName_VoteSelectItem . "
        WHERE State=:State AND VoteItemId=:VoteItemId
        ORDER BY Sort DESC,VoteSelectItemId ASC";
        $dataProperty = new DataProperty();
        $dataProperty->AddField("State", $state);
        $dataProperty->AddField("VoteItemId", $voteItemId);
        $result = $this->dbOperator->GetArrayList($sql, $dataProperty);
        return $result;
    }

    /**
     * 获取一道题目下选项总票数
     * @param int $VoteItemId  选项Id
     * @return int  返回选项总票数
     */
    public function GetSum($VoteItemId) {
        $sql = "SELECT SUM(AddCount) FROM " . self::TableName_VoteSelectItem . " WHERE State=0 AND VoteItemId=:VoteItemId";
        $dataProperty = new DataProperty();
        $dataProperty->AddField("VoteItemId", $VoteItemId);
        $result = $this->dbOperator->GetInt($sql, $dataProperty);
        return $result;
    }

    /**
     * 根据题目ID获取题目下所有选项数据
     * @param int $voteItemId   题目ID,，可以是 id,id,id 的形式
     * @param int $state    题目选项状态
     * @param string $order    排序
     * @param int $topCount    题目选项条数
     * @return array  返回查询题目选项数组
     */
    public function GetList($voteItemId,$state,$order = "",$topCount = null) {
        $result = null;
        if ($topCount != null)
            $topCount = " limit " . $topCount;
        switch ($order) {
            default:
                $order = " ORDER BY Sort DESC,VoteSelectItemId ASC ";
                break;
        }
        if($voteItemId>0)
        {
            $voteItemId = Format::FormatSql($voteItemId);
            $sql = "SELECT t2.VoteItemId,t2.VoteSelectItemId,t2.VoteSelectItemTitle,t2.Sort,t2.State,t2.AddCount,t2.RecordCount,t2.DirectUrl,t2.Type,t2.Author,t2.Editor,t2.PublishDate,t2.PageNo,
                    CASE t1.VoteItemType WHEN '0' THEN 'radio' ELSE 'checkbox' END AS VoteItemTypeName,
                    t3.*
                    FROM " . self::TableName_VoteItem . " t1
                    LEFT OUTER JOIN " . self::TableName_VoteSelectItem . " t2 ON t1.VoteItemId=t2.VoteItemId
                    LEFT OUTER JOIN " .self::TableName_UploadFile." t3 on t2.TitlePic1UploadFileId=t3.UploadFileId
                    WHERE t2.State=:State
                    AND t2.VoteItemId IN ($voteItemId)"
                    . $order
                    . $topCount;
            $dataProperty = new DataProperty();
            $dataProperty->AddField("State", $state);
            $result = $this->dbOperator->GetArrayList($sql, $dataProperty);
        }
        return $result;
    }

    /**
     * 根据题目ID获取题目下所有选项数据与关联资讯文档的相关内容
     * @param int $voteItemId   题目ID,，可以是 id,id,id 的形式
     * @param int $state    题目选项状态
     * @param string $order    排序
     * @param int $topCount    题目选项条数
     * @return array  返回查询题目选项数组
     */
    public function GetListWithDocumentNews($voteItemId,$state,$order = "",$topCount = null) {
        $result = null;
        if ($topCount != null)
            $topCount = " limit " . $topCount;
        switch ($order) {
            default:
                $order = " ORDER BY Sort ASC,VoteSelectItemId ASC ";
                break;
        }
        if($voteItemId>0)
        {
            $voteItemId = Format::FormatSql($voteItemId);
            $sql = "SELECT
            t2.VoteItemId,
            t2.VoteSelectItemId,
            t2.VoteSelectItemTitle,
            t2.Sort,
            t2.State,
            t2.AddCount,
            t2.RecordCount,
            t2.DirectUrl,t2.Type,t2.Author,t2.Editor,t2.PublishDate,t2.PageNo,
            CASE t1.VoteItemType WHEN '0' THEN 'radio' ELSE 'checkbox' END AS VoteItemTypeName,
            doc.DocumentNewsSubTitle,
            doc.DocumentNewsCiteTitle,
            doc.DocumentNewsShortTitle,
            doc.DocumentNewsIntro,


            uf1.UploadFilePath AS TitlePic1UploadFilePath,
            uf1.UploadFileMobilePath AS TitlePic1UploadFileMobilePath,
            uf1.UploadFilePadPath AS TitlePic1UploadFilePadPath,
            uf1.UploadFileThumbPath1 AS TitlePic1UploadFileThumbPath1,
            uf1.UploadFileThumbPath2 AS TitlePic1UploadFileThumbPath2,
            uf1.UploadFileThumbPath3 AS TitlePic1UploadFileThumbPath3,
            uf1.UploadFileWatermarkPath1 AS TitlePic1UploadFileWatermarkPath1,
            uf1.UploadFileWatermarkPath2 AS TitlePic1UploadFileWatermarkPath2,
            uf1.UploadFileCompressPath1 AS TitlePic1UploadFileCompressPath1,
            uf1.UploadFileCompressPath2 AS TitlePic1UploadFileCompressPath2,
            uf1.UploadFileCutPath1 AS TitlePic1UploadFileCutPath1,


            uf2.UploadFilePath AS TitlePic2UploadFilePath,
            uf2.UploadFileMobilePath AS TitlePic2UploadFileMobilePath,
            uf2.UploadFilePadPath AS TitlePic2UploadFilePadPath,
            uf2.UploadFileThumbPath1 AS TitlePic2UploadFileThumbPath1,
            uf2.UploadFileThumbPath2 AS TitlePic2UploadFileThumbPath2,
            uf2.UploadFileThumbPath3 AS TitlePic2UploadFileThumbPath3,
            uf2.UploadFileWatermarkPath1 AS TitlePic2UploadFileWatermarkPath1,
            uf2.UploadFileWatermarkPath2 AS TitlePic2UploadFileWatermarkPath2,
            uf2.UploadFileCompressPath1 AS TitlePic2UploadFileCompressPath1,
            uf2.UploadFileCompressPath2 AS TitlePic2UploadFileCompressPath2,
            uf2.UploadFileCutPath1 AS TitlePic2UploadFileCutPath1,


            uf3.UploadFilePath AS TitlePic3UploadFilePath,
            uf3.UploadFileMobilePath AS TitlePic3UploadFileMobilePath,
            uf3.UploadFilePadPath AS TitlePic3UploadFilePadPath,
            uf3.UploadFileThumbPath1 AS TitlePic3UploadFileThumbPath1,
            uf3.UploadFileThumbPath2 AS TitlePic3UploadFileThumbPath2,
            uf3.UploadFileThumbPath3 AS TitlePic3UploadFileThumbPath3,
            uf3.UploadFileWatermarkPath1 AS TitlePic3UploadFileWatermarkPath1,
            uf3.UploadFileWatermarkPath2 AS TitlePic3UploadFileWatermarkPath2,
            uf3.UploadFileCompressPath1 AS TitlePic3UploadFileCompressPath1,
            uf3.UploadFileCompressPath2 AS TitlePic3UploadFileCompressPath2,
            uf3.UploadFileCutPath1 AS TitlePic3UploadFileCutPath1

                    FROM " . self::TableName_VoteItem . " t1
                    LEFT OUTER JOIN " . self::TableName_VoteSelectItem . " t2 ON t1.VoteItemId=t2.VoteItemId
                    LEFT OUTER JOIN " .self::TableName_DocumentNews." doc on t2.TableId=doc.DocumentNewsId
                    LEFT OUTER JOIN " .self::TableName_UploadFile." uf1 on doc.TitlePic1UploadFileId=uf1.UploadFileId
                    LEFT OUTER JOIN " .self::TableName_UploadFile." uf2 on doc.TitlePic2UploadFileId=uf2.UploadFileId
                    LEFT OUTER JOIN " .self::TableName_UploadFile." uf3 on doc.TitlePic3UploadFileId=uf3.UploadFileId
                    WHERE t2.State=:State
                    AND t2.VoteItemId IN ($voteItemId)"
                . $order
                . $topCount;
            $dataProperty = new DataProperty();
            $dataProperty->AddField("State", $state);
            $result = $this->dbOperator->GetArrayList($sql, $dataProperty);

        }
        return $result;
    }


    /**
     * 获取选项分页列表
     * @param int $pageBegin   起始页码
     * @param int $pageSize    每页记录数
     * @param int $allCount    记录总数
     * @param int $voteItemId  题目Id
     * @param string $searchKey   查询字符
     * @return array  选项列表数组
     */
    public function GetListForPager($voteItemId, $pageBegin, $pageSize, &$allCount, $searchKey = "") {
        $result = null;
        if ($voteItemId < 0) {
            return $result;
        }
        $dataProperty = new DataProperty();
        $dataProperty->AddField("VoteItemId", $voteItemId);
        $searchSql = "";
        if (strlen($searchKey) > 0 && $searchKey != "undefined") {
            $searchSql .= " AND (VoteTitle LIKE :searchKey1)";
            $dataProperty->AddField("searchKey1", "%" . $searchKey . "%");
        }
        $sql = "
        SELECT VoteItemId,VoteSelectItemId,VoteSelectItemTitle,Sort,State,AddCount,RecordCount
        FROM " . self::TableName_VoteSelectItem . "
        WHERE VoteItemId=:VoteItemId" . $searchSql . "
        ORDER BY Sort DESC,VoteSelectItemId ASC
        LIMIT " . $pageBegin . "," . $pageSize . "";
        $result = $this->dbOperator->GetArrayList($sql, $dataProperty);
        $sql = "
        SELECT COUNT(*) FROM " . self::TableName_VoteSelectItem . "
        WHERE  VoteItemId=:VoteItemId" . $searchSql;
        $allCount = $this->dbOperator->GetInt($sql, $dataProperty);
        return $result;
    }

    /**
     * 修改选项的加票数
     * @param int $voteSelectItemId  选项Id
     * @param int $addCount  选项加票数
     * @return int  执行结果
     */
    public function ModifyAddCount($voteSelectItemId,$addCount) {
        $sql = "UPDATE  " . self::TableName_VoteSelectItem . " SET AddCount=:AddCount WHERE State=0 AND VoteSelectItemId=:VoteSelectItemId";
        $dataProperty = new DataProperty();
        $dataProperty->AddField("VoteSelectItemId", $voteSelectItemId);
        $dataProperty->AddField("AddCount", $addCount);
        $result = $this->dbOperator->GetInt($sql, $dataProperty);
        return $result;
    }

    /**
     * 取得题图的上传文件id
     * @param int $voteSelectItemId 题目选项id
     * @param bool $withCache 是否从缓冲中取
     * @return int 题图1的上传文件id
     */
    public function GetTitlePic1UploadFileId($voteSelectItemId, $withCache)
    {
        $result = -1;
        if ($voteSelectItemId > 0) {
            $cacheDir = CACHE_PATH . DIRECTORY_SEPARATOR . 'document_news_data';
            $cacheFile = 'vote_select_item_get_title_pic_1_upload_file_id.cache_' . $voteSelectItemId . '';
            $sql = "SELECT TitlePic1UploadFileId FROM " . self::TableName_VoteSelectItem . " WHERE VoteSelectItemId = :VoteSelectItemId;";
            $dataProperty = new DataProperty();
            $dataProperty->AddField("VoteSelectItemId", $voteSelectItemId);
            $result = $this->GetInfoOfIntValue($sql, $dataProperty, $withCache, $cacheDir, $cacheFile);
        }
        return $result;
    }

    /**
     * 修改题图1的上传文件id
     * @param int $voteSelectItemId 题目选项id
     * @param int $titlePic1UploadFileId 题图1上传文件id
     * @return int 操作结果
     */
    public function ModifyTitlePic1UploadFileId($voteSelectItemId, $titlePic1UploadFileId)
    {
        $result = -1;
        if($voteSelectItemId>0){
            $dataProperty = new DataProperty();
            $sql = "UPDATE " . self::TableName_VoteSelectItem . " SET
                    TitlePic1UploadFileId = :TitlePic1UploadFileId
                    WHERE VoteSelectItemId = :VoteSelectItemId
                    ;";
            $dataProperty->AddField("TitlePic1UploadFileId", $titlePic1UploadFileId);
            $dataProperty->AddField("VoteSelectItemId", $voteSelectItemId);
            $result = $this->dbOperator->Execute($sql, $dataProperty);
        }

        return $result;
    }



}

?>
