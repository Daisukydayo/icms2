<?php

/**
 * ǰ�� �Ƽ��� ������
 * @category iCMS
* @package iCMS_FrameWork1_RuleClass_Gen_Promotion
* @author 525
*/
class PromoterPublicGen
{
    /**
     * ��������
     * @return string ����ִ�н��
     */
    public function GenPublic(){
        $result = "";
        $method = Control::GetRequest("a", "");

        switch ($method) {

            case "async_get_promoter_name":
                $result = self::AsyncGetPromoterName();
                break;
                break;

        }
        $result = str_ireplace("{function}", $method, $result);
        return $result;
    }

    /**
     * ��ȡ�Ƽ���
     * @return string
     */
    private function AsyncGetPromoterName() {
        $result="";
        $promoterId = intval(Control::GetRequest("promoter_id", 0));

        if ($promoterId > 0) {
            $promoterPublicData=new PromoterPublicData();
            $result = $promoterPublicData->GetPromoterName($promoterId,true);
        }
        return Control::GetRequest("jsonpcallback","") . '({"result":"'.$result.'"})';
    }
}