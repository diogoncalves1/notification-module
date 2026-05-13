<?php
namespace Modules\Notification\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\Notification\Entities\BroadcastNotification;
use Modules\User\Entities\User;

class BroadcastNotificationCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    protected BroadcastNotification $notification;
    protected User $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(BroadcastNotification $notification, User $user)
    {
        $this->notification = $notification;
        $this->user         = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $notification     = $this->notification;
        $notificationType = $notification->notificationType;

        $keywords = $notificationType->keywords;

        $user = $this->user;

        $emailSubject = $notificationType->mail_subject[$user->preferences->lang];
        $emailText    = $notificationType->mail_message[$user->preferences->lang];
        $signature    = $notificationType->mail_signature[$user->preferences->lang];

        foreach ($keywords as $keyword) {
            $emailSubject = str_replace($keyword, $this->notification->data[$keyword], $emailSubject);

            $emailText = str_replace($keyword, $this->notification->data[$keyword], $emailText);

            $signature = str_replace($keyword, $this->notification->data[$keyword], $signature);
        }

        $mail = $this->from(config('mail.from.address'), config('app.name'))
            ->subject($emailSubject);

        if (! empty($user)) {
            $mail->to($user->email);
        }

        $mail->with([
            'text'      => $emailText,
            'email'     => config('mail.from.address'),
            'signature' => $signature,
        ])
            ->markdown('notification::emails.mail');

        return $mail;
    }

    public function preview()
    {
        return $this->render();
    }
}
