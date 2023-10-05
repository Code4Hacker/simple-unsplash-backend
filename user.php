<?php 
   include_once("connector.php");

   if(!$connection){
      echo json_encode(array("connection status" => "Failed"));
   }else{
     switch($_SERVER['REQUEST_METHOD']){
        case 'GET':
            $sql_queries = "SELECT userID, userName, photo, email FROM USERS ORDER BY userID DESC";
            $results = $connection -> query($sql_queries);

            if($results){
               $getdata = array();

               while($row = $results -> fetch_assoc()){
                 $getdata[] = $row;
               }
               echo json_encode(array("status" => "200","users" => $getdata));
            }else{
                echo json_encode(array("status" => "404"));
            }
            $connection -> close();
            break;
        case 'POST':
            $username = $_POST['username'];
            $photo = $_FILES['image'];
            $email = $_POST['email'];
            $code = $_POST['pass'];

            $username = str_replace("'","\'", $username);
            $email = str_replace("'","\'", $email);
            $code = str_replace("'","\'", $code);
            $destine = "profiles/PRF_".rand().".".pathinfo($photo['name'], PATHINFO_EXTENSION);

            $getemail = "SELECT email FROM USERS WHERE email = '$email'";
            $responses = $connection -> query($getemail);

            if($responses -> num_rows == 1){
                echo json_encode(array("status" => "400", "message" => "Users with such Email already Exist"));
            }else{
                if(!empty($username) && !empty($photo) && !empty($email) && !empty($code)){
                    if(move_uploaded_file($photo['tmp_name'], $destine)){
                        $sql_queries = "INSERT INTO USERS (userName, photo, email, passcode) VALUES ('$username','/$destine', '$email', '$code')";
                    $results = $connection -> query($sql_queries);
        
                    if($results){
                        echo json_encode(array("status" => "200", "message" => "Posted Successiful"));
                    }else{
                        echo json_encode(array("status" => "500", "message" => "Posted UnSuccessiful"));
                    }
                    }
                }else{
                    echo json_encode(array("status" => "300", "message" => "Fill the Blanks"));
                }
            }
            $connection -> close();
            break;
        case 'PATCH':
            $json = file_get_contents("php://input");
            $patch = json_decode($json, true);

            $username = $patch['username'];
            $id = $patch['id'];
            $email = $patch['email'];
            $code = $patch['pass'];

            $username = str_replace("'","\'", $username);
            $email = str_replace("'","\'", $email);
            $code = str_replace("'","\'", $code);
            $id = str_replace("'","\'", $id);

            $getemail = "SELECT email FROM USERS WHERE userID = '$id'";
            $responses = $connection -> query($getemail);

            if($responses -> num_rows == 0){
                echo json_encode(array("status" => "400", "message" => "Users Not Exist"));
            }else{
                if(!empty($username) && !empty($id) && !empty($email) && !empty($code)){
                  $db_email = $responses -> fetch_column();
                  if($email == $db_email){
                    $update_db = "UPDATE USERS SET userName = '$username', passcode = '$code' WHERE  userID = '$id'";
                    $results = $connection -> query($update_db);
                  }else{
                    $mail = $email;
                    $update_db = "UPDATE USERS SET userName = '$username', email = '$mail', passcode = '$code' WHERE  userID = '$id'";
                    $results = $connection -> query($update_db);
                  }

                  if($results){
                    echo json_encode(array("status" => "200", "message" => "Update Successiful"));
                  }else{
                    echo json_encode(array("status" => "500", "message" => "Update UnSuccessiful"));
                  }

                }else{
                    echo json_encode(array("status" => "300", "message" => "Fill the Blanks"));
                }
            }
            $connection -> close();
            break;
        case 'DELETE':
            $json_code = file_get_contents("php://input");

            $id = json_decode($json_code, true)['id'];
            if(!empty($id)){
                $sql_delete = "DELETE FROM USERS WHERE userID = '$id'";

                $resp = $connection -> query($sql_delete);

                if($resp){
                    echo json_encode(array("status" => "200", "message" => "User with id ".$id.". Has been Deleted"));
                }else{
                    echo json_encode(array("status" => "500", "message" => "Something Wrong"));
                }
            }else{
                echo json_encode(array("status" => "400", "message" => "Fill the blank"));
            }
            $connection -> close();
            break;
        default:
           echo json_encode(array("Method" => "No Method Found"));
           break;
     }
   }
?>






