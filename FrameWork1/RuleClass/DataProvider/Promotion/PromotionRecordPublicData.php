<?php
/**
 * 前端 邀请码登记记录 数据类
 * @category iCMS
 * @package iCMS_FrameWork1_RuleClass_DataProvider_Promotion
 * @author 525
 */
class PromotionRecordPublicData extends BasePublicData {

    /**
     * @param String $deviceNumber 设备唯一编号
     * @return bool $result 是否已经存在重复记录标志
     */
    public function CheckIsExist($deviceNumber){
        $result = -1;
        if(!empty($deviceNumber)){
            $sql = "SELECT PromoterId FROM ".self::TableName_PromotionRecord." WHERE
             DeviceNumber = :DeviceNumber;";
            $dataProperty = new DataProperty();
            $dataProperty->AddField("DeviceNumber",$deviceNumber);
            $result = $this->dbOperator->GetInt($sql,$dataProperty);
            //if($count>0){
            //    $result=true;
            //}
        }
        return $result;
    }

    /**
     * @param int $promoterId 推广员编号
     * @param string $createDate 邀请码登记时间
     * @param int $deviceType 设备类型
     * @param string $deviceNumber 设备唯一编码
     * @param int $userId 用户Id
     * @param string $ipAddress ip地址
     * @param string $userMobile 输入的手机号码
     * @return int 最后插入的Id
     */
    public function Create(
        $promoterId,
        $createDate,
        $deviceType,
        $deviceNumber,
        $userId,
        $ipAddress,
        $userMobile
    ){
        $result = -1;
        if($promoterId > 0 && !empty($deviceNumber)){
            $sql = "INSERT INTO ".self::TableName_PromotionRecord."   
                (
                PromoterId,
                CreateDate,
                DeviceType,
                DeviceNumber,
                UserId,
                IpAddress,
                UserMobile)
                VALUES (
                :PromoterId,
                :CreateDate,
                :DeviceType,
                :DeviceNumber,
                :UserId,
                :IpAddress,
                :UserMobile
                );";
            $dataProperty = new DataProperty();
            $dataProperty->AddField("PromoterId",$promoterId);
            $dataProperty->AddField("CreateDate",$createDate);
            $dataProperty->AddField("DeviceType",$deviceType);
            $dataProperty->AddField("DeviceNumber",$deviceNumber);
            $dataProperty->AddField("UserId",$userId);
            $dataProperty->AddField("IpAddress",$ipAddress);
            $dataProperty->AddField("UserMobile",$userMobile);
            $result = $this->dbOperator->LastInsertId($sql,$dataProperty);
        }
        return $result;

    }

    /**
     * 得到一行信息
     * @param int $promotionRecordId 推广码登记记录id
     * @param bool $withCache 是否缓存
     * @return array 单表数组
     */
    public function GetOne($promotionRecordId, $withCache = false)
    {
        $result = null;
        if ($promotionRecordId > 0) {
            $sql = "
            SELECT *
            FROM " . self::TableName_PromotionRecord . "
            WHERE PromotionRecordId = :PromotionRecordId;";

            $dataProperty = new DataProperty();
            $dataProperty->AddField("PromotionRecordId", $promotionRecordId);
            $result = $this->dbOperator->GetArray($sql, $dataProperty);
        }
        return $result;
    }

    public function GetCount($promoterId){
        $result = 0;
        if($promoterId > 0){
            $sql = "SELECT COUNT(*) FROM ".self::TableName_PromotionRecord." WHERE PromoterId = :PromoterId;";
            $dataProperty = new DataProperty();
            $dataProperty->AddField("PromoterId",$promoterId);
            $result = $this->dbOperator->GetInt($sql,$dataProperty);
        }
        return $result;
    }
} 