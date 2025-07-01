<?php
namespace WeWorkApi\Api;
//
use WeWorkApi\Utils\HttpError;
use WeWorkApi\Utils\HttpUtils;
use WeWorkApi\Utils\NetWorkError;
use WeWorkApi\Utils\ParameterError;
use WeWorkApi\Utils\QyApiError;
use WeWorkApi\Utils\SysError;
use WeWorkApi\Utils\Utils;

include_once (__DIR__."/../Utils/Utils.php");

abstract class API
{
    public $rspJson = null;
    public $rspRawStr = null;

    const USER_CREATE       = '/cgi-bin/user/create?access_token=ACCESS_TOKEN';
    const USER_GET          = '/cgi-bin/user/get?access_token=ACCESS_TOKEN';
    const USER_UPDATE       = '/cgi-bin/user/update?access_token=ACCESS_TOKEN';
    const USER_DELETE       = '/cgi-bin/user/delete?access_token=ACCESS_TOKEN';
    const USER_BATCH_DELETE = '/cgi-bin/user/batchdelete?access_token=ACCESS_TOKEN';
    const USER_SIMPLE_LIST  = '/cgi-bin/user/simplelist?access_token=ACCESS_TOKEN';
    const USER_LIST         = '/cgi-bin/user/list?access_token=ACCESS_TOKEN';
    const USERID_TO_OPENID  = '/cgi-bin/user/convert_to_openid?access_token=ACCESS_TOKEN';
    const OPENID_TO_USERID  = '/cgi-bin/user/convert_to_userid?access_token=ACCESS_TOKEN';
    const USER_AUTH_SUCCESS = '/cgi-bin/user/authsucc?access_token=ACCESS_TOKEN';

    const DEPARTMENT_CREATE = '/cgi-bin/department/create?access_token=ACCESS_TOKEN';
    const DEPARTMENT_UPDATE = '/cgi-bin/department/update?access_token=ACCESS_TOKEN';
    const DEPARTMENT_DELETE = '/cgi-bin/department/delete?access_token=ACCESS_TOKEN';
    const DEPARTMENT_LIST   = '/cgi-bin/department/list?access_token=ACCESS_TOKEN';

    const TAG_CREATE        = '/cgi-bin/tag/create?access_token=ACCESS_TOKEN';
    const TAG_UPDATE        = '/cgi-bin/tag/update?access_token=ACCESS_TOKEN';
    const TAG_DELETE        = '/cgi-bin/tag/delete?access_token=ACCESS_TOKEN';
    const TAG_GET_USER      = '/cgi-bin/tag/get?access_token=ACCESS_TOKEN';
    const TAG_ADD_USER      = '/cgi-bin/tag/addtagusers?access_token=ACCESS_TOKEN';
    const TAG_DELETE_USER   = '/cgi-bin/tag/deltagusers?access_token=ACCESS_TOKEN';
    const TAG_GET_LIST      = '/cgi-bin/tag/list?access_token=ACCESS_TOKEN';

    const BATCH_JOB_GET_RESULT = '/cgi-bin/batch/getresult?access_token=ACCESS_TOKEN';

    const BATCH_INVITE      = '/cgi-bin/batch/invite?access_token=ACCESS_TOKEN';

    const AGENT_GET         = '/cgi-bin/agent/get?access_token=ACCESS_TOKEN';
    const AGENT_SET         = '/cgi-bin/agent/set?access_token=ACCESS_TOKEN';
    const AGENT_GET_LIST    = '/cgi-bin/agent/list?access_token=ACCESS_TOKEN';

    const MENU_CREATE       = '/cgi-bin/menu/create?access_token=ACCESS_TOKEN';
    const MENU_GET          = '/cgi-bin/menu/get?access_token=ACCESS_TOKEN';
    const MENU_DELETE       = '/cgi-bin/menu/delete?access_token=ACCESS_TOKEN';

    const MESSAGE_SEND      = '/cgi-bin/message/send?access_token=ACCESS_TOKEN';

    const MEDIA_GET         = '/cgi-bin/media/get?access_token=ACCESS_TOKEN';

