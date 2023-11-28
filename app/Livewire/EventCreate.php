<?php

namespace App\Livewire;

use App\Models\EventType;
use Livewire\Component;
use App\Models\Event;

// Other necessary imports...

class EventCreate extends Component
{
    public $name; // Event name
    public $start_datetime, $end_datetime, $event_type, $location, $description, $type_id;
    public $start_time;
    public $eventTypes = [];
    /**
     * @var false
     */
    public $addEventModal = false;

    public function mount()
    {
        $this->reset();

        $this->eventTypes = EventType::all();

        // Set the default start_datetime using the selected date
        $selectedDate = session('selectedDate');
        if ($selectedDate) {
            $this->start_datetime = $selectedDate . ' ' . '00:00:00';
        }
        $this->dispatch('updateStartDateTime', $this->start_datetime);
    }

    protected $listeners = ['dateSelected' => 'updateDate'];

    public function updateDate($data)
    {
        $this->start_datetime = $data['date'] . ' ' . '00:00:00';
    }

    private function combineDateTime($date, $time)
    {
        return $date . ' ' . $time;
    }

    public function saveEvent()
    {
        $this->validate([
            'name' => 'required',
            'start_time' => 'required',
            'type_id' => 'required',
            'location' => 'required',
            'description' => 'required',
        ]);
        $combinedDateTime = $this->combineDateTime(session('selectedDate'), $this->start_time);

        Event::create([
            'name' => $this->name,
            'description' => $this->description,
            'event_type' => $this->type_id,
            'location' => $this->location,
            'start_datetime' => $combinedDateTime,
            'created_at' => now(),
            'updated_at' => now(),


        ]);
        session()->flash('message', 'Event successfully created.');
        $this->dispatch('close-modal');

    }


    public function render()
    {
        return view('livewire.event-create', [
            'selectedDate' => session('selectedDate')
        ]);
    }
}
