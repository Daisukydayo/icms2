<?php

/**
 * 前端 邀请码 生成类
 * @category iCMS
 * @package iCMS_FrameWork1_RuleClass_Gen_Promotion
 * @author 525
 */
class PromotionRecordPublicGen extends BasePublicGen implements IBasePublicGen
{

    /**
     * 引导方法
     * @return string 返回执行结果
     */
    public function GenPublic()
    {
        $result = "";
        $method = Control::GetRequest("a", "");
        if ($method == "") {
            $method = Control::GetRequest("f", "");
        }
        switch ($method) {

            case "create":
                $result = self::GenCreate();
                break;
            case "get_one":
                $result = self::GetOne();
                break;
            case "async_get_count":
                $result = self::AsyncGetCount();

        }
        $result = str_ireplace("{function}", $method, $result);
        return $result;
    }

    private function GenCreate()
    {

        $userId = Control::GetUserId();
        //if ($userId > 0) {

        $promoterId = Control::PostOrGetRequest("promoter_id", "");
        $encryptStr = Control::PostOrGetRequest("device_id", "");
        $md5Str = Control::PostOrGetRequest("key_2", "");
        $deviceType = intval(Control::PostOrGetRequest("device_type", 0));
        $userMobile = Control::PostOrGetRequest("user_mobile", "");
        $ipAddress = Control::GetIp();
        $hasBindPromoterId = -1;

        //promoter_id 5010 device_id O2M7hvtbWqPBJgP/0o0AYQ== key_2 a0c27703ae9eef337a7f92184c610537 device_type 1 ip 1

        $debug = new DebugLogManageData();
        $debug->Create("promoter_id " . $promoterId . "|||");
        $debug->Create("device_id " . $encryptStr . "|||");
        $debug->Create("key_2 " . $md5Str . "|||");
        $debug->Create("device_type " . $deviceType . "|||");
        $debug->Create("user_mobile " . $userMobile . "|||");
        $debug->Create("ip " . $ipAddress . "|||");

        //检查密文和指纹
        if (!empty($encryptStr) && !empty($md5Str)) {

            if ($deviceType <= 0) { //iOS

                $decryptStr = Des::DecryptForObjc($encryptStr, "ZAQ!xsw2");
                $decryptMd5Str = md5($decryptStr);

            } else { //Java

                $des = DesFitAllPlatForm::GetInstance();
                $decryptStr = $des->Decode($encryptStr, "ZAQ!xsw2");
                $decryptMd5Str = md5($decryptStr);

                //$decryptStr = Des::DecryptFitAll($encryptStr, "ZAQ!xsw2");
                //$decryptStr = self::decrypt("ZAQ!xsw2",$encryptStr );
                //$cancelMd5 = false;
                //if ($decryptStr == ''){
                //ios failure , //DONE update iPhone 2.0.6
                //    $decryptStr = $encryptStr;
                //    $decryptMd5Str = $md5Str;
                //    $cancelMd5 = true;
                //}
            }


            //echo $decryptStr;
            //die();


            //密文指纹比对
            if ($decryptMd5Str == $md5Str) {


                $promotionRecordPublicData = new PromotionRecordPublicData();
                //判断是否重复
                $hasBindPromoterId = $promotionRecordPublicData->CheckIsExist($decryptStr);
                if ($hasBindPromoterId <= 0) {
                    $createDate = date("Y-m-d H:i:s", time());
                    $deviceNumber = $decryptStr;
                    $newPromotionRecordId = $promotionRecordPublicData->Create(
                        $promoterId, $createDate, $deviceType, $deviceNumber, $userId,
                        $ipAddress,$userMobile);
                    //添加成功
                    if ($newPromotionRecordId > 0) {
                        $resultCode = 1;
                    } else {
                        $resultCode = -4; //添加失败；
                    }
                } else {
                    $resultCode = -3; //重复添加；
                }
            } else {
                $resultCode = -2; //密文错误;
            }

        } else {
            $resultCode = -1; //参数错误;
        }
        //} else {
        //    $resultCode = $userId; //会员检验失败,参数错误
        //}


        return '{"result_code":"' . $resultCode . '","promoter":"'.$hasBindPromoterId.'"}';
    }

    private function GetOne()
    {

        $result = "[{}]";

        $promotionRecordId = intval(Control::PostOrGetRequest("promotion_record_id", 0));


        if ($promotionRecordId > 0) {
            $newspaperArticleClientData = new PromotionRecordClientData();
            $arrOne = $newspaperArticleClientData->GetOne($promotionRecordId, TRUE);

            $result = Format::FixJsonEncode($arrOne);
            $resultCode = 1; //

        } else {
            $resultCode = -1; //参数错误;
        }


        return '{"result_code":"' . $resultCode . '","promotion_record":' . $result . '}';


    }


    /**
     * 获取推荐次数
     * @return string
     */
    private function AsyncGetCount()
    {
        $result = "";
        $promoterId = intval(Control::GetRequest("promoter_id", 0));

        if ($promoterId > 0) {
            $promotionRecordPublicData = new PromotionRecordPublicData();
            $result = $promotionRecordPublicData->GetCount($promoterId);
        }
        return Control::GetRequest("jsonpcallback", "") . '({"result":"' . $result . '"})';
    }

} 