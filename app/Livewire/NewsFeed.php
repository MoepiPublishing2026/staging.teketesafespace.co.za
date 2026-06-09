<?php

namespace App\Livewire;

use Livewire\Component; // <-- CRITICAL: Make sure this isn't missing or misspelled

class NewsFeed extends Component
{
    public $selectedArticle = 'proudly-sa'; 

    public function showArticle($articleSlug)
    {
        $this->selectedArticle = $articleSlug;
    }

    public function goBack()
    {
        $this->selectedArticle = null; 
    }

    public function render()
    {
        return view('livewire.news-feed');
    }
}