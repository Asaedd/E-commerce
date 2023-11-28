<?php

require_once '../../Models/mechanic.php';
require_once '../../Controllers/dbController.php';
class AuthController
{
    protected $db;

    
    
    
//     public function login(operator $operator)
//     {
//        $this->db= new dbController; 
//        if($this->db->openConnection())
//        {
//             //$query="select * from operator where name='$operator->username' and password ='$operator->password'";
//             $query = "SELECT * FROM `operator`\n"
//           . "JOIN mechanic\n"
//           . "ON operator.operator_id = mechanic.operator_id\n"
//           . "WHERE operator.name='$operator->username';";
//             $result=$this->db->select($query);
//             if($result===false)
//             {
//                //echo "You have entered a wrong username or password";
//                return false;
//             }
//             else
//             {
//                if(count($result)==0)
//                {
//                    // echo "you have entered wrong data";
//                     session_start();
//                     $_SESSION["errMsg"]="you have entered wrong data";
//                     return false;
//                }
//                else
//                {
//                     //echo "Hello ya ba4a ";
//                     session_start();
//                     $_SESSION["operator_id"]=$result[0]["operator_id"];
//                     $_SESSION["name"]=$result[0]["name"];
//                     $_SESSION["email"]=$result[0]["email"];
//                     $_SESSION["password"]=$result[0]["password"];
//                     $_SESSION["role_id"]=$result[0]["role_id"];
//                     $_SESSION["mechanic_id"]=$result[0]["mechanic_id"];
//                     $_SESSION["phone_no"]=$result[0]["phone_no"];
//                     $_SESSION["location"]=$result[0]["location"];
//                     //print_r($result);
//                     return true;
//                }
//             }   
     
//        }
//        else
//        {
//             echo "Error in connection to database";
//             return false;
//        }
//     }


    public function login(operator $operator)
    {
       $this->db= new dbController; 
       if($this->db->openConnection())
       {
            //$query="select * from operator where name='$operator->username' and password ='$operator->password'";
            $query = "SELECT * FROM `operator`\n"
          . "JOIN mechanic\n"
          . "ON operator.operator_id = mechanic.operator_id\n"
          . "WHERE operator.name='$operator->username';";
            $result=$this->db->select($query);
            
            $query1 = "SELECT * FROM `operator`\n"
          . "JOIN admin\n"
          . "ON operator.operator_id = admin.operator_id\n"
          . "WHERE operator.name='$operator->username';";
            $result1=$this->db->select($query1);

            $query2 = "SELECT * FROM `operator`\n"
          . "JOIN user\n"
          . "ON operator.operator_id = user.operator_id\n"
          . "WHERE operator.name='$operator->username';";
            $result2=$this->db->select($query2);

            if($result)
            {
                    //echo "Hello ya ba4a ";
                    session_start();
                    $_SESSION["operator_id"]=$result[0]["operator_id"];
                    $_SESSION["name"]=$result[0]["name"];
                    $_SESSION["email"]=$result[0]["email"];
                    $_SESSION["password"]=$result[0]["password"];
                    $_SESSION["role_id"]=$result[0]["role_id"];
                    $_SESSION["phone_no"]=$result[0]["phone_no"];
                    $_SESSION["location"]=$result[0]["location"];
                    $_SESSION["rating"]=$result[0]["rating"];
                    $_SESSION["mechanic_id"]=$result[0]["mechanic_id"];
                    //print_r($result);
                    return true;
            }
           
            elseif($result1)
            {
                    //echo "Hello ya ba4a ";
                    session_start();
                    $_SESSION["operator_id"]=$result1[0]["operator_id"];
                    $_SESSION["name"]=$result1[0]["name"];
                    $_SESSION["email"]=$result1[0]["email"];
                    $_SESSION["password"]=$result1[0]["password"];
                    $_SESSION["role_id"]=$result1[0]["role_id"];
                    $_SESSION["phone_no"]=$result1[0]["phone_no"];
                    $_SESSION["location"]=$result1[0]["location"];
                    //$_SESSION["mechanic_id"]=$result1[0]["mechanic_id"];
                    //print_r($result);
                    return true;
               }

               elseif($result2)
                {
                    //echo "Hello ya ba4a ";
                    session_start();
                    $_SESSION["operator_id"]=$result2[0]["operator_id"];
                    $_SESSION["name"]=$result2[0]["name"];
                    $_SESSION["email"]=$result2[0]["email"];
                    $_SESSION["password"]=$result2[0]["password"];
                    $_SESSION["role_id"]=$result2[0]["role_id"];
                    $_SESSION["phone_no"]=$result2[0]["phone_no"];
                    $_SESSION["location"]=$result2[0]["location"];
                    //$_SESSION["mechanic_id"]=$result1[0]["mechanic_id"];
                    //print_r($result);
                    return true;
               }
            else
            echo "error";
     
       }
    }
}
?>

