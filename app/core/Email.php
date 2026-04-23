<?php
/**
 * Email Helper
 * Wraps PHP mail() with a consistent theme and configuration
 */
class Email {
    
    /**
     * Send a themed email
     * 
     * @param string $to Recipient email
     * @param string $subject Email subject
     * @param string $content HTML content for the body
     * @return bool
     */
    public static function send($to, $subject, $content) {
        // Fetch configuration from settings
        $senderName = setting('mail_sender_name', 'Numinds Tech');
        $senderEmail = setting('mail_sender_email', 'noreply@' . $_SERVER['HTTP_HOST']);
        
        $headers = [
            'MIME-Version' => '1.0',
            'Content-type' => 'text/html; charset=UTF-8',
            'From' => "$senderName <$senderEmail>",
            'Reply-To' => $senderEmail,
            'X-Mailer' => 'PHP/' . phpversion()
        ];

        $htmlContent = self::getThemedTemplate($subject, $content);

        return mail($to, $subject, $htmlContent, $headers);
    }

    /**
     * Wrap content in a professional HTML template
     */
    private static function getThemedTemplate($subject, $content) {
        $primaryColor = '#085ae6';
        $accentColor = '#f1501a';
        
        return "
        <!DOCTYPE html>
        <html>
        <head>
            <style>
                body { font-family: 'Inter', Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; }
                .container { max-width: 600px; margin: 20px auto; border: 1px solid #eee; border-radius: 12px; overflow: hidden; }
                .header { background: $primaryColor; color: white; padding: 30px; text-align: center; }
                .content { padding: 40px; }
                .footer { background: #f9f9f9; padding: 20px; text-align: center; font-size: 11px; color: #999; }
                .btn { display: inline-block; padding: 12px 24px; background: $accentColor; color: white; text-decoration: none; border-radius: 8px; font-weight: bold; margin-top: 20px; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1 style='margin:0; font-size: 24px;'>$subject</h1>
                </div>
                <div class='content'>
                    $content
                </div>
                <div class='footer'>
                    &copy; " . date('Y') . " Numinds Tech. All rights reserved.
                </div>
            </div>
        </body>
        </html>";
    }

    /**
     * Send notification for a new lead
     */
    public static function notifyNewLead($leadData) {
        $recipient = setting('mail_notifications_to', setting('contact_email'));
        if (empty($recipient)) return false;

        $subject = "New Lead: " . $leadData['name'];
        $content = "
            <p>Hello Admin,</p>
            <p>You have received a new lead submission from your website.</p>
            <hr style='border: 0; border-top: 1px solid #eee; margin: 20px 0;'>
            <table width='100%'>
                <tr><td><strong>Name:</strong></td><td>" . e($leadData['name']) . "</td></tr>
                <tr><td><strong>Email:</strong></td><td>" . e($leadData['email']) . "</td></tr>
                <tr><td><strong>Phone:</strong></td><td>" . e($leadData['phone'] ?? 'N/A') . "</td></tr>
                <tr><td><strong>Project:</strong></td><td>" . e($leadData['project_detail'] ?? 'N/A') . "</td></tr>
            </table>
            <p>You can view and manage this lead in your dashboard.</p>
            <a href='" . url('admin/leads') . "' class='btn'>View in Dashboard</a>
        ";

        return self::send($recipient, $subject, $content);
    }
}
