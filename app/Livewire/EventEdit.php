<?php

namespace App\Livewire;

use App\Models\EventType;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use App\Models\Event;

class EventEdit extends Component
{
    public $eventId;
    public $name, $description, $start_datetime, $location, $type, $eventTypes, $event_type;
    public $type_id;


    public function mount($eventId)
    {
        $event = Event::find($eventId);
        $this->eventId = $eventId;
        $this->name = $event->name;
        $this->description = $event->description;
        $this->start_datetime = $event->start_datetime;
        $this->location = $event->location;
        $this->event_type = $event->type_id;
        $this->eventTypes = EventType::all();
    }

    public function update($eventId)
    {
        $this->validate([
            'name' => 'required',
            'start_datetime' => 'required|date',
            'location' => 'required',
            'event_type' => 'required',

        ]);

        $event = Event::findorfail($eventId);
            $event->update([
                'name' => $this->name,
                'description' => $this->description,
                'start_datetime' => $this->start_datetime,
                'location' => $this->location,
                'event_type' => $this->type_id,]);
            session()->flash('message', 'Update method called');
            $this->redirect('/');

        }


    public function delete($eventId)
    {
        $event = Event::findorfail($eventId);
            $event->delete();
            session()->flash('message', 'Delete method called');
            $this->redirect('/');
    }

    public function render()
    {
        return view('livewire.event-edit', [
            'eventTypes' => $this->eventTypes,

        ]);
    }
}
