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
 * The controller component, the parent class of any controller
 * @author JunRu Shen
 */
if (!defined('BASE_PATH')) {
    die('Access Denied.');
}

abstract class ControllerComponent
{
    // the theme
    protected $_theme = 'default';

    // display the view
    public function display($name, $assigns = null)
    {
        if (!is_object($assigns)) {
            $assigns = new StdClass;
        }
        R::adapter('Router')->view($name, $assigns);
    }

    // set theme
    public function setTheme($theme)
    {
        $this->_theme = $theme;
        R::adapter('Router')->setTheme($theme);
    }
}
