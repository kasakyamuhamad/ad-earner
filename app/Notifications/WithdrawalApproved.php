<?php

namespace App\Notifications;

use App\Models\Withdrawal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WithdrawalApproved extends Notification implements ShouldQueue
{
    use Queueable;

    public $withdrawal;

    public function __construct(Withdrawal $withdrawal)
    {
        $this->withdrawal = $withdrawal;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('🎉 Your Withdrawal Has Been Approved!')
            ->greeting('Hello ' . $notifiable->first_name . '!')
            ->line('We are pleased to inform you that your withdrawal request has been approved.')
            ->line('**Transaction Details:**')
            ->line('- Amount: ' . $this->withdrawal->amount . ' coins (' . ($this->withdrawal->amount / 10) . ' UGX)')
            ->line('- Phone: ' . $this->withdrawal->phone)
            ->line('- Network: ' . $this->withdrawal->network)
            ->line('The funds should arrive in your mobile money account within 24 hours.')
            ->line('If you have any questions, please contact our support team.')
            ->action('View Your Account', url('/dashboard'))
            ->salutation('Thank you for using AdEarn!');
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'withdrawal_approved',
            'amount' => $this->withdrawal->amount,
            'phone' => $this->withdrawal->phone,
            'message' => 'Your withdrawal of ' . $this->withdrawal->amount . ' coins has been approved.'
        ];
    }
}