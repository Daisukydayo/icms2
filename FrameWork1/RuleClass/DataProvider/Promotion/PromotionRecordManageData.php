<?php

/**
 * 后端 邀请码 统计类
 * @category iCMS
 * @package  iCMS_FrameWork1_RuleClass_Gen_Promotion
 * User: momo
 * Date: 16/3/25
 */
class PromotionRecordManageData extends BaseManageData
{

    public function GetList($pageBegin, $pageSize, &$allCount, $searchKey = null, $searchType = 0)
    {

        $searchSql = '';
        $dateProperty = new DataProperty();

        if ($searchKey != null) {

            if ($searchType == 0) {
                if (is_numeric($searchKey)) {
                    $searchSql = ' WHERE pr.PromoterId=' . $searchKey . ' ';
                }
                else if (is_string($searchKey)) {
                    $searchSql = " WHERE p.PromoterName LIKE '%" . $searchKey . "%' ";
                }

                $sql = 'SELECT COUNT(pr.PromotionRecordId) as Sum, pr.*, p.PromoterName, p.PromoterMobile, p.PromoterCompany ' .
                    ' FROM ' . self::TableName_PromotionRecord . ' pr ' .
                    ' LEFT JOIN ' . self::TableName_Promoter . ' p ON pr.PromoterId=p.PromoterId ' . $searchSql .
                    ' GROUP BY pr.PromoterId ' .
                    ' ORDER BY Sum DESC ' .
                    ' LIMIT ' . $pageBegin . ' , ' . $pageSize . ';';

                $result = $this->dbOperator->GetArrayList($sql, $dateProperty);

                $sql = 'SELECT COUNT(PromoterId) FROM (' .
                    'SELECT COUNT(pr.PromotionRecordId) as Sum, pr.*, p.PromoterName, p.PromoterMobile, p.PromoterCompany ' .
                    ' FROM ' . self::TableName_PromotionRecord . ' pr ' .
                    ' LEFT JOIN ' . self::TableName_Promoter . ' p ON pr.PromoterId=p.PromoterId ' . $searchSql .
                    ' GROUP BY pr.PromoterId ' .
                    ')subQuery;';
                $allCount = $this->dbOperator->GetInt($sql);

            }
            else if ($searchType == 1) {
                $sql = 'SELECT COUNT(PromoterId) as Sum'.
                        ' FROM ' .self::TableName_PromotionRecord.
                        ' WHERE PromoterId LIKE "' . $searchKey . '%" '.
                        ' AND length(PromoterId)=8 ;';
                $sum = $this->dbOperator->GetInt($sql);
                $result = array();
                $result[] = array('Sum'=>$sum, 'PromoterId'=>'以'.$searchKey.'开头', 'PromoterName'=>'', 'PromoterMobile'=>'', 'PromoterCompany'=>'');
                $allCount = 1;
            }

        }
        else {
            $sql = 'SELECT COUNT(pr.PromotionRecordId) as Sum, pr.*, p.PromoterName, p.PromoterMobile, p.PromoterCompany ' .
                ' FROM ' . self::TableName_PromotionRecord . ' pr ' .
                ' LEFT JOIN ' . self::TableName_Promoter . ' p ON pr.PromoterId=p.PromoterId ' .
                ' GROUP BY pr.PromoterId ' .
                ' ORDER BY Sum DESC ' .
                ' LIMIT ' . $pageBegin . ' , ' . $pageSize . ';';

            $result = $this->dbOperator->GetArrayList($sql, $dateProperty);
          

            $sql = 'SELECT COUNT(PromoterId) FROM (' .
                'SELECT COUNT(pr.PromotionRecordId) as Sum, pr.*, p.PromoterName, p.PromoterMobile, p.PromoterCompany ' .
                ' FROM ' . self::TableName_PromotionRecord . ' pr ' .
                ' LEFT JOIN ' . self::TableName_Promoter . ' p ON pr.PromoterId=p.PromoterId ' .
                ' GROUP BY pr.PromoterId ' .
                ')subQuery;';
            $allCount = $this->dbOperator->GetInt($sql);
        }


        return $result;
    }

    public function GetListByPromotionId($promoterId, $pageBegin, $pageSize, &$allCount)
    {
        $dataProperty = new DataProperty();
        $dataProperty->AddField("PromoterId", $promoterId);

        $sql = 'SELECT * FROM ' . self::TableName_PromotionRecord .
            ' WHERE PromoterId=:PromoterId ' .
            ' ORDER BY CreateDate DESC' .
            ' LIMIT ' . $pageBegin . ' , ' . $pageSize . ';';
        $result = $this->dbOperator->GetArrayList($sql, $dataProperty);

        $sql = 'SELECT COUNT(PromotionRecordId) FROM ' . self::TableName_PromotionRecord .
            ' WHERE PromoterId=:PromoterId ;';
        $allCount = $this->dbOperator->GetInt($sql, $dataProperty);
        return $result;
    }
}