    const GET_USER_INFO_BY_CODE = '/cgi-bin/user/getuserinfo?access_token=ACCESS_TOKEN';
    const GET_USER_DETAIL   = '/cgi-bin/user/getuserdetail?access_token=ACCESS_TOKEN';

    const GET_TICKET        = '/cgi-bin/ticket/get?access_token=ACCESS_TOKEN';
    conST GET_JSAPI_TICKET  = '/cgi-bin/get_jsapi_ticket?access_token=ACCESS_TOKEN';

    const GET_CHECKIN_OPTION = '/cgi-bin/checkin/getcheckinoption?access_token=ACCESS_TOKEN';
    const GET_CHECKIN_DATA  = '/cgi-bin/checkin/getcheckindata?access_token=ACCESS_TOKEN';
    const GET_APPROVAL_DATA = '/cgi-bin/corp/getapprovaldata?access_token=ACCESS_TOKEN';

    const GET_INVOICE_INFO  = '/cgi-bin/card/invoice/reimburse/getinvoiceinfo?access_token=ACCESS_TOKEN';
    const UPDATE_INVOICE_STATUS = '/cgi-bin/card/invoice/reimburse/updateinvoicestatus?access_token=ACCESS_TOKEN';
    const BATCH_UPDATE_INVOICE_STATUS = '/cgi-bin/card/invoice/reimburse/updatestatusbatch?access_token=ACCESS_TOKEN';
    const BATCH_GET_INVOICE_INFO = '/cgi-bin/card/invoice/reimburse/getinvoiceinfobatch?access_token=ACCESS_TOKEN';

    const GET_PRE_AUTH_CODE = '/cgi-bin/service/get_pre_auth_code?suite_access_token=SUITE_ACCESS_TOKEN';
    const SET_SESSION_INFO  = '/cgi-bin/service/set_session_info?suite_access_token=SUITE_ACCESS_TOKEN';
    const GET_PERMANENT_CODE = '/cgi-bin/service/get_permanent_code?suite_access_token=SUITE_ACCESS_TOKEN';
    const GET_AUTH_INFO     = '/cgi-bin/service/get_auth_info?suite_access_token=SUITE_ACCESS_TOKEN';
    const GET_ADMIN_LIST    = '/cgi-bin/service/get_admin_list?suite_access_token=SUITE_ACCESS_TOKEN';
    const GET_USER_INFO_BY_3RD = '/cgi-bin/service/getuserinfo3rd?suite_access_token=SUITE_ACCESS_TOKEN';
    const GET_USER_DETAIL_BY_3RD = '/cgi-bin/service/getuserdetail3rd?suite_access_token=SUITE_ACCESS_TOKEN';

    const GET_LOGIN_INFO    = '/cgi-bin/service/get_login_info?access_token=PROVIDER_ACCESS_TOKEN';
    const GET_REGISTER_CODE = '/cgi-bin/service/get_register_code?provider_access_token=PROVIDER_ACCESS_TOKEN';
    const GET_REGISTER_INFO = '/cgi-bin/service/get_register_info?provider_access_token=PROVIDER_ACCESS_TOKEN';
    const SET_AGENT_SCOPE   = '/cgi-bin/agent/set_scope';
    const SET_CONTACT_SYNC_SUCCESS = '/cgi-bin/sync/contact_sync_success';

    #获取配置了客户联系功能的成员列表
    const GET_FOLLOW_USER_LIST  = '/cgi-bin/externalcontact/get_follow_user_list?access_token=ACCESS_TOKEN';
    #批量获取客户
    const GET_BATCH_BY_USER     = '/cgi-bin/externalcontact/batch/get_by_user?access_token=ACCESS_TOKEN';
    #企业客户标签
    const GET_CORP_TAG_List     = '/cgi-bin/externalcontact/get_corp_tag_list?access_token=ACCESS_TOKEN';
    #获取客户详情
    const GET_EXTERNAL_CONTACT  = '/cgi-bin/externalcontact/get?access_token=ACCESS_TOKEN';
    #给客户打标签
    const MARK_TAG              = '/cgi-bin/externalcontact/mark_tag?access_token=ACCESS_TOKEN';
    #客户备注
    const REMARK                = '/cgi-bin/externalcontact/remark?access_token=ACCESS_TOKEN';
    #添加联系我方式
    const ADD_CONTACT_WAY       = '/cgi-bin/externalcontact/add_contact_way?access_token=ACCESS_TOKEN';
    #修改联系我方式
    const UPDATE_CONTACT_WAY    = '/cgi-bin/externalcontact/update_contact_way?access_token=ACCESS_TOKEN';
    #删除联系我方式
    const DEL_CONTACT_WAY       = '/cgi-bin/externalcontact/del_contact_way?access_token=ACCESS_TOKEN';

