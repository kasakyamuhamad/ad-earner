<?php

namespace App\Notifications;

use App\Models\Withdrawal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WithdrawalRejected extends Notification implements ShouldQueue
{
    use Queueable;

    public $withdrawal;
    public $reason;

    public function __construct(Withdrawal $withdrawal, $reason)
    {
        $this->withdrawal = $withdrawal;
        $this->reason = $reason;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('⚠️ Your Withdrawal Request Status')
            ->greeting('Hello ' . $notifiable->first_name . '!')
            ->line('We regret to inform you that your withdrawal request has been rejected.')
            ->line('**Reason:** ' . $this->reason)
            ->line('**Transaction Details:**')
            ->line('- Amount: ' . $this->withdrawal->amount . ' coins (' . ($this->withdrawal->amount / 10) . ' UGX)')
            ->line('- Phone: ' . $this->withdrawal->phone)
            ->line('The amount has been refunded to your AdEarn balance.')
            ->line('If you believe this is a mistake, please contact our support team.')
            ->action('View Your Account', url('/dashboard'))
            ->salutation('Thank you for using AdEarn!');
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'withdrawal_rejected',
            'amount' => $this->withdrawal->amount,
            'reason' => $this->reason,
            'message' => 'Your withdrawal was rejected: ' . $this->reason
        ];
    }
}