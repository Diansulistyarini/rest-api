<?php
    // get koneksi
    include('connect.php');

    $connection = getConnect(); 
    $request_method = $_SERVER['REQUEST_METHOD']; 

    switch ($request_method) {
        // case buat method get kan
        case "GET":
            // 
            if (!empty($_GET["id"])) {
                get_employee(intval($_GET["id"])); 
            } else {
                get_employee(); 
            }
            break;

        case 'POST':
            insert_employee();
            break;

        case 'PUT':
            $id = intval($_GET["id"]);
            update_employe($id); 
            break;

        case 'DELETE':
            $id = intval($_GET["id"]);
            delete_employe($id);
            break;

      default:
            header("HTTP/1.0 405 Method Not Allowed");
            break;
    }

    // function for get data employee
    function get_employee($id = 0)
    {
        global $connection; 

        $querysql = "SELECT * FROM tb_employee"; 

        if ($id != 0) {
            $querysql .= " WHERE tb_employee.id = $id;";        
        }
        $respons = array(); 
        $resultdata = mysqli_query($connection, $querysql); 

        while ($row = mysqli_fetch_assoc($resultdata)) { 
            $respons[] = $row;
        }
        header("Content-Type:application/json");
        echo json_encode($respons); 
    }

    function insert_employee()
    {
        global $connection;
        $data = json_decode(file_get_contents("php://input"), true); 
        $employeename = $data['employee_name']; 
        $employeesalary = $data['employee_salary'];
        $employeeage = $data['employee_age'];
        $querysql = "INSERT INTO `tb_employee` (`id`, `employee_name`, `employee_salary`, `employee_age`) VALUES (NULL, '$employeename', '$employeesalary', '$employeeage');";
        if (mysqli_query($connection, $querysql)) {
            $respons = array('status' => 1, 'status_message' => 'Employee Added Succesfully');
        } else {
            $respons = array('status' => 0, 'status_message' => 'Employee Added Failed');
        }
        header('Content-Type:application/json');
        echo json_encode($respons);
    }

    function update_employe($id) 
    {
        global $connection;
        $varpost = json_decode(file_get_contents("php://input"), true);
        $employeename = $varpost['employee_name']; 
        $employeesalary = $varpost['employee_salary'];
        $employeeage = $varpost['employee_age'];
        $querysql = "UPDATE `tb_employee` SET `employee_name` = '$employeename', `employee_salary` = '$employeesalary', `employee_age` = '$employeeage' WHERE `tbl_employee`.`ID` = $id;";
        if (mysqli_query($connection, $querysql)) {
            $respons = array('status' => 1, 'status_message' => 'Employee Update Succesfully');
        } else {
            $respons = array('status' => 0, 'status_message' => 'Employee Update Failed');
        }
        header("Content-Type:application/json");
        echo json_encode($respons);
    }

    function delete_employe($id) 
    {
        global $connection;
        $querysql = "DELETE FROM `tb_employee` WHERE `tb_employee`.`id` = $id";
        if (mysqli_query($connection, $querysql)) {
            $respons = array('status' => 1, 'status_message' => 'Employee Delete Succesfully');
        } else {
            $respons = array('status' => 0, 'status_message' => 'Employee Delete Failed');
        }
        header("Content-Type:application/json");
        echo json_encode($respons);
    }
    
?>