    #将企业主体下的明文userid转换为服务商主体下的密文userid。
    const USERID_TO_OPENUSERID  = '/cgi-bin/batch/userid_to_openuserid?access_token=ACCESS_TOKEN';
    #将企业主体下的external_userid转换为服务商主体下的external_userid
    const NEW_EXTERNAL_USERID   = '/cgi-bin/externalcontact/get_new_external_userid?access_token=ACCESS_TOKEN';

    #发送欢迎语
    const SEND_WELCOME_MSG      = '/cgi-bin/externalcontact/send_welcome_msg?access_token=ACCESS_TOKEN';
    #获取会话内容存档开启成员列表
    const GET_PERMIT_USER_LIST  = '/cgi-bin/msgaudit/get_permit_user_list?access_token=ACCESS_TOKEN';

    #添加敏感词
    const ADD_INTERCEPT_RULE    = '/cgi-bin/externalcontact/add_intercept_rule?access_token=ACCESS_TOKEN';
    #修改敏感词
    const UPDATE_INTERCEPT_RULE = '/cgi-bin/externalcontact/get_intercept_rule_list?access_token=ACCESS_TOKEN';
    #删除敏感词
    const DEL_INTERCEPT_RULE    = '/cgi-bin/externalcontact/get_intercept_rule?access_token=ACCESS_TOKEN';

    #获取企业的账号列表
    const LIST_ACTIVED_ACCOUNT  = '/cgi-bin/license/list_actived_account?provider_access_token=PROVIDER_ACCESS_TOKEN';

    #获取获客链接列表
    const CUSTPMER_ACQUISITION_CUSTOMER_LIST_LINK     = '/cgi-bin/externalcontact/customer_acquisition/list_link?access_token=ACCESS_TOKEN';
    #创建获客链接
    const CUSTPMER_ACQUISITION_CUSTOMER_CREATE_LINK   = '/cgi-bin/externalcontact/customer_acquisition/create_link?access_token=ACCESS_TOKEN';
    #删除获客链接
    const CUSTPMER_ACQUISITION_CUSTOMER_DEL_LINK      = '/cgi-bin/externalcontact/customer_acquisition/delete_link?access_token=ACCESS_TOKEN';
    #获取由获客链接添加的客户信息
    const CUSTPMER_ACQUISITION_CUSTOMER_CUSTOMER      = '/cgi-bin/externalcontact/customer_acquisition/customer?access_token=ACCESS_TOKEN';
    #添加标签
    const ADD_CORP_TAG  = '/cgi-bin/externalcontact/add_corp_tag?access_token=ACCESS_TOKEN';
    #编辑标签
    const EDIT_CORP_TAG  = '/cgi-bin/externalcontact/edit_corp_tag?access_token=ACCESS_TOKEN';
    #删除标签
    const DEL_CORP_TAG  = '/cgi-bin/externalcontact/del_corp_tag?access_token=ACCESS_TOKEN';
    #获取标签列表
    const GET_CORP_TAG_LIST  = '/cgi-bin/externalcontact/get_corp_tag_list?access_token=ACCESS_TOKEN';
    #设置公钥
    const SET_PUBNLIC_KEY  = '/cgi-bin/chatdata/set_public_key?access_token=ACCESS_TOKEN';
    #会话记录
    const SYNC_MSG  = '/cgi-bin/chatdata/sync_msg?access_token=ACCESS_TOKEN';
    #同步通话记录
    const SYNC_CALL_PROGRAM  = '/cgi-bin/chatdata/sync_call_program?access_token=ACCESS_TOKEN';
    
