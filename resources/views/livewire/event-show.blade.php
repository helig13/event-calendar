<div id="event-modal" class="absolute z-10 min-w-[430px]" x-show="showEventModal"

:style="{ top: modalTop + 'px', left: modalLeft + 'px' }" @click.away="showEventModal = false;">

    @if($editEventModal)

        @livewire('event-edit', ['eventId' => $eventId])

    @endif

    {{-- Modal content --}}
    <div class="block overflow-hidden text-left bg-dark1"
         aria-modal="true" aria-labelledby="modal-headline">
        <div class="px-4 pt-5 pb-4 bg-dark1">
            <h3 class="text-month mb-4" id="modal-headline">
                Events
            </h3>
            <div class="w-full p-[1px] bg-red1 opacity-10"></div>

            <div class="mt-2 p-2">
                @if($events && count($events) > 0)
                    @foreach($events as $event)
                        <div class="grid grid-cols-2 gap-2 mt-2">
                            <div>
                                <p class="name">
                                    {{ $event->name }}
                                </p>
                            </div>
                            <div class="flex flex-row-reverse">
                                <button wire:click="editEvent({{ $event->id }})" type="button">

                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                              d="M5.53999 21.0469C4.92999 21.0469 4.35999 20.8369 3.94999 20.4469C3.42999 19.9569 3.17999 19.2169 3.26999 18.4169L3.63999 15.1769C3.70999 14.5669 4.07999 13.7569 4.50999 13.3169L11.3421 6.08541C11.3534 6.07256 11.3652 6.06008 11.3774 6.04799L12.72 4.62692C14.77 2.45692 16.91 2.39692 19.08 4.44692C21.25 6.49692 21.31 8.63692 19.26 10.8069L11.05 19.4969C10.63 19.9469 9.84999 20.3669 9.23999 20.4669L6.01999 21.0169C5.95895 21.0205 5.9005 21.0254 5.84324 21.0302C5.74099 21.0387 5.64254 21.0469 5.53999 21.0469ZM5.59999 14.3369L11.5184 8.0653C12.258 10.0344 13.8657 11.5562 15.8709 12.1898L9.94999 18.4569C9.74999 18.6669 9.26999 18.9269 8.97999 18.9769L5.75999 19.5269C5.42999 19.5769 5.15999 19.5169 4.97999 19.3469C4.79999 19.1769 4.71999 18.9069 4.75999 18.5769L5.12999 15.3369C5.16999 15.0469 5.39999 14.5469 5.59999 14.3369ZM18.16 9.76692L17.055 10.9366C14.9019 10.5714 13.1855 8.93318 12.7129 6.79952L13.81 5.63692C14.49 4.91692 15.16 4.43692 15.93 4.43692C16.55 4.43692 17.24 4.75692 18.04 5.52692C19.85 7.22692 19.4 8.44692 18.16 9.76692Z"
                                              fill="#797979"/>
                                    </svg>
                                </button>

                            </div>
                        </div>
                        <p class="description mt-2">
                            {{ $event->description }}
                        </p>
                        <p class="location mt-2">
                            {{ $event->location }}
                        </p>
                        <div class="grid grid-cols-2 gap-2 mt-2">
                                <span class="date">
                                 {{ Carbon\Carbon::parse($event->start_datetime)->format('j F, g:i A') }}

                                </span>
                            <p class="{{ $eventTypeClasses[$event->event_type] ?? 'default-class' }}">
                                {{ $event->eventType->event_type }}
                            </p>

                        </div>
                        <div class="w-full p-[1px] bg-red1 opacity-10 mt-4 mb-4"></div>
                    @endforeach
                @else
                    <p class="text-sm leading-5 text-gray-500">No events</p>
                @endif
            </div>
        </div>
        <div class="px-4 py-3 w-full flex flex-row-reverse">
            <button x-on:click="showEventModal = false; addEventModal = true;" type="button"
                    class="add-button">
                Add Event
            </button>
        </div>
    </div>

</div>
