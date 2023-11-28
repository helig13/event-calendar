<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Log;
use Livewire\Component;
use App\Models\Event;


class EventShow extends Component
{
    public $events;
    public $eventId;
    public $date;
    public $event;
    /**
     * @var true
     */
    public $editEventModal = false;



    public function mount($date = null)
    {

        $this->date = $date;
    }

    protected $listeners = ['loadEvents' => 'showEvents'];


    public function showEvents($payload)
    {
        $date = $payload['date'];
        $eventTypes = $payload['eventTypes'] ?? [];

        $this->date = $date;
        $this->events = Event::whereDate('start_datetime', $date)
            ->when(count($eventTypes) > 0, function ($query) use ($eventTypes) {
                $query->whereIn('event_type', $eventTypes);
            })
            ->get();

        $this->dispatch('open-modal');
    }
    public function editEvent($eventId)
    {
        $this->eventId = $eventId;
        $this->event = Event::find($eventId);
        $this->editEventModal=true;
    }


    public function addEvents($date)
    {
        $this->date = $date;
        $this->dispatch('close-modal');
        $this->dispatch('open-modal');
    }



    public function render()
    {
        $eventTypeClasses = [
            1 => 'button-red',
            2 => 'button-green',
            3 => 'button-yellow',
            4 => 'button-blue',
        ];
        return view('livewire.event-show', [
            'events' => $this->events,
            'event' => $this->event ?? null,
            'eventTypeClasses' => $eventTypeClasses,
        ]);
    }
}
