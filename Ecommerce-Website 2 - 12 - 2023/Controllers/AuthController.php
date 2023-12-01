<?php
require_once 'Controllers/dbController.php';
class AuthController
{
    protected $db;
    public function login(customer $customer)
    {
       $this->db= new dbController; 
       if($this->db->openConnection())
       {
            //$query="select * from operator where name='$operator->username' and password ='$operator->password'";
            //USER CASE
            $query = "SELECT * FROM `customer` WHERE customer.Email='$customer->Email' AND customer.Password='$customer->Password'";
            $result = $this->db->select($query, array($customer->Email, $customer->Password));

            
          //   //ADMIN CASE
          //   $query1 = "SELECT * FROM `customer`\n"
          // . "JOIN admin\n"
          // . "ON operator.operator_id = admin.operator_id\n"
          // . "WHERE operator.name='$operator->username';";
          //   $result1=$this->db->select($query1);

            if($result)
            {
                    //echo "Hello ya ba4a ";
                    session_start();
                    $_SESSION["CustomerId"]=$result[0]["CustomerId"];
                    $_SESSION["Name"]=$result[0]["Name"];
                    $_SESSION["Email"]=$result[0]["Email"];
                    $_SESSION["password"]=$result[0]["password"];
                    $_SESSION["phone_no"]=$result[0]["phone_no"];
                    // print_r($result);
                    return true;
            }
       }
    }
    public function signUp(customer $customer)
    {
        $this->db = new dbController;
    
        if ($this->db->openConnection()) {
            // Check if the email is already registered
            if ($this->checkEmailExists($customer->Email)) {
                // Email already exists, handle accordingly (e.g., return an error)
                return false;
            }
    
            // Email is not registered, proceed with the signup
            $query = "INSERT INTO `customer` (`Name`, `Email`, `Password`, `Phone`) VALUES (?, ?, ?, ?)";
            $hashedPassword = password_hash($customer->Password, PASSWORD_DEFAULT);
            $success = $this->db->insert($query, array($customer->Name, $customer->Email, $hashedPassword, $customer->phoneNumber));
    
            if ($success) {
                // Registration successful
                session_start();
                $_SESSION["CustomerId"] = $this->db->lastInsertId();
                $_SESSION["Name"] = $customer->Name;
                $_SESSION["Email"] = $customer->Email;
                echo "success";
                return true;
            }
        }
        return false; // Something went wrong
    }
}
?>

