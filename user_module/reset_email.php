<?php

$emailBody = '
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
                            <img src="' . $resetImage . '" height="200px" style="display:block; margin:auto;padding-bottom: 25px; ">
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center;" colspan="2">
                            <br>
                            <h1 style="margin: 0px;padding-bottom: 25px;font-size:22px;"> Reset Your Password </h1>
                            <p style=" margin: 0px 40px;padding-bottom: 25px;line-height: 2; font-size: 15px;">
                                We\'ve recieved a request to reset the password for the Smart Allocation System accout associated with ' . $email . '
                                You can reset your password by clicking the link blow.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <a href="' . $returnLink . '" style="background-color:#36b445; color:white; padding:15px 62px; outline: none; display: block; margin: auto; border-radius: 31px;
                                font-weight: bold; text-decoration: none; margin-top: 25px; margin-bottom: 25px; border: none; text-transform:uppercase; width: 170px; text-align: center;">
                                Reset Password
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center; padding:15px" colspan="2">
                            <b>
                                if you did not request a new password, Please let us know immediately.<br> Thank you.
                            </b>
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

return $emailBody;
