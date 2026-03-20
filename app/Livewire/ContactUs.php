<?php

namespace App\Livewire;

use Livewire\Component;

class ContactUs extends Component
{
    // You can add properties here if you want to implement a contact form
    // public $name;
    // public $email;
    // public $message;

    public function render()
    {
        return view('livewire.contact-us')
            ->layout('components.layouts.app'); // Assuming you use the default app layout
    }

    
}