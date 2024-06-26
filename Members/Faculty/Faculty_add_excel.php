<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/LibraryManagement/vendor/autoload.php');
include "../../connection/dbconnect.php";

$sql_delete = "DELETE from `insert buffer`;";
$result=$conn->query($sql_delete);

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

$flag = 1;
$targetPath = $_SERVER['DOCUMENT_ROOT'] . '/LibraryManagement/Doc/faculty.xlsx';


$Reader = new Xlsx();
$spreadSheet = $Reader->load($targetPath);
$excelSheet = $spreadSheet->getActiveSheet();
$spreadSheetAry = $excelSheet->toArray();
$sheetCount = count($spreadSheetAry);
$incorrect_rows = "";
$already_exist=0;
for ($i = 1; $i < $sheetCount; $i++) 
{

    $fac_id = $spreadSheetAry[$i][0];
    $fac_id=preg_replace('/[^A-Za-z0-9\-]/', '', $fac_id);
    $fac_name = $spreadSheetAry[$i][1];
    $fac_type = $spreadSheetAry[$i][2];
    $id_check = "SELECT * FROM faculty where Faculty_ID='$fac_id';";
    $result_check = $conn->query($id_check);
    if (mysqli_num_rows($result_check) > 0) 
    {

        echo "
            <div id='dialog_exl_faculty' style='color:red;' title='Member Already Exist'>
                <p><center>$fac_id  member already exists</center></p>
            </div>
            ";
            $already_exist=1;
        break;
    }
    if (!empty($fac_id) && !empty($fac_name) && !empty($fac_type)) 
    {
        $sql = "INSERT INTO `insert buffer` (id,val1,val2,val3) VALUES ($i,'$fac_id','$fac_name','$fac_type');";
        $result = $conn->query($sql);
    } else 
    {
        $incorrect_rows = $incorrect_rows . " $i";
    }
}
// print confirmation table and user confirm button ---zakie
if (strlen($incorrect_rows) == 0 && $already_exist==0) 
{
    echo "
    <style>
    .gola::-webkit-scrollbar {
        display: none; 
      }
    </style>
        <br/>
        <br/>
        <br/>
        <br/>
        <center>
            <h1 style='font-weight:bold;color:white;position:relative;'>Faculty Confirmation Page</h1><br/>
            <div class='gola' style='height:50vh;overflow:auto;'>
                <table style='background-color:black;width:80vh;'>
                    <tr>
                        <th colspan='4'>
                            <center>
                            <h2 style='color:white;'>
                                Are You Sure You want to Submit?
                            </h2>
                            </center>
                        </th>
                    </tr>
                    <tr>
                        <th>No.</th>
                        <th>Facluty ID</th>
                        <th>Faculty Name </th>
                        <th>Faculty Type</th>
                    </tr>
                    
                    <tbody>
                    
        
        ";

        for ($i = 1; $i < $sheetCount; $i++)
        {
            $fac_id = $spreadSheetAry[$i][0];
            $fac_id=preg_replace('/[^A-Za-z0-9\-]/', '', $fac_id);
            $fac_name = $spreadSheetAry[$i][1];
            $fac_type = $spreadSheetAry[$i][2];
            echo"
                        <tr>
                            <th style='color:white;'>$i</th>
                            <th style='color:white;'>$fac_id</th>
                            <th style='color:white;'>$fac_name</th>
                            <th style='color:white;'>$fac_type</th>
                        </tr>";
        }
        echo"
                    
                    </tbody>
                    
                </table>
            </div>
            <br/>
            <div style='display:inline-flex;'>
                <form id='fac_buffer' method='post' action=''>
                    <button class='btn' type='submit' id='upload-button' style='color:aliceblue;background-color:black;'> Confirm </button>
                </form> &nbsp;&nbsp;&nbsp;
                <form id='buff_back' method='post' action=''>
                    <button id='backissue' class='btn' style='font-weight: bold;background-color: #520702;color: aliceblue;'>Back</button>
                </form>
            </div>
        </center>


        <script>
        $(document).ready(function()
        {
            
            $('#buff_back').click(function(e)
            {
                $.ajax({

                    method: 'post',
                    url: './Members/Faculty/Faculty_empty_buffer.php',
                    error: function()
                    {
                        alert('Some Error Occurred!!!');
                    }
                })
            })
            
            $('#fac_buffer').click(function(e)
            {
                
                $.ajax({
                    
                    method: 'post',
                    url: './Members/Faculty/Faculty_insert_buffer.php',
                    data:'hi',
                    datatype:'text',
                    error: function()
                    {
                        alert('Some Error Occurred!!!');
                    },
                    success: function(Result)
                    {
                        
                        $('#dialog_student_excel').dialog('destroy');
                        $('#response_student_excel').html(Result);
                        $('#dialog_student_excel').dialog();
                        
                    }
                }) 
            })
        })
        </script>
        ";
}
else
{
    if (strlen($incorrect_rows) > 0) 
    {
        echo "
            <div id='dialog_exl_faculty' style='color:green;' title='✅Successful'>
                <p><center>$incorrect_rows rows not inserted. Rest Inserted</center></p>
            </div>
            ";
    } 
    else 
    {
        echo "
            <div id='dialog_exl_faculty' style='color:green;' title='✅Successful'>
                <p><center>$conn->error</center></p>
            </div>
            ";
    }

}
