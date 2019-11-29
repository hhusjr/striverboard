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
 * The Message controller
 * @author JunRu Shen
 */
if (!defined('BASE_PATH')) {
    die('Access Denied.');
}

class MessageController extends CommonController
{
    // get messages action
    public function onAjaxMessages()
    {
        $this->needAjax();
        $this->needPost();

        $uid = $this->needLogin();
        $page = max(1, F::post('page'));
        $pageSize = 8;

        $messages = R::M('Message')->getMessages($uid, $page, $pageSize);

        $results = [];
        foreach ($messages as $message) {
            $result = [];
            $result['msgId'] = $message->msgId;
            $result['msgType'] = $message->msgType; // newFollower, newLike, newMoment
            $result['time'] = $message->time; // message post time
            $result['isRead'] = $message->isRead; // is the message read
            $result['extra'] = $message->extra; // the extra information of a message
            $results[] = $result;
        }

        $this->json($results);
    }

    // set the message read
    public function onAjaxSetMessageRead()
    {
        $this->needAjax();
        $this->needPost();

        $uid = $this->needLogin();
        $mid = F::post('msg_id');

        $messageModel = R::M('Message');
        if (!$messageModel->ableSetRead($uid, $mid)) {
            $this->showError();
        }
        $action = $messageModel->setRead($mid);

        $this->json(['success' => (bool) $action]);
    }
}
