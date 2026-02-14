<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div>
        @if($recipientName)
            <p>Hello {{ $recipientName }},</p>
        @endif
        <p>{{ nl2br(e($body)) }}</p>
    </div>
    <div style="padding-top: 20px; margin-top: 20px; border-top: 1px solid #eee;">
        <p style="margin: 0; font-size: 12px; color: #666;">Socrate Management System (SOMS)</p>
    </div>
</body>
</html>
