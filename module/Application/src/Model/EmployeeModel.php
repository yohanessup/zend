<?php
/**
 * Created by PhpStorm.
 * User: YohanesSuprapto
 * Date: 9/14/2017
 * Time: 3:01 PM
 */

namespace Application\Model;

use Application\Connection;
use Zend\Mvc\Controller\AbstractActionController;

use Zend\Db\Sql\Sql;

class EmployeeModel extends AbstractActionController
{
    var $adapter;

    var $dataInsert = array();

    var $dataUpdate = array();

    var $id;

    public function setAdapterConnection($adapter)
    {
        $this->adapter = $adapter;
    }

    public function setDataInsert($data_insert)
    {
        $this->dataInsert = $data_insert;
    }

    public function setDataUpdate($data_update)
    {
        $this->dataUpdate = $data_update;
    }

    public function setEmployeeId($emp_id)
    {
        $this->id = $emp_id;
    }

    public function getAllData()
    {
        $adapter = $this->adapter;
        $sql = new Sql($adapter, 'employees');
        $select = $sql->select();

        $selectString = $sql->getSqlStringForSqlObject($select);
        $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);

        return $results;
    }

    public function getSpecificData()
    {
        $adapter = $this->adapter;
        $sql = new Sql($adapter, 'employees');
        $select = $sql->select();
        $select ->where(array('id' => $this->id));

        $selectString = $sql->getSqlStringForSqlObject($select);
        $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);

        return $results;

    }
    public function insertData()
    {
        $adapter = $this->adapter;
        $sql = new Sql($adapter);
        $select = $sql->insert('employees');
        $select->values($this->dataInsert);

        $selectString = $sql->getSqlStringForSqlObject($select);
        $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);

        return $results;
    }

    public function updateData()
    {
        $adapter = $this->adapter;
        $sql = new Sql($adapter);
        $update = $sql->update('employees');

        $update->set($this->dataUpdate);
        $update->where(array('id'=>$this->id));

        $selectString = $sql->getSqlStringForSqlObject($update);
        $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);

        return $results;
    }

    public function deleteData()
    {
        $adapter = $this->adapter;
        $sql = new Sql($adapter, 'employees');
        $select = $sql->delete();
        $select ->where(array('id' => $this->id));

        $selectString = $sql->getSqlStringForSqlObject($select);
        $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);

        return $results;
    }
}