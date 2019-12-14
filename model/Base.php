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
 * Base Model
 * @author JunRu Shen
 */
if (!defined('BASE_PATH')) {
    die('Access Denied.');
}

abstract class BaseModel extends ModelComponent
{
    //table
    private $_table;
    
    //the sql statement
    private $_statement;
    
    //set table name
    public function __construct($table)
    {
        parent::__construct();
        $this->_table = $table;
    }

    //select data
    public function select($field = '*', $from = null)
    {
        $this->_statement = parent::getDb()->select($field, $from ? $from : $this->_table);
        return $this;
    }

    //translate
    public function translate($source, $from, $to, $table = null)
    {
        return parent::getDb()
                            ->select($to, $table ? $table : $this->_table)
                            ->where(array($from => $source))
                            ->limit(1)->query()->fetchColumn();
    }
    
    //count data
    public function count($table = null)
    {
        return parent::getDb()
                    ->select('COUNT(*)', $table ? $table : $this->_table)
                    ->query()->fetchColumn();
    }

    //count data ('where' allowed)
    public function countWhere($table = null)
    {
        $this->_statement = parent::getDb()->select('COUNT(*)', $table ? $table : $this->_table);
        return $this;
    }

    //if the data exists
    public function exists($condition, $table = null)
    {
        return $this->countWhere($table)->condition($condition)->limit(1)->fetchColumn();
    }
    
    //conditions
    public function condition($condition, $connection = 'AND')
    {
        $this->_statement->where($condition, $connection);
        return $this;
    }
    
    //order
    public function order($order)
    {
        $this->_statement->order($order);
        return $this;
    }
    
    //pager limit
    public function limit($start, $length = null)
    {
        $this->_statement->limit($start, $length);
        return $this;
    }
    
    // group by
    public function groupBy($args)
    {
        $this->_statement->groupBy($args);
        return $this;
    }

    //fetch one
    public function fetch()
    {
        return $this->_statement->query()->fetch();
    }
    
    //fetch all
    public function fetchAll()
    {
        return $this->_statement->query()->fetchAll();
    }

    //fetch one column
    public function fetchColumn()
    {
        return $this->_statement->query()->fetchColumn();
    }

    //get the result set
    public function result()
    {
        return $this->_statement->query();
    }
    
    //modify
    public function modify($changes, $table = null, $quote = true)
    {
        $this->_statement = parent::getDb()->update($table ? $table : $this->_table, $changes, $quote);
        return $this;
    }

    //join
    public function join($type, $table, $leftColumn, $rightColumn)
    {
        $this->_statement->join($type, $table, $leftColumn, $rightColumn);
        return $this;
    }

    //insert
    public function insert($factors, $table = null)
    {
        $this->_statement = parent::getDb()->insert($table ? $table : $this->_table, $factors);
        return $this;
    }
    //on duplicate
    public function onDuplicateKey($actions)
    {
        $this->_statement->onDuplicateKey($actions);
        return $this;
    }
    //insert ignore into
    public function insertIgnore($factors, $table = null)
    {
        $this->_statement = parent::getDb()->insert($table ? $table : $this->_table, $factors, true);
        return $this;
    }

    //delete
    public function delete($table = null)
    {
        $this->_statement = parent::getDb()->delete($table ? $table : $this->_table);
        return $this;
    }

    //execute
    public function execute()
    {
        return $this->_statement->execute();
    }
    
    //get last insert id
    public function lastInsertId()
    {
        return $this->getDb()->lastInsertId();
    }
    
    // get affected rows
    public function affectedRows()
    {
        return $this->getDb()->getAffectedRows();
    }
}
