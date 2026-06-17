<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Newsletter;

class NewsIndex extends Component
{
    public $search = '';
    public $suggestions = []; // Holds the autocomplete suggestions
    public $expandedNewsletterId = null;
    public $nextArticleUrl = '#';

    // Livewire lifecycle hook: Runs automatically whenever $search changes
    public function updatedSearch()
    {
        if (strlen($this->search) >= 2) { // Only suggest after typing 2+ characters
            $this->suggestions = Newsletter::where('title', 'like', '%' . $this->search . '%')
                ->take(5) // Limit to top 5 suggestions for cleaner UI
                ->pluck('title')
                ->toArray();
        } else {
            $this->suggestions = [];
        }
    }

    // Fills the search bar when a user clicks a suggestion
    public function selectSuggestion($title)
    {
        $this->search = $title;
        $this->suggestions = []; // Clear suggestions after selection
    }

    public function toggleExpand($id)
    {
        if ($this->expandedNewsletterId === $id) {
            $this->expandedNewsletterId = null;
        } else {
            $this->expandedNewsletterId = $id; 
        }
    }

    public function render()
    {
        $newsletters = Newsletter::query()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.news-index', [
            'newsletters' => $newsletters
        ])->layout('components.layouts.app'); 
    }
}