<?php

namespace App\Livewire;

use Livewire\Component;

class ChooseReportType extends Component
{
    public function render()
    {
        return view('livewire.choose-report-type');
    }

    public function selectReportType($isAnonymous)
    {
        return $this->redirect('/types-of-abuse/' . ($isAnonymous ? 'anonymous' : 'non-anonymous'));
    }
}
