<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use App\Models\Contact;
use App\Models\ProgramRegistration;

class EmailService
{
  /**
   * Send contact form notification to admin
   */
  public function sendContactFormNotification(Contact $contact): bool
  {
    try {
      $adminEmail = Config::get('mail.admin_email', 'admin@mountagro.af');

      $data = [
        'contact' => $contact,
        'subject' => 'New Contact Form Submission - ' . $contact->subject,
      ];

      Mail::send('emails.contact-notification', $data, function ($message) use ($adminEmail, $contact) {
        $message->to($adminEmail)
          ->subject('New Contact Form Submission - ' . $contact->subject)
          ->replyTo($contact->email, $contact->name);
      });

      Log::info("Contact form notification sent for contact ID: {$contact->id}");
      return true;
    } catch (\Exception $e) {
      Log::error("Failed to send contact form notification: " . $e->getMessage());
      return false;
    }
  }

  /**
   * Send contact form confirmation to user
   */
  public function sendContactFormConfirmation(Contact $contact): bool
  {
    try {
      $data = [
        'contact' => $contact,
        'company_name' => 'Mount Agro Institution',
        'company_email' => 'info@mountagro.af',
        'company_website' => 'https://mountagro.af',
      ];

      Mail::send('emails.contact-confirmation', $data, function ($message) use ($contact) {
        $message->to($contact->email, $contact->name)
          ->subject('Thank you for contacting Mount Agro Institution')
          ->from('info@mountagro.af', 'Mount Agro Institution');
      });

      Log::info("Contact form confirmation sent to: {$contact->email}");
      return true;
    } catch (\Exception $e) {
      Log::error("Failed to send contact form confirmation: " . $e->getMessage());
      return false;
    }
  }

  /**
   * Send program registration notification to admin
   */
  public function sendProgramRegistrationNotification(ProgramRegistration $registration): bool
  {
    try {
      $adminEmail = Config::get('mail.admin_email', 'admin@mountagro.af');

      $data = [
        'registration' => $registration,
        'program' => $registration->program,
        'subject' => 'New Program Registration - ' . $registration->program_type,
      ];

      Mail::send('emails.registration-notification', $data, function ($message) use ($adminEmail, $registration) {
        $message->to($adminEmail)
          ->subject('New Program Registration - ' . $registration->program_type)
          ->replyTo($registration->email, $registration->user_name);
      });

      Log::info("Program registration notification sent for registration ID: {$registration->id}");
      return true;
    } catch (\Exception $e) {
      Log::error("Failed to send program registration notification: " . $e->getMessage());
      return false;
    }
  }

  /**
   * Send program registration confirmation to user
   */
  public function sendProgramRegistrationConfirmation(ProgramRegistration $registration): bool
  {
    try {
      $data = [
        'registration' => $registration,
        'program' => $registration->program,
        'company_name' => 'Mount Agro Institution',
        'company_email' => 'info@mountagro.af',
      ];

      Mail::send('emails.registration-confirmation', $data, function ($message) use ($registration) {
        $message->to($registration->email, $registration->user_name)
          ->subject('Registration Confirmation - ' . $registration->program_type)
          ->from('info@mountagro.af', 'Mount Agro Institution');
      });

      Log::info("Program registration confirmation sent to: {$registration->email}");
      return true;
    } catch (\Exception $e) {
      Log::error("Failed to send program registration confirmation: " . $e->getMessage());
      return false;
    }
  }

  /**
   * Send program registration status update
   */
  public function sendRegistrationStatusUpdate(ProgramRegistration $registration, string $oldStatus): bool
  {
    try {
      $data = [
        'registration' => $registration,
        'program' => $registration->program,
        'old_status' => $oldStatus,
        'new_status' => $registration->status,
        'company_name' => 'Mount Agro Institution',
      ];

      $subject = $this->getStatusUpdateSubject($registration->status, $registration->program_type);

      Mail::send('emails.registration-status-update', $data, function ($message) use ($registration, $subject) {
        $message->to($registration->email, $registration->user_name)
          ->subject($subject)
          ->from('info@mountagro.af', 'Mount Agro Institution');
      });

      Log::info("Registration status update sent to: {$registration->email}");
      return true;
    } catch (\Exception $e) {
      Log::error("Failed to send registration status update: " . $e->getMessage());
      return false;
    }
  }

  /**
   * Send bulk email notification
   */
  public function sendBulkNotification(array $emails, string $subject, string $template, array $data = []): int
  {
    $successCount = 0;

    foreach ($emails as $email) {
      try {
        Mail::send($template, $data, function ($message) use ($email, $subject) {
          $message->to($email['email'], $email['name'] ?? '')
            ->subject($subject)
            ->from('info@mountagro.af', 'Mount Agro Institution');
        });

        $successCount++;
        Log::info("Bulk email sent to: {$email['email']}");
      } catch (\Exception $e) {
        Log::error("Failed to send bulk email to {$email['email']}: " . $e->getMessage());
      }
    }

    Log::info("Bulk email completed. Sent: {$successCount}/{" . count($emails) . "}");
    return $successCount;
  }

