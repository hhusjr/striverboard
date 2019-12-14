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
 * The Message Verify Model
 * @author JunRu Shen
 */
if (!defined('BASE_PATH')) {
    die('Access Denied.');
}

class MessageVerifyModel extends BaseModel
{
    // set the table name
    public function __construct()
    {
        parent::__construct('msgverification_codes');
    }

    // generate the verify code
    private function _generateVerifyCode()
    {
        $code = '';
        for ($i = 0; $i < 6; $i++) {
            $code .= (string) mt_rand(1, 9);
        }
        return $code;
    }

    // check if the gap is too short
    public function checkGap($phone, $action)
    {
        $time = intval($this->select('time')->condition([
            'phone' => $phone,
            'action' => $action
        ])->limit(1)->fetchColumn());
        if (! $time) {
            return true;
        }
        
        $now = time();
        if ($now - $time <= 60 / R::config('sms')->maxMessageCountPerMinute) {
            return false;
        }
        return true;
    }

    // encrypt the code
    private function _encrypt($code)
    {
        return md5(md5($code));
    }

    // is the phone number valid
    public function validPhoneNumber($phone)
    {
        return V::phone($phone);
    }

    // generate verify code and send the message
    public function sendVerifyCode($phone, $action)
    {
        $phone = intval($phone);

        if (!$this->checkGap($phone, $action)) {
            return 'ERROR_GAP_TOO_SHORT';
        }

        $code = $this->_generateVerifyCode();

        try {
            SmsAdapter::sendVerifyCode($phone, $code);
        } catch (SmsException $e) {
            $code = $e->getCode();
            if ($code == SMS_CONFIGURATION_ERROR) {
                return 'ERROR_SMS_CONFIGURATION';
            }
            return 'ERROR_SMS_SYSTEM';
        }

        // clear the expired message or old message
        $time = time() - R::config('sms')->verifyCodeExpireMinute * 60;
        $this->delete()->condition([
            [
                'phone' => $phone,
                'action' => $action
            ],
            'time <' => $time
        ], 'OR')->execute();

        $insert = $this->insertIgnore([
            'phone' => $phone,
            'action' => $action,
            'code' => $this->_encrypt($code),
            'time' => time()
        ])->execute();
        if (!$insert) {
            return 'ERROR_INSERT';
        }

        return true;
    }

    // check if the code is right
    public function check($phone, $code, $action)
    {
        $time = time() - R::config('sms')->verifyCodeExpireMinute * 60;
        return $this->exists([
            'phone' => $phone,
            'code' => $this->_encrypt($code),
            'action' => $action,
            'time >=' => $time
        ]);
    }
}
