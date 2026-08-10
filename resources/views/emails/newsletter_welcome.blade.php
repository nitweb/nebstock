<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
</head>

<body style="margin:0;padding:0;background:#f5f5f5;font-family:Arial,sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" style="padding:40px 15px;">

                <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:12px;overflow:hidden;">

                    <!-- Header -->
                    <tr>
                        <td align="center" style="background:#111827;padding:35px;">
                            <h1 style="color:#fff;margin:0;font-size:30px;">
                                Nebstock
                            </h1>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding:40px;">

                            <h2 style="margin-top:0;color:#111827;">
                                Thanks for subscribing 🎉
                            </h2>

                            <p style="font-size:16px;color:#4b5563;line-height:1.7;">
                                Welcome to our newsletter family.
                                You'll now receive updates about:
                            </p>

                            <ul style="color:#4b5563;font-size:15px;line-height:1.8;">
                                <li>New arrivals</li>
                                <li>Exclusive discounts</li>
                                <li>Rare collections</li>
                                <li>Weekly featured products</li>
                            </ul>

                            <div style="text-align:center;margin-top:35px;">
                                <a href="{{ url('/') }}" style="display:inline-block;
                                          background:#111827;
                                          color:#fff;
                                          padding:14px 30px;
                                          text-decoration:none;
                                          border-radius:8px;
                                          font-weight:bold;">
                                    Visit Store
                                </a>
                            </div>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" style="padding:25px;background:#f9fafb;color:#6b7280;font-size:13px;">

                            <p style="margin:0 0 10px;">
                                © {{ date('Y') }} Foreign Ecommerce.
                                All rights reserved.
                            </p>

                            <a href="{{ route('newsletter.unsubscribe', $newsletter->unsubscribe_token) }}" style="font-size:12px;color:#6b7280;text-decoration:none;">
                                Unsubscribe
                            </a>

                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>