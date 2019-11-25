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

import('adapter/default/jieba/vendor/multi-array/MultiArray');
import('adapter/default/jieba/vendor/multi-array/Factory/MultiArrayFactory');
import('adapter/default/jieba/class/Jieba');
import('adapter/default/jieba/class/Finalseg');
import('adapter/default/jieba/class/JiebaAnalyse');

use Fukuball\Jieba\Jieba;
use Fukuball\Jieba\Finalseg;
use Fukuball\Jieba\JiebaAnalyse;
Jieba::init();
Finalseg::init();
JiebaAnalyse::init();

import('adapter/interface/IWordProcess');
class WordProcessAdapter implements IWordProcessAdapter
{
    // get top 20 keywords in a document
    public static function getKeywords($document) {
        return JiebaAnalyse::extractTags($document);
    }
}
