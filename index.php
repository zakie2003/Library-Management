<?php
@session_start();
$_SESSION["File"] = "Index.php";
?>
<!DOCTYPE html>
<html lang="en">   
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library</title>
    <link rel="stylesheet" href="Assets\\css\\bootstrap.css">
    <link rel="stylesheet" href="./jquery-ui-1.13.2.custom/jquery-ui.css">
    <link rel="stylesheet" href="./jquery-ui-1.13.2.custom/jquery-ui.structure.css">
    <link rel="stylesheet" href="./jquery-ui-1.13.2.custom/jquery-ui.theme.css">
    <link rel="stylesheet" href="./Assets/css/style.css">
    <script src="./jquery-ui-1.13.2.custom/jquery-ui.min.js"></script>
</head>
<body>
<div style="background-color: #783E12;">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <!-- Left Logo and Title -->
            <div class="col-12 col-md-4 text-center text-md-start heading_sub">
                <img src="Assets/img/iips_logo2.png" alt="logo" width="100" height="100" class="img-fluid d-none d-md-block"/>
                <div class="mt-2 d-none d-md-block" style="text-align: left; font-family:product; font-size:x-large; color:#ffffff;">
                    International Institute<br> of Professional Studies
                </div>
            </div>

            <!-- Center Library Title and Buttons -->
            <div class="col-12 col-md-4 d-flex flex-column align-items-center my-3 my-md-0">
                <div style="font-family: product_bold; font-size:x-large; color:#ffffff;">Library</div>
                <button type="button" id="Student" value="Student" class="btn btn-outline-primary mt-2">Student</button>
                <form id="logout" method="post" action="Auth/Logout.php" style="display:none;">
                    <input style="border-color:#ffffff;" type="submit" id="logoutbtn" value="Logout" class="btn btn-outline-danger mt-2"/>
                </form>
            </div>

            <!-- Right Logo and Title -->
            <div class="col-12 col-md-4 text-center text-md-end heading_sub">
                <div class="text-end d-none d-md-block" style="text-align: right; font-family:product; color:#ffffff; font-size:x-large;">
                    Devi Ahilya<br> Vishva Vidyalaya
                </div>
                <img src="Assets/img/Davv_Logo.png" alt="logo" width="100" height="100" class="img-fluid d-none d-md-block"/>
            </div>
        </div>
    </div>
</div>



    <div id="contain">
        <div class="dabbe">
            <div class="dabbe_ka_dabba">
                <div class="dabbe_k_dabbe_ka_dabba">
                    <form id="login" method="post" action="" autocomplete="off">
                        <center>
                            <h1 style="color:#ffffff;">Login Page</h1><br>
                            <label>Username:</label>
                            <input required type="text" name="username" class="form-control" style="background-color:#401B00;width:100%;color:#ffffff;" placeholder="Enter Username"/><br>
                            <label>Password:</label>
                            <input required type="password" name="password" class="form-control" style="background-color:#401B00;width:100%;color:#ffffff;" placeholder="Enter Password"/><br>
                            <input type="submit" class="btn new_css_btn" value="Login"/>
                            <button type="reset" class="btn new_css_btn">Clear</button>
                            <br><br>
                        </center>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="Assets\js\Jquery.js"></script>
<?php

if(!empty($_SESSION["RELOAD"]))
{
    if($_SESSION["RELOAD"] == "reload")
    {
        // $x=$_SERVER["DOCUMENT_ROOT"];
            echo"
            <script>
                $.ajax(
                {
                    method: 'post',
                    url: './Assets/php/Main.php',
                    error: function()
                    {
                        alert('Some Error Occurred!!!');
                    },
                    success: function(Result)
                    {
                        document.querySelector('#Student').style.display='none';
                        document.querySelector('#logout').style.display='block';
                        $('#contain').html(Result);
                    }
                });
            </script>
            ";
    }
}
?>
</body>
<!-- <script src="Assets\\js\\bootstrap.bundle.js"></script>
<script src="Assets\\js\\index.js"></script> -->
<script src="Assets/js/ajaxHandler.js"></script>
<script src="Assets/js/bookIssueForm.js"></script>
<script src="Assets/js/main.js"></script>
</html>



