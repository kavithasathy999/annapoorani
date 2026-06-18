<!DOCTYPE html>
<html>
<head>
    <title>New Contact Enquiry</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <h2 style="color: #2b6df6;">New Contact Form Submission</h2>
    <p>You have received a new enquiry from the website contact form.</p>
    
    <table style="width: 100%; max-width: 600px; border-collapse: collapse;">
        <tr>
            <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold; width: 120px;">Name:</td>
            <td style="padding: 10px; border: 1px solid #ddd;">{{ $enquiry->name }}</td>
        </tr>
        <tr>
            <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold;">Email:</td>
            <td style="padding: 10px; border: 1px solid #ddd;">{{ $enquiry->email }}</td>
        </tr>
        <tr>
            <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold;">Phone:</td>
            <td style="padding: 10px; border: 1px solid #ddd;">{{ $enquiry->phone ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold;">Message:</td>
            <td style="padding: 10px; border: 1px solid #ddd;">{!! nl2br(e($enquiry->message)) !!}</td>
        </tr>
    </table>
    
    <p style="margin-top: 20px; font-size: 12px; color: #888;">This email was automatically generated from your website.</p>
</body>
</html>
