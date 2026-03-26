<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permit Expiry Reminder</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 20px;
        }

        .email-wrapper {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 30px;
            text-align: center;
            color: white;
        }

        .header-icon {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
            border: 3px solid rgba(255, 255, 255, 0.3);
        }

        .header-icon svg {
            width: 40px;
            height: 40px;
            fill: white;
        }

        .header h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header p {
            font-size: 16px;
            margin-top: 8px;
            opacity: 0.95;
        }

        .alert-banner {
            padding: 20px 30px;
            text-align: center;
            font-weight: 600;
            font-size: 16px;
        }

        .alert-critical {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
            color: white;
        }

        .alert-warning {
            background: linear-gradient(135deg, #ffd93d 0%, #ffb800 100%);
            color: #333;
        }

        .alert-info {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }

        .content {
            padding: 40px 30px;
        }

        .greeting {
            font-size: 18px;
            color: #333;
            margin-bottom: 20px;
        }

        .greeting strong {
            color: #667eea;
        }

        .message {
            font-size: 16px;
            color: #555;
            margin-bottom: 30px;
            line-height: 1.8;
        }

        .permit-card {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            border-radius: 12px;
            padding: 30px;
            margin: 30px 0;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .permit-card h3 {
            color: #667eea;
            font-size: 20px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 700;
        }

        .detail-row {
            display: flex;
            padding: 12px 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: 600;
            color: #555;
            width: 140px;
            flex-shrink: 0;
        }

        .detail-value {
            color: #333;
            flex: 1;
        }

        .detail-value.highlight {
            font-weight: 700;
            color: #667eea;
            font-size: 18px;
        }

        .detail-value.critical {
            font-weight: 700;
            color: #ff6b6b;
            font-size: 18px;
        }

        .expiry-countdown {
            background: white;
            border-radius: 12px;
            padding: 25px;
            margin: 25px 0;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .countdown-number {
            font-size: 48px;
            font-weight: 700;
            color: #667eea;
            display: block;
            line-height: 1;
        }

        .countdown-number.critical {
            color: #ff6b6b;
        }

        .countdown-label {
            font-size: 16px;
            color: #666;
            margin-top: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .footer {
            background: #f8f9fa;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e0e0e0;
        }

        .footer-logo {
            font-size: 20px;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 15px;
        }

        .footer p {
            font-size: 13px;
            color: #999;
            margin: 5px 0;
        }

        .footer-links {
            margin: 15px 0;
        }

        .footer-links a {
            color: #667eea;
            text-decoration: none;
            margin: 0 10px;
            font-size: 13px;
        }

        .social-icons {
            margin-top: 20px;
        }

        .social-icons a {
            display: inline-block;
            width: 36px;
            height: 36px;
            background: #667eea;
            border-radius: 50%;
            margin: 0 5px;
            line-height: 36px;
            color: white;
            text-decoration: none;
        }

        @media only screen and (max-width: 600px) {
            body {
                padding: 20px 10px;
            }

            .content {
                padding: 30px 20px;
            }

            .permit-card {
                padding: 20px;
            }

            .detail-row {
                flex-direction: column;
            }

            .detail-label {
                width: 100%;
                margin-bottom: 5px;
            }

            .countdown-number {
                font-size: 36px;
            }
        }
    </style>
</head>

<body>
    <div class="email-wrapper">
        <!-- Header -->
        <div class="header">
            <div class="header-icon">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                        stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </div>
            <h1>Permit Expiry Reminder</h1>
            <p>Important Notice - Action Required</p>
        </div>

        <!-- Alert Banner -->
        @if($reminderType === '1_month')
            <div class="alert-banner alert-critical">
                ⚠️ URGENT: This permit expires in approximately 1 month!
            </div>
        @elseif($reminderType === '3_months')
            <div class="alert-banner alert-warning">
                📋 Notice: This permit expires in approximately 3 months
            </div>
        @elseif($reminderType === '6_months')
            <div class="alert-banner alert-info">
                📅 Reminder: This permit expires in approximately 6 months
            </div>
        @else
            <div class="alert-banner alert-info">
                📋 Permit Renewal Reminder
            </div>
        @endif

        <!-- Content -->
        <div class="content">
            <div class="greeting">
                Dear <strong>{{ $permit->boss_name }}</strong>,
            </div>

            <div class="message">
                This is an automated reminder from the Permit Monitoring System. We want to ensure you have sufficient
                time to take necessary action regarding the following permit that is approaching its expiration date.
            </div>

            <!-- Expiry Countdown -->
            <div class="expiry-countdown">
                <span class="countdown-number {{ $permit->daysUntilExpiry() <= 30 ? 'critical' : '' }}">
                    {{ $permit->daysUntilExpiry() }}
                </span>
                <div class="countdown-label">Days Remaining</div>
            </div>

            <!-- Permit Details Card -->
            <div class="permit-card">
                <h3>📄 Permit Details</h3>

                <div class="detail-row">
                    <div class="detail-label">Permit Name:</div>
                    <div class="detail-value highlight">{{ $permit->permit_name }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Permit Number:</div>
                    <div class="detail-value">{{ $permit->permit_number }}</div>
                </div>

                <div class="detail-row">
                    @if($permit->division)
                    <div class="detail-label">Division:</div>
                    <div class="detail-value"><strong>{{ $permit->division }}</strong></div>
                    @endif
                </div>

                <div class="detail-row">
                    <div class="detail-label">Issue Date:</div>
                    <div class="detail-value">{{ $permit->issue_date->format('d F Y') }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Expiry Date:</div>
                    <div class="detail-value {{ $permit->daysUntilExpiry() <= 30 ? 'critical' : 'highlight' }}">
                        {{ $permit->expiry_date->format('d F Y') }}
                    </div>
                </div>

                @if($permit->description)
                    <div class="detail-row">
                        <div class="detail-label">Description:</div>
                        <div class="detail-value">{{ $permit->description }}</div>
                    </div>
                @endif
            </div>

            <!-- Call to Action -->
            <div class="message">
                If you have already taken action regarding this permit, please disregard this reminder. For any
                questions or assistance, please contact your permit administrator.
            </div>

            <div class="message" style="margin-top: 30px; padding-top: 20px; border-top: 2px solid #e0e0e0;">
                <strong>Best regards,</strong><br>
                Hubungan Pemerintahan & Sistem Informasi
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="footer-logo">🔔 Permit Monitor</div>
            <p>Automated Permit Monitoring & Reminder System</p>
            <p style="margin-top: 15px;">This is an automated email notification. Please do not reply to this message.
            </p>
            <p style="color: #999; font-size: 12px; margin-top: 20px;">
                © {{ date('Y') }} Permit Monitor System. All rights reserved.
            </p>
        </div>
    </div>
</body>

</html>