    const SYNC_PROGRAM_TASK  = '/cgi-bin/chatdata/async_program_task?access_token=ACCESS_TOKEN';

    const SYNC_PROGRAM_RESULT= '/cgi-bin/chatdata/async_program_result?access_token=ACCESS_TOKEN';

    #获取授权存档的成员列表
    const GET_AUTH_USER_LIST  = '/cgi-bin/chatdata/get_auth_user_list?access_token=ACCESS_TOKEN';
    
    #获取企业的账号列表
    const LIST_ID  = '/cgi-bin/user/list_id?access_token=ACCESS_TOKEN';
    #获取企业的部门列表
    const DEPARTMENT_SIMPLELIST = '/cgi-bin/department/simplelist?access_token=ACCESS_TOKEN';
    #获取企业的部门列表
    const DEPARTMENT_GET = '/cgi-bin/department/get?access_token=ACCESS_TOKEN';
    
    protected function GetAccessToken() { }
    protected function RefreshAccessToken() { }

    protected function GetSuiteAccessToken() { }
    protected function RefreshSuiteAccessToken() { }

    protected function GetProviderAccessToken() { }
    protected function RefreshProviderAccessToken() { }

    /**
     * @param $url
     * @param $method
     * @param $args
     * @throws ParameterError
     * @throws QyApiError
     * @throws HttpError
     * @throws NetWorkError
     * @throws SysError
     */
    protected function _HttpCall($url, $method, $args)
    {
        if ('POST' == $method) { 
            $url = HttpUtils::MakeUrl($url);
            $this->_HttpPostParseToJson($url, $args);
            $this->_CheckErrCode();
        } else if ('GET' == $method) { 
            if (count($args) > 0) { 
                foreach ($args as $key => $value) {
                    if ($value == null) continue;
                    if (strpos($url, '?')) {
                        $url .= ('&'.$key.'='.$value);
                    } else { 
                        $url .= ('?'.$key.'='.$value);
                    }
                }
            }
            $url = HttpUtils::MakeUrl($url);
            $this->_HttpGetParseToJson($url);
            $this->_CheckErrCode();
        } else { 
            throw new QyApiError('wrong method');
        }
    }

    /**
     * @param $url
     * @param bool $refreshTokenWhenExpired
     * @return bool|string|null
     * @throws QyApiError
     * @throws HttpError
     * @throws NetWorkError
     * @throws SysError
     */
    protected function _HttpGetParseToJson($url, $refreshTokenWhenExpired=true)
    {
        $retryCnt = 0;
        $this->rspJson = null;
        $this->rspRawStr = null;

        while ($retryCnt < 2) {
            $tokenType = null;
            $realUrl = $url;

            if (strpos($url, "SUITE_ACCESS_TOKEN")) {
                $token = $this->GetSuiteAccessToken();
                $realUrl = str_replace("SUITE_ACCESS_TOKEN", $token, $url);
                $tokenType = "SUITE_ACCESS_TOKEN";
            } else if (strpos($url, "PROVIDER_ACCESS_TOKEN")) {
                $token = $this->GetProviderAccessToken();
                $realUrl = str_replace("PROVIDER_ACCESS_TOKEN", $token, $url);
                $tokenType = "PROVIDER_ACCESS_TOKEN";
            } else if (strpos($url, "ACCESS_TOKEN")) {
                $token = $this->GetAccessToken();
                $realUrl = str_replace("ACCESS_TOKEN", $token, $url);
                $tokenType = "ACCESS_TOKEN";
            } else { 
                $tokenType = "NO_TOKEN";
            }

            $this->rspRawStr = HttpUtils::httpGet($realUrl);

            if ( ! Utils::notEmptyStr($this->rspRawStr)) throw new QyApiError("empty response"); 
            //
            $this->rspJson = json_decode($this->rspRawStr, true/*to array*/);
            if (strpos($this->rspRawStr, "errcode") !== false) {
                $errCode = Utils::arrayGet($this->rspJson, "errcode");
                if ($errCode == 40014 || $errCode == 42001 || $errCode == 42007 || $errCode == 42009) { // token expired
                    if ("NO_TOKEN" != $tokenType && true == $refreshTokenWhenExpired) {
                        if ("ACCESS_TOKEN" == $tokenType) { 
                            $this->RefreshAccessToken();
                        } else if ("SUITE_ACCESS_TOKEN" == $tokenType) {
                            $this->RefreshSuiteAccessToken();
                        } else if ("PROVIDER_ACCESS_TOKEN" == $tokenType) {
                            $this->RefreshProviderAccessToken();
                        } 
                        $retryCnt += 1;
                        continue;
                    }
                }
            }
            return $this->rspRawStr;
        }
    }

