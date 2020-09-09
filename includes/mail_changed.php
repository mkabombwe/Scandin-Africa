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

                        <h2 style="font-family: \'Avenir Next\', \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif;margin-bottom: 20px;line-height: 1.25;font-size: 28px;">Your email has been changed</h2>

                        <p style="font-family: \'Avenir Next\', \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif;font-size: 16px;font-weight: normal;margin-bottom: 20px;">Your email has been changed. You did this, please ignore this email. If you did not do this, please contact the Scandin-Africa support team.</p>

                        <p style="font-family: \'Avenir Next\', \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif;font-size: 16px;font-weight: normal;margin-bottom: 20px;"><em>&#45; Scandin-Africa</em></p>

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
	$username,
	"Your email has been changed",
	$message,
	$headers
);
?>