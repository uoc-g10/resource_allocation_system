<?php
$htmlBody = '
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Name</title>
</head>

<body style="margin-top:20px;margin-bottom:20px">
    <!-- Main table -->
    <table border="0" align="center" cellspacing="0" cellpadding="0" bgcolor="white" width="650">
        <tr>
            <td>
                <!-- Child table -->
                <table border="0" cellspacing="0" cellpadding="0" style="color:#0f3462; font-family: sans-serif;">
                    <!-- <tr>
                        <td colspan="2">
                            <h2 style="text-align:center; margin: 0px; padding-bottom: 25px; margin-top: 25px;">
                                <i>Allocation System UOC (demo)</i>
                            </h2>
                        </td>
                    </tr> -->
                    <tr>
                        <td colspan="2">
                            <img src="' . $registerImage . '" height="200px" style="display:block; margin:auto;padding-bottom: 25px; ">
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center;" colspan="2">
                            <br>
                            <!-- <h1 style="margin: 0px;padding-bottom: 25px; text-transform: uppercase;">Mr. Navod Thilakarathna</h1> -->
                            <h1 style="margin: 0px;padding-bottom: 25px;font-size:22px;"> Your account was successfully created</h1>
                            <p style=" margin: 0px 40px;padding-bottom: 25px;line-height: 2; font-size: 15px;">
                                <b> ' . $lecturerFullName . ', </b><br>
                                You have been successfully admitted to the Lecture Hall Allocation system of the University of Colombo. Now you can do the Lecture Hall Allocation as you see fit. Below are your account details. This will allow you to log in to the system.

                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: right; padding:15px"><b> Login Email </b></td>
                        <td style="padding:15px"> ' . $email . ' </td>
                    </tr>
                    <tr>
                        <td style="text-align: right; padding:15px"><b> Login Password </b></td>
                        <td style="padding:15px"> ' . $password_raw . ' </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <a href="' . $systemUrl . '" style="background-color:#36b445; color:white; padding:15px 62px; outline: none; display: block; margin: auto; border-radius: 31px;
                                font-weight: bold; margin-top: 25px; margin-bottom: 25px; border: none; text-transform:uppercase; width: 129px; text-align: center;">Open System</a>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align:center;" colspan="2">
                            <h2 style="padding-top: 25px; line-height: 1; margin:0px;">Resource Allocation System (demo)</h2>
                            <div style="margin-bottom: 25px; font-size: 15px;margin-top:7px;line-height: 21px;">
                                <b>Mini Project Group No 10 </b><br>
                                Department of ICT, Faculty of Technology, <br>
                                University Of Colombo
                            </div>
                        </td>
                    </tr>
                </table>
                <!-- /Child table -->
            </td>
        </tr>
    </table>
    <!-- / Main table -->
</body>

</html>';

return $htmlBody;
