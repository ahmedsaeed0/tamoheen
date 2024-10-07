<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingUserTrip extends Mailable
{
    use Queueable, SerializesModels;
    public $image, $name, $email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($image, $name, $email)
    {
        $this->image    = $image;
        $this->name     = $name;
        $this->email    = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.booking_user_trips');
    }
}
