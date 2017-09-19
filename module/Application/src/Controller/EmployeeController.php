<?php
/**
 * Created by PhpStorm.
 * User: YohanesSuprapto
 * Date: 8/31/2017
 * Time: 11:23 AM
 */

namespace Application\Controller;

use RestApi\Controller\ApiController;
use Application\Model\EmployeeModel;
use Application\Connection;
use Zend\Db\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Mvc\Application;

/**
 * Employee Controller
 */
class EmployeeController extends ApiController
{

    /**
     * employee method
     *
     */
    public function getAction()
    {
        $emp_id = $this->params()->fromQuery('id');
        $connection = new Connection();
        $adapter = $connection::getAdapterConnection();

        $model = new EmployeeModel();

        $model->setAdapterConnection($adapter);

        $returnArr = array();
        if ($emp_id == '') {

            $results = $model->getAllData();

            if ($results->count() > 0) {
                while ($results->valid()) {
                    $returnArr[] = $results->current();
                    $results->next();
                }
            }
        } else {
            $model->setAdapterConnection($adapter);
            $model->setEmployeeId($emp_id);

            $results = $model->getSpecificData();

            if ($results->count() > 0) {
                while ($results->valid()) {
                    $returnArr[] = $results->current();
                    $results->next();
                }
            }
        }

        // your action logic

        // Set the HTTP status code. By default, it is set to 200
        $this->httpStatusCode = 200;

        // Set the response
        $this->apiResponse['data'] = $returnArr;

        return $this->createResponse();
    }

    public function updateAction()
    {
        $connection = new Connection();
        $adapter = $connection::getAdapterConnection();

        $putParams = array();
        parse_str($this->getRequest()->getContent(), $putParams);

        $first_name =  $putParams['first_name'];
        $last_name =  $putParams['last_name'];
        $email = $putParams['email'];
        $gender =  $putParams['gender'];
        $phone_number =  $putParams['phone_number'];

        $data = array(
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'gender' => $gender,
            'phone_number' => $phone_number
        );

        $id = $this->params()->fromQuery('id');

        $model = new EmployeeModel();

        $model->setAdapterConnection($adapter);

        $model->setEmployeeId($id);
        $model->setDataUpdate($data);

        $results = $model->updateData();

        // your action logic

        // Set the HTTP status code. By default, it is set to 200
        $this->httpStatusCode = 200;

        // Set the response
        if($results) {
            $this->apiResponse = array('code'=>'1003',
                'message'=>'Success Update Data');
        } else {
            $this->apiResponse['message'] = array('code'=>'1004',
                'message'=>'FAILED to update data. Please try again');
        }

        return $this->createResponse();
    }

    public function deleteAction()
    {
        $connection = new Connection();
        $adapter = $connection::getAdapterConnection();

        $putParams = array();
        parse_str($this->getRequest()->getContent(), $putParams);

        $emp_id = $putParams['id'];

        $model = new EmployeeModel();

        $model->setAdapterConnection($adapter);
        $model->setEmployeeId($emp_id);

        $results = $model->deleteData();

        // your action logic

        // Set the HTTP status code. By default, it is set to 200
        $this->httpStatusCode = 200;

        // Set the response
        if($results) {
            $this->apiResponse = array('code'=>'1001',
                    'message'=>'Success Delete Data');
        } else {
            $this->apiResponse['message'] = array('code'=>'1002',
                    'message'=>'FAILED to delete data. Please try again');
        }

        return $this->createResponse();
    }

    public function postAction()
    {
        $connection = new Connection();
        $adapter = $connection::getAdapterConnection();

        $first_name =  $this->params()->fromPost('first_name');
        $last_name =  $this->params()->fromPost('last_name');
        $email = $this->params()->fromPost('email');
        $gender =  $this->params()->fromPost('gender');
        $phone_number =  $this->params()->fromPost('phone_number');

        $data = array(
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'gender' => $gender,
            'phone_number' => $phone_number
        );

        $model = new EmployeeModel();

        $model->setAdapterConnection($adapter);
        $model->setDataInsert($data);

        $results = $model->insertData();

        // your action logic

        // Set the HTTP status code. By default, it is set to 200
        $this->httpStatusCode = 200;

        // Set the response
        if($results) {
            $this->apiResponse = array('code'=>'1003',
                'message'=>'Success Insert Data');
        } else {
            $this->apiResponse['message'] = array('code'=>'1004',
                'message'=>'FAILED to insert data. Please try again');
        }

        return $this->createResponse();
    }
}