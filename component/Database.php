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
 * The database component
 * @author JunRu Shen
 */
if (!defined('BASE_PATH')) {
    die('Access Denied.');
}

import('component/exception/Database');
class DatabaseComponent
{
    //database connection resource
    private $_resource;
    //sql code
    private $_sql = '';
    //the last affected rows
    private $_affectedRows = -1;
    //entry
    private $_entry = null;

    //make database connection
    public function __construct($entry)
    {
        $attributes = array(
            PDO::ATTR_PERSISTENT => false,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );
        $this->_entry = $entry;
        try {
            $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s', $entry->host, $entry->port, $entry->name);
            $resource = new PDO($dsn, $entry->user, $entry->password, $attributes);
            $resource->exec('SET NAMES "utf8"');
            $this->_resource = $resource;
        } catch (PDOException $e) {
            throw new DatabaseException($e->getMessage(), DATABASE_ERROR_CONNECTION, 'NULL', $e->getCode(), $entry);
        }
    }
    //select handler
    public function select($select, $from)
    {
        $select = !is_array($select) ? array($select) : $select;
        $prefix = R::config('database')->tablePrefix;
        // add table prefix there
        foreach ($select as $k => $v) {
            if (strpos($v, '.')) {
                $select[$k] = $prefix . $v;
            }
        }
        $from = !is_array($from) ? array($from) : $from;
        // add table prefix there
        foreach ($from as $k => $v) {
            $from[$k] = $prefix . $v;
        }
        $this->_sql = 'SELECT ' . implode(', ', $select) . ' FROM ' . implode(', ', $from);
        return $this;
    }
    //insert handler
    public function insert($into, $datas, $ignore = false)
    {
        $columns = array_keys($datas);
        // add quote automatically
        $values = array_map(array($this, 'quote'), array_values($datas));
        $this->_sql = 'INSERT ' . ($ignore ? 'IGNORE ' : '') . 'INTO ' . R::config('database')->tablePrefix . $into . ' (' . implode(', ', $columns) . ') VALUES (' . implode(', ', $values) . ')';
        return $this;
    }
    // on duplicate key
    public function onDuplicateKey($actions)
    {
        if (!is_array($actions)) {
            $actions = [$actions];
        }
        $this->_sql .= $this->_connect('ON DUPLICATE KEY UPDATE', implode(', ', $actions));
        return $this;
    }
    //update handler
    public function update($table, $set, $quote = true)
    {
        $code = array();
        foreach ($set as $column => $value) {
            $code[] = $column . ' = ' . ($quote ? $this->quote($value) : $value);
        }
        $this->_sql = 'UPDATE ' . R::config('database')->tablePrefix . $table . ' SET ' . implode(',', $code);
        return $this;
    }
    //delete handler
    public function delete($table)
    {
        $this->_sql = 'DELETE FROM ' . R::config('database')->tablePrefix . $table;
        return $this;
    }
    //where handler (core)
    public function _where($conditions, $connection)
    {
        if (!in_array($connection, ['AND', 'OR'])) {
            $connection = 'AND';
        }
        $codes = [];
        $i = count($conditions);
        $prefix = R::config('database')->tablePrefix;
        foreach ($conditions as $column => $value) {
            $i--;
            //combination methods
            $attributes = explode(' ', $column);
            $opt = isset($attributes[1]) ? $attributes[1] : '=';
            $quote = isset($attributes[2]) ? $attributes[2] : 'quote';
            $column = $attributes[0];
            //in
            if ($opt == 'IN') {
                $value = array_map(array($this, 'quote'), $value);
                $value = '(' . implode(', ', $value) . ')';
                $quote = 'no';
            }
            if (is_array($value)) {
                $codes[] = '(' . $this->_where($value, $column) . ')';
            } else {
                $code = $column;
                if (strpos($column, '.')) {
                    $column = $prefix . $column;
                }
                if ($opt != 'f') {
                    if ($quote == 'quote') {
                        $value = $this->quote($value);
                    } elseif ($quote == 'tbl' && strpos($value, '.')) {
                        $value = $prefix . $value;
                    }
                    $code .= ' ' . $opt . ' ' . $value;
                } else {
                    $code .= '(' . $value . ')';
                }
                $codes[] = $code;
            }
        }
        return implode(' ' . $connection . ' ', $codes);
    }
    //connect clauses and params
    private function _connect($clause, $params)
    {
        return empty($params) ? '' : ' ' . $clause . ' ' . $params;
    }
    //where
    public function where($conditions, $connection = 'AND')
    {
        $this->_sql .= $this->_connect('WHERE', (!is_array($conditions)) ? $conditions : $this->_where($conditions, $connection));
        return $this;
    }
    //group by
    public function groupBy($args)
    {
        $args = is_array($args) ? $args : [$args];
        $prefix = R::config('database')->tablePrefix;
        foreach ($args as $k => $v) {
            if (strpos($v, '.')) {
                $args[$k] = $prefix . $v;
            }
        }
        $this->_sql .= $this->_connect('GROUP BY', implode(', ', $args));
    }
    //order
    public function order($order)
    {
        $order = !is_array($order) ? array($order) : $order;
        $prefix = R::config('database')->tablePrefix;
        // add table prefix there
        foreach ($order as $k => $v) {
            if (strpos($v, '.')) {
                $order[$k] = $prefix . $v;
            }
        }
        $this->_sql .= $this->_connect('ORDER BY', implode(', ', $order));
        return $this;
    }
    //join (note: you should add table name in left/right/inner column)
    public function join($type, $table, $leftColumn, $rightColumn)
    {
        if (!in_array($type, ['left', 'right', 'inner'])) {
            return false;
        }
        $prefix = R::config('database')->tablePrefix;
        $params = $table . ' ON ' . $prefix . $leftColumn . ' = ' . $prefix . $rightColumn;
        $this->_sql .= $this->_connect(strtoupper($type) . ' JOIN', $params);
        return $this;
    }
    //limit
    public function limit($start, $length = null)
    {
        if ($start === null) {
            return $this;
        }
        $this->_sql .= $this->_connect('LIMIT', $start . ($length === null ? '' : ', ' . $length));
        return $this;
    }
    //add quote
    public function quote($data)
    {
        /*     if ($data === null){
                 return 'NULL';
             }
             if ($data === true) return '1';
             if ($data === false) return '0';
*/        return $this->_resource->quote($data);
    }
    //set sql
    public function setSql($sql)
    {
        $this->_sql = $sql;
        return $this;
    }
    //query datas in the database
    public function query()
    {
        $sql = $this->_sql;
        if (IN_DEBUG) {
            R::component('Error')->log('SQL Query: ' . $sql);
        }
        try {
            return $this->_resource->query($sql);
        } catch (PDOException $e) {
            throw new DatabaseException($e->getMessage(), DATABASE_ERROR_QUERY, $sql, $e->getCode(), $this->_entry);
        }
    }
    //execute sql statement (return affectedRows)
    public function execute()
    {
        $sql = $this->_sql;
        if (IN_DEBUG) {
            R::component('Error')->log('SQL Execute: ' . $sql);
        }
        try {
            $execute = $this->_resource->exec($sql);
            $this->_affectedRows = $execute !== false ? $execute : 0;
            return $execute !== false;
        } catch (PDOException $e) {
            throw new DatabaseException($e->getMessage(), DATABASE_ERROR_QUERY, $sql, $e->getCode(), $this->_entry);
        }
    }

    //get the last insert id
    public function lastInsertId()
    {
        return $this->_resource->lastInsertId();
    }

    //get affected rows
    public function getAffectedRows()
    {
        return $this->_affectedRows;
    }
}
