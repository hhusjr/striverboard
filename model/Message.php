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
 * The Option Model
 * @author JunRu Shen
 */
if (!defined('BASE_PATH')) {
    die('Access Denied.');
}

class MessageModel extends BaseModel
{
    // valid types => params
    private $_types = [
        'newFollower' => ['uid'],
        'newLike' => ['mid', 'uid'],
        'newMoment' => ['mid', 'uid']
    ];

    // set table
    public function __construct()
    {
        parent::__construct('messages');
    }

    // if a message type is valid
    public function isValidType($type)
    {
        return isset($this->_types[$type]);
    }

    // get the extra params of a message
    public function parseExtra($msgType, $msgParams)
    {
        $userModel = R::M('User');
        $momentsModel = R::M('Moments');

        $extra = new stdClass;
        switch ($msgType) {
            case 'newFollower':
                $extra->uid = intval($msgParams['uid']);
                $extra->realName = $userModel->getRealName($extra->uid);
                break;
            case 'newLike':
            case 'newMoment':
                $extra->moment = $momentsModel->getMoment($msgParams['mid']);
                $extra->uid = intval($msgParams['uid']);
                $extra->realName = $userModel->getRealName($extra->uid);
                break;
            default:
                return false;
        }

        return $extra;
    }

    // get messages (in one year)
    public function getMessages($uid, $page, $pageSize)
    {
        $page = intval($page);
        $pageSize = intval($pageSize);
        $offset = abs(($page - 1) * $pageSize);
        $length = abs($pageSize);

        $messages = $this->select(['msg_id', 'msg_type', 'time', 'is_read', 'msg_params'])
                        ->condition([
                            'time >=' => time() - 365 * 24 * 3600,
                            'uid' => intval($uid)
                        ])
                        ->order(['is_read ASC', 'time DESC', 'msg_id DESC'])
                        ->limit($offset, $length)
                        ->fetchAll();

        $results = [];
        foreach ($messages as $message) {
            $result = new stdClass;
            $result->msgId = intval($message['msg_id']);
            $result->msgType = $this->isValidType($message['msg_type']) ? $message['msg_type'] : 'Unknown';
            $result->time = intval($message['time']);
            $result->isRead = (bool) $message['is_read'];
            $result->msgParams = json_decode($message['msg_params'], true);
            $result->extra = $this->parseExtra($result->msgType, $result->msgParams);
            $results[] = $result;
        }
        return $results;
    }

    // get unread message count
    public function countUnreadMessages($uid)
    {
        return intval($this->countWhere()->condition([
            'uid' => $uid,
            'is_read' => 0
        ])->fetchColumn());
    }

    // is the message valid
    public function isValid($uid, $msgType, $msgParams)
    {
        $uid = intval($uid);
        if (!R::M('User')->uidExists($uid)) {
            return 'INVALID_uid';
        }
        if (!$this->isValidType($msgType)) {
            return 'INVALID_msgType';
        }
        foreach ($this->types[$msgType] as $required) {
            if (!isset($msgParams[$required]) || is_array($msgParams[$required])) {
                return 'INVALID_msgParams';
            }
        }
        return true;
    }

    // push message
    public function pushMessage($uid, $msgType, $msgParams)
    {
        $insert = [
            'uid' => intval($uid),
            'msg_type' => $this->isValidType($msgType) ? $msgType : 'Unknown',
            'msg_params' => json_encode($msgParams),
            'time' => time(),
            'is_read' => 0
        ];
        return $this->insert($insert)->execute();
    }

    // is the user able to set a message read
    public function ableSetRead($uid, $msgId)
    {
        return $this->exists([
            'uid' => intval($uid),
            'msg_id' => intval($msgId)
        ]);
    }

    // read
    public function setRead($msgId)
    {
        return $this->modify(['is_read' => 1])->condition(['msg_id' => $msgId])->limit(1)->execute();
    }
}