  /**
   * Send newsletter to subscribers
   */
  public function sendNewsletter(array $subscribers, string $subject, string $content, array $attachments = []): int
  {
    $successCount = 0;

    foreach ($subscribers as $subscriber) {
      try {
        $data = [
          'subscriber' => $subscriber,
          'content' => $content,
          'unsubscribe_url' => $this->generateUnsubscribeUrl($subscriber['email']),
        ];

        Mail::send('emails.newsletter', $data, function ($message) use ($subscriber, $subject, $attachments) {
          $message->to($subscriber['email'], $subscriber['name'] ?? '')
            ->subject($subject)
            ->from('info@mountagro.af', 'Mount Agro Institution');

          // Add attachments if any
          foreach ($attachments as $attachment) {
            $message->attach($attachment['path'], [
              'as' => $attachment['name'] ?? null,
              'mime' => $attachment['mime'] ?? null,
            ]);
          }
        });

        $successCount++;
      } catch (\Exception $e) {
        Log::error("Failed to send newsletter to {$subscriber['email']}: " . $e->getMessage());
      }
    }

    return $successCount;
  }

  /**
   * Send password reset email
   */
  public function sendPasswordResetEmail(string $email, string $token): bool
  {
    try {
      $data = [
        'token' => $token,
        'email' => $email,
        'reset_url' => url('password/reset/' . $token),
        'company_name' => 'Mount Agro Institution',
      ];

      Mail::send('emails.password-reset', $data, function ($message) use ($email) {
        $message->to($email)
          ->subject('Password Reset Request - Mount Agro Institution')
          ->from('info@mountagro.af', 'Mount Agro Institution');
      });

      Log::info("Password reset email sent to: {$email}");
      return true;
    } catch (\Exception $e) {
      Log::error("Failed to send password reset email: " . $e->getMessage());
      return false;
    }
  }

  /**
   * Send welcome email to new users
   */
  public function sendWelcomeEmail(string $email, string $name): bool
  {
    try {
      $data = [
        'name' => $name,
        'company_name' => 'Mount Agro Institution',
        'company_website' => 'https://mountagro.af',
        'login_url' => url('/login'),
      ];

      Mail::send('emails.welcome', $data, function ($message) use ($email, $name) {
        $message->to($email, $name)
          ->subject('Welcome to Mount Agro Institution')
          ->from('info@mountagro.af', 'Mount Agro Institution');
      });

      Log::info("Welcome email sent to: {$email}");
      return true;
    } catch (\Exception $e) {
      Log::error("Failed to send welcome email: " . $e->getMessage());
      return false;
    }
  }

  /**
   * Get subject for status update emails
   */
  private function getStatusUpdateSubject(string $status, string $programType): string
  {
    $programName = ucwords(str_replace('_', ' ', $programType));

    switch ($status) {
      case 'approved':
        return "Registration Approved - {$programName}";
      case 'rejected':
        return "Registration Update - {$programName}";
      case 'completed':
        return "Program Completed - {$programName}";
      default:
        return "Registration Status Update - {$programName}";
    }
  }

  /**
   * Generate unsubscribe URL
   */
  private function generateUnsubscribeUrl(string $email): string
  {
    $token = base64_encode($email . '|' . time());
    return url("unsubscribe/{$token}");
  }

  /**
   * Test email configuration
   */
  public function testEmailConfiguration(): array
  {
    try {
      $testEmail = Config::get('mail.admin_email', 'admin@mountagro.af');

      Mail::raw('This is a test email from Mount Agro Institution system.', function ($message) use ($testEmail) {
        $message->to($testEmail)
          ->subject('Email Configuration Test')
          ->from('info@mountagro.af', 'Mount Agro Institution');
      });

      return [
        'success' => true,
        'message' => "Test email sent successfully to {$testEmail}",
      ];
    } catch (\Exception $e) {
      return [
        'success' => false,
        'message' => 'Email configuration test failed: ' . $e->getMessage(),
      ];
    }
  }

  /**
   * Get email statistics
   */
  public function getEmailStats(): array
  {
    // This would typically fetch from a database table tracking sent emails
    // For now, return basic statistics
    return [
      'total_contacts_today' => Contact::whereDate('created_at', today())->count(),
      'total_registrations_today' => ProgramRegistration::whereDate('registration_date', today())->count(),
      'pending_notifications' => $this->getPendingNotificationsCount(),
    ];
  }

  /**
   * Get count of pending notifications
   */
  private function getPendingNotificationsCount(): int
  {
    // Count unread contacts and pending registrations
    $unreadContacts = Contact::where('status', 'unread')->count();
    $pendingRegistrations = ProgramRegistration::where('status', 'pending')->count();

    return $unreadContacts + $pendingRegistrations;
  }
}
