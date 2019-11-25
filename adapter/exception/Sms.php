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
 * Sms adapter exception
 * @author JunRu Shen
 */
if (!defined('BASE_PATH')) {
    die('Access Denied.');
}

// Error codes
define('SMS_SERVER_ERROR', 500);
define('SMS_CLIENT_ERROR', 501);
define('SMS_CONFIGURATION_ERROR', 502);

class SmsException extends Exception
{
    // phone number
    private $_phone;

    // sign name
    private $_signName;

    // template code
    private $_templateCode;

    // template params
    private $_templateParams;

    // construct
    public function __construct($message, $code, $phone, $signName, $templateCode, $templateParams)
    {
        parent::__construct($message, $code);
        $this->_phone = $phone;
        $this->_signName = $signName;
        $this->_templateCode = $templateCode;
        $this->_templateParams = $templateParams;
    }

    // get extra
    public function getExtra()
    {
        return vsprintf('Calling %s [signName = %s, templateCode = %s, templateParams = %s]', array(
            $this->_phone,
            $this->_signName,
            $this->_templateCode,
            json_encode($this->_templateParams)
        ));
    }
}
