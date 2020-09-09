<?php
$message = '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width"/>
</head>
<body>
<table class="body-wrap" style="width: 100% !important;height: 100%;background: #efefef;-webkit-font-smoothing: antialiased;-webkit-text-size-adjust: none;">
    <tr>
        <td class="container" style="display: block !important;clear: both !important;margin: 0 auto !important;max-width: 580px !important;box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);">

            <table style="width: 100% !important;border-collapse: collapse;">
                <tr>
                   <td align="center" class="masthead" style="padding: 80px 50px;color: white;">
                       <img src="https://www.scandin-africa.com/img/logo.png" width="100%" alt="logo">
                    </td>
                </tr>
                <tr>
                    <td class="content" style="background: white;padding: 30px 35px;">

                        <h2 style="font-family: \'Avenir Next\', \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif;margin-bottom: 20px;line-height: 1.25;font-size: 28px;">Welcome to Scandin-Africa</h2>

                        <p style="font-family: \'Avenir Next\', \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif;font-size: 16px;font-weight: normal;margin-bottom: 20px;">Your account is almost ready! Activate your account by pressing the button below:</p>

                        <table style="width: 100% !important;border-collapse: collapse;">
                            <tr>
                                <td align="center">
                                    <p style="font-family: \'Avenir Next\', \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif;font-size: 16px;font-weight: normal;margin-bottom: 20px;">
                                        <a href="http://scandin-africa.com/activate.php?code=' . $unique . '" class="button" style="font-family: \'Avenir Next\', \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif;display: inline-block;color: white;background: #2B4093;border: solid #2B4093;border-width: 10px 20px 8px;font-weight: bold;border-radius: 4px;box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);text-decoration: none;">Activate your account</a>
                                    </p>
                                </td>
                            </tr>
                        </table>

                        <p style="font-family: \'Avenir Next\', \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif;font-size: 10px;font-weight: normal;margin-bottom: 20px;">If the activation button is not visibile, you can use the following link to activate your account: <a href="http://scandin-africa.com/activate.php?code=' . $unique . '" style="font-family: \'Avenir Next\', \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif;color: #2B4093;text-decoration: none;">http://scandin-africa.com/activate.php?code=' . $unique . '</a></p>

                        <p style="font-family: \'Avenir Next\', \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif;font-size: 16px;font-weight: normal;margin-bottom: 20px;">Madeleine Taylor</em></p>

                    </td>
                </tr>
            </table>

        </td>
    </tr>
    <tr>
        <td class="container" style="display: block !important;clear: both !important;margin: 0 auto !important;max-width: 580px !important;">

            <table style="width: 100% !important;border-collapse: collapse;">
                <tr>
                    <td class="content footer" align="center" style="background: none;padding: 30px 35px;">
                        <p style="font-family: \'Avenir Next\', \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif;margin-bottom: 0;color: #888;text-align: center;font-size: 14px;">Sent by <a href="http://scandin-africa.com/" style="font-family: \'Avenir Next\', \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif;color: #888;text-decoration: none;font-weight: bold;">Scandin-Africa</a></p>
                        <p style="font-family: \'Avenir Next\', \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif;margin-bottom: 0;color: #888;text-align: center;font-size: 14px;"><a href="mailto:" style="font-family: \'Avenir Next\', \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif;color: #888;text-decoration: none;font-weight: bold;">webmaster@scandin-africa.com</a></p>
                    </td>
                </tr>
            </table>

        </td>
    </tr>
</table>
</body>
</html>
';

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'From: <no-reply@scandin-africa.com>' . "\r\n";

mail(
	$usn,
	"Please complete your Scandin-Africa signup",
	$message,
	$headers
);
?>