<?php
include "../../connection/dbconnect.php";
//include $_SERVER['DOCUMENT_ROOT']."/LibraryManagement/Auth/auth.php";
include "../../Auth/auth.php";
@session_start();
if(empty(!verification() || $_POST["fac_name"]) || empty($_POST["fac_id"]) || empty(filter_input(INPUT_POST,"fac_type"))|| $_POST["Access"] != "Main-Faculty_member_add")
{
    header("Location: /LibraryManagement/");  
}
else
{
    $facName=$_POST["fac_name"];
    $facId=$_POST["fac_id"];
    $facId = strtoupper($facId);
    $facId = preg_replace('/[^A-Za-z0-9]/', '', $facId);
    $facType=filter_input(INPUT_POST,"fac_type");

    $sqlCheck1="SELECT Faculty_ID from faculty where Faculty_ID = '$facId';";
    $sqlCheck2="SELECT Member_ID from member where Member_ID = '$facId';";
    $resultCheck1=$conn->query($sqlCheck1);
    $resultCheck2=$conn->query($sqlCheck2);
    
    
    if($resultCheck1 && $resultCheck2)
    {
        
        if(mysqli_num_rows($resultCheck2)>0)
        {
            echo"
            <div id='dialog-confirm' style='color:red;' title='Not Allowed❌'>
                <p class='notification-message'>Faculty $facId already present!!!  <br>
                If you think this is an issue, Kindly add the Faculty Manually!!!
                </p>
            </div>";
        }
        else
        {
            if(!mysqli_num_rows($resultCheck1)>0)
            {
                $sql1 = "INSERT into faculty(Faculty_ID,Faculty_Name,Faculty_Type) values('$facId','$facName','$facType');";
                $resul1 = $conn->query($sql1);
                if($resul1)
                {
                    $sql2="INSERT into member(Member_ID,MemberType) values('$facId','Faculty');";
                    $result2=$conn->query($sql2);
                    if(! $result2) echo"
                        <div id='dialog-confirm' style='color:red;' title='Error❌'>
                            <p class='notification-message'>$conn->error</p>
                        </div>";
                    else if($result2)
                    {
                        echo "
                            <div id='dialog-confirm' style='color:green;' title='Successful✅'>
                                <p class='notification-success-message'>Faculty $facId added as a member successfully!!!</p>
                            </div>"; 
                    }
                }
                else
                {
                    echo"
                        <div id='dialog-confirm' style='color:red;' title='Error❌'>
                            <p class='notification-message'>$conn->error</p>
                        </div>";
                }
                
            }
            else
            {
                echo "
                <div id='dialog-confirm' style='color:green;' title='Error❌'>
                    <p class='notification-message'>Faculty $facId found in Faculty Table!!</p>
                </div>"; 
            }
        }
    }
    else echo"
            <div id='dialog-confirm' style='color:red;' title='Error❌'>
                <p class='notification-message'>$conn->error</p>
            </div>";

    echo"<script>
            $( function() {
              $( '#dialog-confirm' ).dialog({
                resizable: false,
                height: 'auto',
                width: 400,
                modal: true,
                buttons: {
                  'Ok': function() {
                    $( this ).dialog( 'close' );
                  }
                }
              });
            } );
            </script>";
}
?>