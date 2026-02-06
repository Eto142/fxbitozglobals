<?php

namespace App\Mail;

use App\Models\Withdrawal;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WithdrawalSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public $withdrawal;
    public $isTransfer;
    public $viewer; // receiver | sender

    /**
     * Create a new message instance.
     */
    public function __construct(Withdrawal $withdrawal, string $viewer)
    {
        $this->withdrawal = $withdrawal;
        $this->viewer = $viewer;

        // Detect transfer vs withdrawal
        $this->isTransfer = !empty($withdrawal->transfer_from);
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $subject = $this->isTransfer
            ? 'Transfer Request Submitted'
            : 'Withdrawal Submitted Successfully';

        return $this->subject($subject)
            ->with([
                'viewer' => $this->viewer, // passed to Blade
            ])
            ->markdown('emails.withdrawals.submitted');
    }
}
