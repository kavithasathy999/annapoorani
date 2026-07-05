<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Contact Form Message</title>
</head>
<body style="margin: 0; padding: 0; background-color: #fcfcfc; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #333333;">

    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #fcfcfc; padding: 40px 0;">
        <tr>
            <td align="center">
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width: 600px; background-color: #ffffff; border: 1px solid #eeeeee; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
                    
                    <!-- Header Logo -->
                    <tr>
                        <td align="center" style="padding: 40px 40px 20px 40px;">
                            <a href="{{ env('MAIN_URL', url('/')) }}" style="text-decoration: none; border: none; display: inline-block;">
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
                        <td style="padding: 30px 40px;">
                            @if($role === 'user')
                                <h2 style="color: #0c689b; font-size: 20px; font-weight: bold; margin-top: 0;">Thank You! Your Message has been Received!</h2>
                                <p style="font-size: 15px; margin-bottom: 20px;">Dear <strong>{{ $enquiry->name }}</strong>,</p>
                                <p style="font-size: 14px; line-height: 1.6; color: #555555; margin-bottom: 30px;">
                                    We have received your message submission.
                                </p>
                            @else
                                <h2 style="color: #0c689b; font-size: 20px; font-weight: bold; margin-top: 0;">New Contact Form Submission Received!</h2>
                                <p style="font-size: 15px; margin-bottom: 20px;">Dear Admin,</p>
                                <p style="font-size: 14px; line-height: 1.6; color: #555555; margin-bottom: 30px;">
                                    A new message has been submitted via the contact form on the website.
                                </p>
                            @endif

                            <h3 style="font-size: 16px; font-weight: bold; margin-bottom: 15px; color: #000000;">Message Details</h3>
                            
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-size: 14px; line-height: 1.8; color: #333333;">
                                <tr>
                                    <td width="30%" style="font-weight: bold; padding-bottom: 10px;">&bull; Name:</td>
                                    <td width="70%" style="padding-bottom: 10px; color: #555555;">{{ $enquiry->name }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold; padding-bottom: 10px;">&bull; Email:</td>
                                    <td style="padding-bottom: 10px; color: #555555;">{{ $enquiry->email }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold; padding-bottom: 10px;">&bull; Phone:</td>
                                    <td style="padding-bottom: 10px; color: #555555;">{{ $enquiry->phone ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold; padding-bottom: 10px; vertical-align: top;">&bull; Message:</td>
                                    <td style="padding-bottom: 10px; color: #555555;">{{ $enquiry->message }}</td>
                                </tr>
                            </table>

                        </td>
                    </tr>
                    
                    <!-- Footer Content -->
                    <tr>
                        <td style="padding: 0 40px 40px 40px;">
                            <p style="font-size: 13px; color: #777777; line-height: 1.5; margin-top: 20px; margin-bottom: 25px;">
                                If you have any queries, feel free to contact us at 
                                <a href="mailto:{{ env('ADMIN_EMAIL', 'care@SriShyamcrackers.com') }}" style="color: #0066cc; text-decoration: none;">{{ env('ADMIN_EMAIL', 'care@SriAnnapooraniCrackers.com') }}</a>
                            </p>
                            
                            <p style="font-size: 14px; color: #555555; margin-bottom: 5px;">Thank you,</p>
                            <p style="font-size: 15px; font-weight: bold; color: #0c689b; margin: 0;">SRI ANNAPOORANI Crackers</p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>
