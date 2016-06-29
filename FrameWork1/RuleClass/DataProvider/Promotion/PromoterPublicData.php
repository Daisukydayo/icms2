<?php

/**
 * 前端 邀请码推荐人 数据类
 * @category iCMS
 * @package iCMS_FrameWork1_RuleClass_DataProvider_Promotion
 * @author 525
 */
class PromoterPublicData extends BasePublicData
{
    public function GetPromoterName($promoterId,$withCache){
        $result = "";
        if($promoterId > 0){
            $cacheDir = CACHE_PATH . DIRECTORY_SEPARATOR . 'promoter_data';
            $cacheFile = 'promoter_promoter_name.cache_' . $promoterId . '';
            $sql = "SELECT PromoterName FROM ".self::TableName_Promoter." WHERE PromoterId = :PromoterId;";
            $dataProperty = new DataProperty();
            $dataProperty->AddField("PromoterId",$promoterId);
            $result = $this->GetInfoOfStringValue($sql,$dataProperty,$withCache,$cacheDir,$cacheFile);
        }
        return $result;
    }


}