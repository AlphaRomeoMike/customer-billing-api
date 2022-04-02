<?php

namespace App\Mail;

use App\Models\Bill;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BillGenerated extends Mailable
{
	use Queueable, SerializesModels;

	protected $user;
	protected $bill;
	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct(User $user, Bill $bill)
	{
		$this->user = $user;
		$this->bill = $bill;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		return $this->markdown('emails.bills.generated')->with([
			'user' => $this->user,
			'bill' => $this->bill,
		])->subject('Bill Generated')->to($this->user->email);
	}
}
