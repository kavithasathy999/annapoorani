<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Your OTP Code</title>
</head>
<body style="margin: 0; padding: 0; background-color: #fcfcfc; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #333333;">

    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #fcfcfc; padding: 40px 0;">
        <tr>
            <td align="center">
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width: 600px; background-color: #ffffff; border: 1px solid #eeeeee; box-shadow: 0 4px 10px rgba(0,0,0,0.05); border-radius: 8px; overflow: hidden;">
                    
                    <!-- Header Logo -->
                    <tr>
                        <td align="center" style="padding: 40px 40px 20px 40px;">
                            <a href="{{ config('services.asset_base_url', url('/')) }}" style="text-decoration: none; border: none; display: inline-block;">
                                <img src="{{ $message->embed(base_path('../api/annapooranilogo.png')) }}" alt="Logo" style="max-width: 280px; display: block; border: none; outline: none;" />
                            </a>
                        </td>
                    </tr>
                    
                    <!-- Divider -->
                    <tr>
                        <td style="padding: 0 40px;">
                            <div style="border-top: 1px solid #eeeeee;"></div>
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td style="padding: 30px 40px; text-align: center;">
                            <h2 style="color: #0c689b; font-size: 24px; font-weight: bold; margin-top: 0; margin-bottom: 20px;">Verification Code</h2>
                            
                            <p style="font-size: 15px; line-height: 1.6; color: #555555; margin-bottom: 30px;">
                                You have requested to proceed to checkout. Please use the following One-Time Password (OTP) to verify your request.
                            </p>

                            <div style="background-color: #f4f1ea; border: 2px dashed #043048; border-radius: 12px; padding: 25px; margin-bottom: 30px; display: inline-block; min-width: 200px;">
                                <div style="font-size: 42px; font-weight: bold; letter-spacing: 12px; color: #101010;">
                                    {{ $otp }}
                                </div>
                            </div>
                            
                            <p style="font-size: 13px; color: #888888; margin-bottom: 0;">
                                This OTP is valid for 10 minutes. If you did not request this, please ignore this email.
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Footer Content -->
                    <tr>
                        <td style="padding: 0 40px 40px 40px; text-align: center;">
                            <p style="font-size: 14px; color: #555555; margin-bottom: 5px;">Thank you,</p>
                            <p style="font-size: 15px; font-weight: bold; color: #4a2b75; margin: 0;">SRI ANNAPOORANI CRACKERS</p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>
