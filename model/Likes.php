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
 * The Likes Model
 * @author JunRu Shen
 */
if (!defined('BASE_PATH')) {
    die('Access Denied.');
}

class LikesModel extends BaseModel
{
    // set the table name
    public function __construct()
    {
        parent::__construct('likes');
    }
    
    // count likes in a moment
    public function countLikes($mid)
    {
        return $this->countWhere()->condition(['mid' => intval($mid)])->fetchColumn();
    }

    // check if a user liked a moment
    public function liked($mid, $uid)
    {
        return (bool) $this->exists(['mid' => $mid, 'uid' => $uid]);
    }

    // check if a user has the permission to place like in a moment
    public function likable($mid, $uid)
    {
        $mid = intval($mid);
        $uid = intval($uid);
        return R::M('Moments')->visible($uid, $mid) && !$this->liked($mid, $uid);
    }

    // give some moment a like
    public function like($mid, $uid)
    {
        $mid = intval($mid);
        $uid = intval($uid);

        $addLike = $this->insertIgnore([
            'mid' => $mid,
            'uid' => $uid
        ])->execute();

        if (!$addLike) {
            return false;
        }

        $owner = R::M('Moments')->getOwner($mid);
        if ($owner == $uid) {
            return true;
        }

        return R::M('Message')->pushMessage($owner, 'newLike', [
            'mid' => $mid,
            'uid' => $uid
        ]);
    }
}
