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
 * The common controller (like a middleware in NodeJS)
 * @author JunRu Shen
 */
if (!defined('BASE_PATH')) {
    die('Access Denied.');
}

class CommonController extends ControllerComponent
{   
    public function siteUri($suffixPath)
    {
        return R::M('Option')->get('site.uri') . '/' . $suffixPath;
    }
    
    public function buildUri($controller, $action, $params = null)
    {
        return $this->siteUri(R::adapter('Router')->buildUri($controller, $action, $params));
    }

    public function __construct()
    {
        $this->setTheme('default');
    }
    
    public function redirect($c, $a)
    {
        $uri = R::M('Option')->get('site.uri');
        F::redirect($uri . '/' . R::adapter('router')->buildUri($c, $a));
    }
    
    public function showError()
    {
        $this->redirect('Error', 'Index');
    }

    public function loginUserId()
    {
        return SessionAdapter::exists('user_id') ? SessionAdapter::read('user_id') : false;
    }

    public function isAdmin()
    {
        $uid = $this->loginUserId();
        return $uid && R::M('User')->isAdmin($uid);
    }

    public function show($name, $assigns = null)
    {
        if (!is_object($assigns)) {
            $assigns = new StdClass;
        }
        $optionModel = R::M('Option');
        $assigns->uri = $optionModel->get('site.uri');
        $assigns->sitename = $optionModel->get('site.name');
        $assigns->verifyCodeDelay = 60 / R::config('sms')->maxMessageCountPerMinute;
        $assigns->user = $this->getUserInfo();
        if ($assigns->user) {
            $assigns->user->mission = htmlspecialchars($assigns->user->mission);
        }
        $assigns->U = function ($controller, $action, $params = null, $return = false) {
            $result = R::C('Common')->buildUri($controller, $action, $params);
            if ($return) {
                return $result;
            } else {
                echo $result;
            }
        };
        $assigns->show = function ($name, $assigns = null) {
            return R::C('Common')->show($name, $assigns);
        };
        $assigns->S = function ($path, $return = false) use ($assigns) {
            $result = $assigns->uri . '/view/' . $this->_theme . '/static/' . $path;
            if ($return) {
                return $result;
            } else {
                echo $result;
            }
        };
        $this->display($name, $assigns);
    }
    
    public function needAjax()
    {
        if (!F::isAjax()) {
            $this->showError();
        }
    }

    public function getUserInfo()
    {
        $uid = $this->loginUserId();
        if (!$uid) {
            return false;
        }
        $info = R::M('User')->getUserInfo($uid);
        $data = new stdClass;
        $data->uid = $info->uid;
        $data->realName = $info->realName;
        $data->mission = $info->mission;
        $data->institution = $info->institution;
        $data->fid = $info->fid;
        $data->field = $info->field;
        $data->momentsVisibility = $info->momentsVisibility;
        $data->admin = (bool) $info->admin;
        return $data;
    }

    public function needLogin()
    {
        $userId = $this->loginUserId();
        if (!$userId) {
            $this->redirect('Index', 'Index');
            return false;
        }
        return $userId;
    }

    public function needAdmin()
    {
        if (!$this->isAdmin()) {
            $this->redirect('Index', 'Index');
            return false;
        }
        return $this->loginUserId();
    }

    public function needPost()
    {
        if (!F::isPost()) {
            $this->showError();
        }
    }

    public function pageCnt($count)
    {
        return ceil($count / R::M('Option')->get('page.size'));
    }
    
    public function json($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        die;
    }

    public function breakInfo($info, $success, $uri)
    {
        if (is_array($info)) {
            $info = implode("\r\n", $info);
        }
        $assigns = new StdClass;
        $assigns->info = nl2br(htmlspecialchars($info));
        $assigns->success = $success;
        $assigns->redirect = $uri;
        $this->show('info', $assigns);
        die;
    }
}
