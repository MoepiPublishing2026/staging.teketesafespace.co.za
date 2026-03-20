<?php

namespace App\Livewire;

use App\Models\AbuseType;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class AbuseTypeSelection extends Component
{
    public $isAnonymous;

    public function mount($isAnonymous)
    {
        $this->isAnonymous = ($isAnonymous === 'anonymous');
    }

    public function selectAbuseType($abuseTypeID)
    {
        return $this->redirect('/report-form/' . $abuseTypeID . '/' . ($this->isAnonymous ? 'anonymous' : 'non-anonymous'));
    }

    public function render()
    {
        // Use a grouped query to ensure only unique abuse types are displayed
        $abuseTypes = AbuseType::query()
            ->select('type_name', DB::raw('MIN(id) as id'))
            ->groupBy('type_name')
            ->get();

        return view('livewire.abuse-type-selection', [
            'abuseTypes' => $abuseTypes,
            'isAnonymous' => $this->isAnonymous,
        ]);
    }
}
