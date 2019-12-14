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
 * The UnionSet algorithm component
 * @author JunRu Shen
 */
if (!defined('BASE_PATH')) {
    die('Access Denied.');
}

class UnionSetComponent
{
    // parent node
    private $_parent = [];

    // initialization
    public function __construct($vertexes)
    {
        $this->_parent[-1] = -1;
        foreach ($vertexes as $vertex) {
            $this->_parent[$vertex] = $vertex;
        }
    }

    // find the parent
    private function _find($vertex)
    {
        if (!isset($this->_parent[$vertex])) {
            return -1;
        }
        return ($this->_parent[$vertex] == $vertex)
                ? $vertex
                : ($this->_parent[$vertex] = $this->_find($this->_parent[$vertex]));
    }

    // query
    public function query($v1, $v2)
    {
        $x = $this->_find($v1);
        $y = $this->_find($v2);

        if ($x == -1 || $y == -1) {
            return false;
        }

        return $this->_find($v1) == $this->_find($v2);
    }

    // merge
    public function merge($v1, $v2)
    {
        $x = $this->_find($v1);
        $y = $this->_find($v2);

        if ($x == -1 || $y == -1 || $x == $y) {
            return false;
        }

        $this->_parent[$x] = $y;
        return true;
    }
}
