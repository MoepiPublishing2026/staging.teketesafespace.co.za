<?php

namespace App\Livewire;

use Livewire\Component;

class LandingPage extends Component
{
    /**
     * Redirects to the anonymous/non-anonymous report selection page.
     */
    public function redirectToReportAbuse()
    {
        return redirect()->route('choose-report-type');
    }

    /**
     * Redirects to the secure school admin login page (the passwordless flow).
     */
    public function redirectToAdminLogin()
    {
        return redirect()->route('school-admin');
    }

    /**
     * Redirects to the status check page.
     */
    public function redirectToStatusCheck()
    {
        return redirect()->route('check-status');
    }

    /**
     * Renders the landing page view.
     */
    public function render()
    {
        return view('livewire.landing-page');
    }
}
