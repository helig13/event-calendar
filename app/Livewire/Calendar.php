<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Event;
use Carbon\Carbon;

class Calendar extends Component
{
    public $events;
    public $currentMonth;

    public function mount()
    {
        $this->currentMonth = Carbon::now()->format('Y-m');
        $this->loadEvents();
    }

    public function loadEvents()
    {
        // Fetch events logic
        $this->events = Event::whereMonth('start_datetime', $this->currentMonth)->get();
    }

    public function render()
    {
        return view('livewire.calendar');
    }
}
