<?php

/**
 * 公开访问 通用 生成类
 * @category iCMS
 * @package iCMS_FrameWork1_RuleClass_Gen_Common
 * @author zhangchi
 */
class CommonPublicGen extends BasePublicGen implements IBasePublicGen {

    /**
     * 引导方法
     * @return string 返回执行结果
     */
    public function GenPublic() {
        $result = "";
        $action = Control::GetRequest("a", "");
        switch ($action) {
            case "gen_verify_code":
                self::GenVerifyCode();
                break;
            case "gen_gif_verify_code":
                self::GenGifVerifyCode();
                break;
            case "gen_math_plus_verify_code":
                self::GenMathPlusVerifyCode();
                break;
            case "gen_math_minus_verify_code":
                self::GenMathMinusVerifyCode();
                break;
            case "gen_math_multiple_verify_code":
                self::GenMathMultipleVerifyCode();
                break;
            case "gen_random_verify_code":
                self::GenRandomVerifyCode();
                break;
            case "gen_r_verify_code":
                self::GenRVerifyCode();
                break;
            case "check_verify_code":
                $result = self::CheckVerifyCode();
                break;
        }
        return $result;
    }

    /**
     * 生成验证码
     */
    private function GenVerifyCode() {
        $sessionName = Control::GetRequest("sn", "");
        VerifyCode::Gen($sessionName);
    }

    /**
     * 生成Gif验证码
     */
    private function GenGifVerifyCode(){
        $sessionName = Control::GetRequest("sn", "");
        VerifyCode::GenGif($sessionName);
    }

    /**
     * 生成加法验证码
     */
    private function GenMathPlusVerifyCode(){
        $sessionName = Control::GetRequest("sn", "");
        VerifyCode::GenMathPlus($sessionName);
    }


    /**
     * 生成减法验证码
     */
    private function GenMathMinusVerifyCode(){
        $sessionName = Control::GetRequest("sn", "");
        VerifyCode::GenMathMinus($sessionName);
    }


    /**
     * 生成乘法验证码
     */
    private function GenMathMultipleVerifyCode(){
        $sessionName = Control::GetRequest("sn", "");
        VerifyCode::GenMathMultiple($sessionName);
    }


    /**
     * 生成随机种类验证码
     */
    private function GenRandomVerifyCode(){
        $rand=rand(1,5);
        switch($rand){
            case "1":
                self::GenVerifyCode();
                break;
            case "2":
                self::GenGifVerifyCode();
                break;
            case "3":
                self::GenMathPlusVerifyCode();
                break;
            case "4":
                self::GenMathMinusVerifyCode();
                break;
            case "5":
                self::GenMathMultipleVerifyCode();
                break;
        }
    }


    /**
     * 检查验证码是否正确
     * @return mixed 返回 -1:验证码无效 1:正确 null:默认值，未处理
     */
    private function CheckVerifyCode() {
        $sessionName = Control::GetRequest("sn", "");
        $verifyCodeType = Control::GetRequest("verify_code_type", 0);  //0:int  1:json
        $verifyCodeValue = Control::GetRequest("verify_code_value", 0);
        $result = VerifyCode::Check($sessionName, $verifyCodeType, $verifyCodeValue);
        return $result;
    }




}

?>
