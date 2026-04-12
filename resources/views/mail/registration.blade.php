<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Complete Your Registration</title>
    <link href="https://fonts.googleapis.com/css2?family=Chelsea+Market&family=Saira+Stencil:wght@400;700&display=swap"
        rel="stylesheet" />
</head>

<body style="margin:0;padding:0;background-color:#e8f2ff;color:#030267;font-family:'Saira Stencil',Arial,sans-serif;">

    <!-- Header -->
    <div
        style="background-color:#f3f8ff;box-shadow:0 1px 3px 0 rgba(0,0,0,0.1),0 1px 2px -1px rgba(0,0,0,0.1);padding:0 20px;">
        <table width="100%" cellpadding="0" cellspacing="0" style="max-width:600px;margin:0 auto;">
            <tr>
                <td style="padding:20px 0;height:70px;vertical-align:middle;">
                    <span
                        style="font-family:'Chelsea Market',Georgia,serif;font-size:30px;color:#030267;letter-spacing:0.05em;">The
                        Real Deal</span>
                </td>
            </tr>
        </table>
    </div>

    <!-- Content -->
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" style="padding:40px 20px;">
                <table width="100%" cellpadding="0" cellspacing="0" style="max-width:560px;">

                    <!-- Card -->
                    <tr>
                        <td
                            style="background-color:#f3f8ff;border-radius:12px;padding:32px;box-shadow:0 1px 3px 0 rgba(0,0,0,0.3),0 1px 2px -1px rgba(0,0,0,0.3);">

                            <h1
                                style="font-family:'Chelsea Market',Georgia,serif;font-size:26px;color:#030267;margin:0 0 8px 0;letter-spacing:0.05em;">
                                Welcome to The Real Deal!
                            </h1>

                            <p
                                style="margin:0 0 24px 0;font-size:14px;color:#030267;opacity:0.75;letter-spacing:0.03em;">
                                You're one step away from completing your registration.
                            </p>

                            <hr style="border:none;border-top:1px solid #030267;opacity:0.15;margin:0 0 24px 0;" />

                            <p style="margin:0 0 16px 0;font-size:15px;line-height:1.6;letter-spacing:0.03em;">
                                Thanks for signing up! To finish setting up your account, click the button below to
                                continue with the next registration steps.
                            </p>

                            <p style="margin:0 0 28px 0;font-size:15px;line-height:1.6;letter-spacing:0.03em;">
                                This link will expire in <strong>24 hours</strong>.
                            </p>

                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="right">
                                        <a href="{{ $verificationUrl }}"
                                            style="display:inline-block;font-family:'Saira Stencil',Arial,sans-serif;font-size:16px;font-weight:bold;letter-spacing:0.05em;padding:12px 28px;background-color:#059669;color:#ffffff;border-radius:8px;text-decoration:none;">
                                            Continue Registration
                                        </a>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>

                    <!-- Spacer -->
                    <tr>
                        <td style="height:24px;"></td>
                    </tr>

                    <!-- Footer note -->
                    <tr>
                        <td
                            style="font-size:12px;color:#030267;opacity:0.5;text-align:center;letter-spacing:0.03em;line-height:1.6;">
                            If you didn't create an account, you can safely ignore this email.<br />
                            If the button doesn't work, copy and paste this link into your browser:<br />
                            <span style="word-break:break-all;">{{ $verificationUrl }}</span>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>

</html>
