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
 * The exception of Database component
 * @author JunRu Shen
 */
if (!defined('BASE_PATH')) {
    die('Access Denied.');
}

// Error codes
define('DATABASE_ERROR_CONNECTION', 500);
define('DATABASE_ERROR_QUERY', 501);

class DatabaseException extends Exception
{
    // attributes
    private $_sql;
    private $_errorCode;
    private $_entry;

    // construction
    public function __construct($message, $code, $sql, $errorCode, $entry)
    {
        parent::__construct($message, $code);
        $this->_sql = $sql;
        $this->_errorCode = $errorCode;
        $this->_entry = $entry;
    }

    // getters
    public function getSql()
    {
        return $this->_sql;
    }
    public function getErrorCode()
    {
        return $this->_errorCode;
    }
    public function getEntry()
    {
        return $this->_entry;
    }

    // getExtra
    public function getExtra()
    {
        return sprintf(
            '[MySQL Code #%s] %s (CONNECTION: %s@%s:%s by password %s to %s)',
            $this->_errorCode,
            $this->getMessage(),
            $this->_entry->user,
            $this->_entry->host,
            $this->_entry->port,
            $this->_entry->password,
            $this->_entry->name
        );
    }
}
