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
 * The model test controller
 * @author JunRu Shen
 */
if (!defined('BASE_PATH') || !IN_DEBUG) {
    die('Access Denied.');
}

class ModelTestController extends CommonController
{
    public function onIndex()
    {
        echo '<h1>MODEL TEST</h1>';
        echo '<form action="' . $this->buildUri('ModelTest', 'Submit') . '" method="post">';
        echo '<input type="text" name="name" id="name" placeholder="Model Name" /><br><br>';
        echo '<input type="text" name="action" id="action" placeholder="Action Name" /><br><br>';
        echo '<textarea name="args" id="args" style="width: 300px; height: 300px;"></textarea><br><br>';
        echo '<input type="submit" value="Run Model !" /></form>';
    }
    
    public function onSubmit()
    {
        echo '<h1>MODEL TEST</h1>';
        $name = F::post('name');
        $action = F::post('action');
        $args = explode(PHP_EOL, F::post('args'));
        $args = array_map('trim', $args);
        echo '<div style="padding: 10px; margin-bottom: 10px; background: #000000; color: #ffffff;">';
        echo $name . 'Model/' . $action . '<br>args: ';
        echo implode(',', $args);
        echo '</div><blockquote><pre>';
        $class = $name . 'Model';
        foreach ($args as $k => $v) {
            $t = explode('|||', $v);
            $h = array();
            if (strpos($t[0], ':::')) {
                foreach ($t as $kk => $vv) {
                    $ex = explode(':::', $vv);
                    $h[$ex[0]] = $ex[1];
                }
                $t = $h;
            }
            if ((!isset($t[1])) && isset($t[0]) && (!is_array($t[0]))) {
                $args[$k] = $t[0];
            } else {
                $args[$k] = $t;
            }
        }
        $obj = new $class;
        $res = call_user_func_array(array($obj, $action), $args);
        var_dump($res);
        echo '</pre></blockquote><br><br><a href="' . $this->buildUri('ModelTest', 'Index') . '">Return</a>';
        echo '<br><br><div style="padding: 10px; margin-bottom: 10px; background: #000000; color: #ffffff;">';
        echo 'Sessions:<br>';
        var_dump($_SESSION);
        echo '</div>';
    }
}
