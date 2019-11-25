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
 * The User controller
 * @author JunRu Shen
 */
if (!defined('BASE_PATH')) {
    die('Access Denied.');
}

class UserController extends CommonController
{
    // register form
    public function onRegister()
    {
        $assigns = new stdClass;
        $assigns->fields = R::M('Field')->getFields();
        $this->show('register', $assigns);
    }

    // register data processing
    public function onAjaxRegister()
    {
        $this->needAjax();
        $this->needPost();
        $msgVerifyCode = F::post('verify_code');

        $userInfo = new stdClass;
        $userInfo->realName = F::post('real_name');
        $userInfo->password = F::post('password');
        $userInfo->phone = F::post('phone');
        $userInfo->mission = F::post('mission');
        $userInfo->fid = F::post('fid');
        $userInfo->institution = F::post('institution');

        $userModel = R::M('User');
        $validation = $userModel->isValid($msgVerifyCode, $userInfo);
        if ($validation === true && $userModel->register($userInfo)) {
            $this->json(['success' => true]);
        }
        $map = [
            'INVALID_phone' => 'phone',
            'INVALID_msgVerifyCode' => 'msgVerifyCode',
            'INVALID_mission' => 'mission',
            'INVALID_institution' => 'institution'
        ];
        $this->json([
            'success' => false,
            'message' => $validation,
            'error' => isset($map[$validation]) ? $map[$validation] : ''
        ]);
    }

    // send registration verify code action
    public function onAjaxSendVerifyCode()
    {
        $this->needAjax();
        $this->needPost();
        $type = F::post('type');
        $phone = F::post('phone');
        if (!R::M('MessageVerify')->validPhoneNumber($phone)) {
            $this->json(['success' => false, 'message' => 'Invalid phone number.']);
        }
        $userModel = R::M('User');
        switch ($type) {
        case 'register':
            $result = $userModel->sendRegistrationMsgVerifyCode($phone);
            break;
        case 'login':
            $result = $userModel->sendLoginMsgVerifyCode($phone);
            break;
        default:
            $this->showError();
        }
        $this->json(['success' => ($result === true), 'message' => $result]);
    }

    // login
    public function onAjaxLogin()
    {
        $this->needAjax();
        $this->needPost();
        $phone = F::post('phone');
        $password = F::post('password');
        $verifyCode = F::post('verify_code');
        if ($uid = R::M('User')->login($phone, $password, $verifyCode)) {
            SessionAdapter::write('user_id', $uid);
            SessionAdapter::write('ckfinder_user_id', $uid);
            $this->json(['success' => true]);
        }
        $this->json(['success' => false]);
    }

    // logout
    public function onLogout()
    {
        if (!SessionAdapter::exists('user_id')) {
            $this->showError();
        }
        SessionAdapter::destroy('user_id');
        $this->redirect('Index', 'Index');
    }
}