    /**
     * @param $url
     * @param $args
     * @param bool $refreshTokenWhenExpired
     * @param bool $isPostFile
     * @return mixed
     * @throws HttpError
     * @throws NetWorkError
     * @throws QyApiError
     * @throws SysError
     */
    protected function _HttpPostParseToJson($url, $args, $refreshTokenWhenExpired=true, $isPostFile=false)
    {
        $postData = $args;
        if (!$isPostFile) {
            if (!is_string($args)) {
                $postData = HttpUtils::Array2Json($args);
            }
        }
        $this->rspJson = null; $this->rspRawStr = null;

        $retryCnt = 0;
        while ($retryCnt < 2) {
            $tokenType = null;
            $realUrl = $url;

            if (strpos($url, "SUITE_ACCESS_TOKEN")) {
                $token = $this->GetSuiteAccessToken();
                $realUrl = str_replace("SUITE_ACCESS_TOKEN", $token, $url);
                $tokenType = "SUITE_ACCESS_TOKEN";
            } else if (strpos($url, "PROVIDER_ACCESS_TOKEN")) {
                $token = $this->GetProviderAccessToken();
                $realUrl = str_replace("PROVIDER_ACCESS_TOKEN", $token, $url);
                $tokenType = "PROVIDER_ACCESS_TOKEN";
            } else if (strpos($url, "ACCESS_TOKEN")) {
                $token = $this->GetAccessToken();
                $realUrl = str_replace("ACCESS_TOKEN", $token, $url);
                $tokenType = "ACCESS_TOKEN";
            } else { 
                $tokenType = "NO_TOKEN";
            }


            $this->rspRawStr = HttpUtils::httpPost($realUrl, $postData);
            $this->rspRawStr = mb_convert_encoding($this->rspRawStr, 'UTF-8', 'auto');

            if ( ! Utils::notEmptyStr($this->rspRawStr)) throw new QyApiError("empty response"); 

            $json = json_decode($this->rspRawStr, true/*to array*/);
            $this->rspJson = $json;

            $errCode = Utils::arrayGet($this->rspJson, "errcode");
            if ($errCode == 40014 || $errCode == 42001 || $errCode == 42007 || $errCode == 42009) { // token expired
                if ("NO_TOKEN" != $tokenType && true == $refreshTokenWhenExpired) {
                    if ("ACCESS_TOKEN" == $tokenType) { 
                        $this->RefreshAccessToken();
                    } else if ("SUITE_ACCESS_TOKEN" == $tokenType) {
                        $this->RefreshSuiteAccessToken();
                    } else if ("PROVIDER_ACCESS_TOKEN" == $tokenType) { 
                        $this->RefreshProviderAccessToken();
                    }
                    $retryCnt += 1;
                    continue;
                }
            }

            return $json;
        }
    }


    /**
     * @throws QyApiError
     * @throws ParameterError
     */
    protected function _CheckErrCode()
    {
        $rsp = $this->rspJson;
        $raw = $this->rspRawStr;
        if (is_null($rsp))
            return;

        if (!is_array($rsp))
            throw new ParameterError("invalid type " . gettype($rsp));
        if (!array_key_exists("errcode", $rsp)) {
            return;
        }
        $errCode = $rsp["errcode"];
        if (!is_int($errCode))
            throw new QyApiError(
                "invalid errcode type " . gettype($errCode) . ":" . $raw);
        if ($errCode != 0)
            throw new QyApiError("response error:" . $raw);
    }

}
