<?php
/*
 * Product by HelloWorld team
 *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * * Licensed under the Apache License, Version 2.0 (the "License");         * *
 * * you may not use this file except in compliance with the License.        * *
 * * You may obtain a copy of the License at                                 * *
 * *   http://www.apache.org/licenses/LICENSE-2.0                            * *
 * * Unless required by applicable law or agreed to in writing, software     * *
 * * distributed under the License is distributed on an "AS IS" BASIS,       * *
 * * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.* *
 * * See the License for the specific language governing permissions and     * *
 * * limitations under the License.                                          * *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *
 * The word processing adapter
 * @author JunRu Shen
 */
if (!defined('BASE_PATH')) {
    die('Access Denied.');
}

import('adapter/default/aliyun/vendor/autoload');
import('adapter/default/config/AliyunApi');

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;

import('adapter/interface/ISms');
class SmsAdapter implements ISmsAdapter
{
    // send text message
    private static function _sendText($phone, $signName, $templateCode, $templateParams)
    {
        AlibabaCloud::accessKeyClient(AliyunApiConfig::$accessKeyId, AliyunApiConfig::$accessSecret)
                        ->regionId('cn-hangzhou')
                        ->asDefaultClient();
        try {
            $result = AlibabaCloud::rpc()
                        ->product('Dysmsapi')
                        ->version('2017-05-25')
                        ->action('SendSms')
                        ->method('POST')
                        ->host('dysmsapi.aliyuncs.com')
                        ->options([
                                'query' => [
                                    'RegionId' => 'cn-hangzhou',
                                    'PhoneNumbers' => $phone,
                                    'SignName' => $signName,
                                    'TemplateCode' => $templateCode,
                                    'TemplateParam' => json_encode($templateParams)
                                ]
                            ])
                        ->request();
            if ($result['Code'] != 'OK') {
                throw new SmsException($result['Message'] . ' [' . $result['Code'] . ']', SMS_CONFIGURATION_ERROR, $phone, $signName, $templateCode, $templateParams);
                return false;
            }
            return true;
        } catch (ClientException $e) {
            throw new SmsException($e->getErrorMessage(), SMS_CLIENT_ERROR, $phone, $signName, $templateCode, $templateParams);
        } catch (ServerException $e) {
            throw new SmsException($e->getErrorMessage(), SMS_SERVER_ERROR, $phone, $signName, $templateCode, $templateParams);
        }
    }

    // send the verify code
    public static function sendVerifyCode($phone, $code)
    {
        return self::_sendText($phone, AliyunApiConfig::$smsSignName, AliyunApiConfig::$smsVerifyCodeTemplate, array(
            AliyunApiConfig::$smsVerifyCodeFlag => $code
        ));
    }
}
