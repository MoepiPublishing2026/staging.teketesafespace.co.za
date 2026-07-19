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


    // NEW METHOD: This matches the wire:click="executeSearch" from your layout
    public function executeSearch()
    {
        $this->activeSearch = trim($this->search);
    }

    // Livewire lifecycle hook: Runs automatically whenever $search changes
    public function updatedSearch()
    {
        $trimmedSearch = trim($this->search);

        if (strlen($trimmedSearch) >= 2) { 
            // Limit to top 5 suggestions for cleaner UI
            $this->suggestions = Newsletter::where('title', 'like', '%' . $trimmedSearch . '%')
                ->take(5) 
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
        // Safe query optimization using a trimmed string variable
        $searchQuery = trim($this->search);

        $newsletters = Newsletter::query()
            ->when($searchQuery !== '', function ($query) use ($searchQuery) {
                $query->where('title', 'like', '%' . $searchQuery . '%');
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.news-index', [
            'newsletters' => $newsletters
        ])->layout('components.layouts.app'); 
    }
}