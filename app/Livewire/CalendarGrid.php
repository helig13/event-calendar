<?php

namespace App\Livewire;

use App\Models\Event;
use Livewire\Component;
use Carbon\Carbon;

class CalendarGrid extends Component
{
    public $months;
    public $selectedDate;
    public $events = [];
    public $groupedEvents;
    public $selectedEventTypes = [];


    public function mount()
    {
        $this->months = collect();
        $now = Carbon::now();

        for ($i = 0; $i < 6; $i++) {
            $monthDays = [];
            $startDay = $now->copy()->startOfMonth()->dayOfWeek;
            $daysInMonth = $now->daysInMonth;

            // Calculate days from previous month
            $prevMonth = $now->copy()->subMonthNoOverflow();
            $daysFromPrevMonth = $startDay === 0 ? 6 : $startDay - 1;
            for ($d = $daysFromPrevMonth; $d > 0; $d--) {
                $monthDays[] = [

                    'day' => $prevMonth->endOfMonth()->subDays($d - 1)->day,
                    'date' => $prevMonth->endOfMonth()->subDays($d - 1)->format('Y-m-d'),
                    'month' => 'prev',
                ];
            }

            // Current month's days
            for ($d = 1; $d <= $daysInMonth; $d++) {
                $monthDays[] = [
                    'day' => $d,
                    'date' => $now->copy()->setDay($d)->format('Y-m-d'),
                    'month' => 'current',
                ];
            }

            // Calculate days for next month
            $cellsFilled = count($monthDays);
            $cellsTotal = $cellsFilled > 35 ? 42 : 35; // 5 weeks or 6 weeks
            while ($cellsFilled < $cellsTotal) {
                $monthDays[] = [
                    'day' => $cellsFilled - $daysInMonth - $daysFromPrevMonth + 1,
                    'date' => $now->copy()->addMonthNoOverflow()->startOfMonth()->addDays($cellsFilled - $daysInMonth - $daysFromPrevMonth)->format('Y-m-d'),
                    'month' => 'next',
                ];
                $cellsFilled++;
            }

            $this->months->push([
                'name' => $now->format('F'),

                'days' => $monthDays,
                'startDay' => $startDay,
            ]);
            $this->updateEvents();

            $eventsByDate = Event::whereBetween('start_datetime', [
                $this->months->first()['days'][0]['date'],
                $this->months->last()['days'][last(array_keys($this->months->last()['days']))]['date']
            ])->get()->groupBy(function ($event) {
                return Carbon::parse($event->start_datetime)->format('Y-m-d');
            })->map(function ($events, $date) {
                return $events->mapWithKeys(function ($event) {
                    return [$event->event_type => $this->eventTypeColors[$event->event_type] ?? 'default-color'];
                });

            });


            $this->events = $eventsByDate;


            $now->addMonth();
        }
    }

    public $eventTypeColors = [
        1 => '#ff4d6b',
        2 => '#00cc66',
        3 => '#ffbb32',
        4 => '#4db4ff',
    ];

    public function showDayEvents($date)
    {
        session(['selectedDate' => $date]);
        $this->dispatch('loadEvents', ['date' => $date, 'eventTypes' => $this->selectedEventTypes]);
    }


    public function filterEvents($eventType)
    {
        if (in_array($eventType, $this->selectedEventTypes)) {
            $this->selectedEventTypes = array_diff($this->selectedEventTypes, [$eventType]);
        } else {
            $this->selectedEventTypes[] = $eventType;
        }
        $this->updateEvents();
    }

    protected function updateEvents()
    {

        $this->events = Event::whereBetween('start_datetime', [
            $this->months->first()['days'][0]['date'],
            $this->months->last()['days'][last(array_keys($this->months->last()['days']))]['date']
        ])
            ->when(count($this->selectedEventTypes) > 0, function ($query) {
                $query->whereIn('event_type', $this->selectedEventTypes);
            })
            ->get()->groupBy(function ($event) {
                return Carbon::parse($event->start_datetime)->format('Y-m-d');
            })->map(function ($events, $date) {
                return $events->map(function ($event) {
                    return $this->eventTypeColors[$event->event_type] ?? 'default-color';
                })->unique()->values();
            });
    }

    public function render()
    {
        return view('livewire.calendar-grid', [
            'events' => $this->events,
            'event' => $this->event ?? null,
            'date' => $this->selectedDate,
            'groupedEvents' => $this->groupedEvents,
        ]);
    }
}
