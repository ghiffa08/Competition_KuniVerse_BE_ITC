<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Tiket Kuniverse</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f3f4f6; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; -webkit-font-smoothing: antialiased;">
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f3f4f6; padding: 40px 0;">
        <tr>
            <td align="center">
                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px; background-color: #ffffff; border-radius: 24px; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.08);">
                    
                    {{-- Header Image --}}
                    <tr>
                        <td style="height: 200px; background-image: url('{{ $booking->tourism->image }}'); background-size: cover; background-position: center; position: relative;">
                            <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(to bottom, rgba(0,0,0,0.3), rgba(0,0,0,0.7));"></div>
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="position: relative; height: 100%;">
                                <tr>
                                    <td align="center" valign="middle">
                                        <h1 style="color: #ffffff; margin: 0; font-family: serif; font-size: 32px; letter-spacing: 1px; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">KUNIVERSE</h1>
                                        <p style="color: rgba(255,255,255,0.9); margin: 8px 0 0 0; font-size: 14px; text-transform: uppercase; letter-spacing: 2px;">E-Ticket</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    {{-- Content --}}
                    <tr>
                        <td style="padding: 40px;">
                            <p style="margin: 0 0 24px 0; color: #6b7280; font-size: 16px; text-align: center;">Halo <strong>{{ $booking->user->name }}</strong>, pembayaran Anda berhasil!</p>
                            
                            {{-- Ticket Card --}}
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="border: 1px solid #e5e7eb; border-radius: 16px; overflow: hidden;">
                                <tr>
                                    <td style="padding: 32px; background-color: #f9fafb; border-bottom: 2px dashed #d1d5db;">
                                        <p style="margin: 0 0 8px 0; font-size: 12px; color: #9ca3af; text-transform: uppercase; letter-spacing: 1px;">Destination</p>
                                        <h2 style="margin: 0; color: #111827; font-size: 24px;">{{ $booking->tourism->name }}</h2>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 32px; background-color: #ffffff;">
                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tr>
                                                <td width="50%" style="padding-bottom: 24px;">
                                                    <p style="margin: 0 0 4px 0; font-size: 11px; color: #9ca3af; text-transform: uppercase;">Date</p>
                                                    <p style="margin: 0; font-size: 16px; font-weight: 600; color: #374151;">{{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('d M Y') }}</p>
                                                </td>
                                                <td width="50%" style="padding-bottom: 24px;">
                                                    <p style="margin: 0 0 4px 0; font-size: 11px; color: #9ca3af; text-transform: uppercase;">Visitors</p>
                                                    <p style="margin: 0; font-size: 16px; font-weight: 600; color: #374151;">{{ $booking->quantity }} Orang</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="50%">
                                                    <p style="margin: 0 0 4px 0; font-size: 11px; color: #9ca3af; text-transform: uppercase;">Booking ID</p>
                                                    <p style="margin: 0; font-size: 16px; font-weight: 600; color: #374151;">#{{ $booking->id }}</p>
                                                </td>
                                                <td width="50%">
                                                    <p style="margin: 0 0 4px 0; font-size: 11px; color: #9ca3af; text-transform: uppercase;">Status</p>
                                                    <p style="margin: 0; font-size: 16px; font-weight: 600; color: #059669;">PAID</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                
                                {{-- QR Code Section --}}
                                <tr>
                                    <td align="center" style="padding: 32px; background-color: #ffffff; border-top: 1px solid #f3f4f6;">
                                        <div style="padding: 16px; background: white; display: inline-block; border-radius: 8px; border: 1px solid #e5e7eb;">
                                            <img src="data:image/svg+xml;base64, {{ base64_encode(SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(150)->generate($booking->id . '-' . $booking->snap_token)) }} ">
                                        </div>
                                        <p style="margin: 16px 0 0 0; color: #9ca3af; font-size: 12px;">Scan at the entrance gate</p>
                                    </td>
                                </tr>
                            </table>

                            <div style="text-align: center; margin-top: 32px;">
                                <a href="{{ route('home') }}" style="background-color: #111827; color: #ffffff; text-decoration: none; padding: 12px 32px; border-radius: 50px; font-size: 14px; font-weight: 600; display: inline-block;">Explore More</a>
                            </div>
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td align="center" style="padding: 32px; background-color: #1f2937;">
                            <p style="color: #9ca3af; font-size: 12px; margin: 0;">&copy; {{ date('Y') }} Kuniverse. All rights reserved.</p>
                            <p style="color: #6b7280; font-size: 11px; margin: 8px 0 0 0;">This email is automatically generated. Please do not reply.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
