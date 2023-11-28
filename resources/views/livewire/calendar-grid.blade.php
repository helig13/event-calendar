<div x-data="{
    showEventModal: false,
    addEventModal: false,
    selectedDate: null,
    modalTop: 0,
    modalLeft: 0,
    setPosition: function (event) {
        let modal = document.getElementById('event-modal');
        let rect = event.target.getBoundingClientRect();
        let top = rect.top + window.scrollY;
        let left = rect.left + window.scrollX;

        // Define and adjust offset values as needed
        let verticalOffset = 30;
        let horizontalOffset = 35;

        // Update top and left positions with offsets
        this.modalTop = top + verticalOffset;
        this.modalLeft = left + horizontalOffset;

        // Show the modal
        this.showEventModal = true;
    }}">
    <div class="flex flex-row w-full">
        <div class="filter flex flex-row mt-4 justify-self-start mb-4">
            <div class="ml-2 p-2">
                <div class="{{ in_array(1, $selectedEventTypes) ? 'button-red-active' : 'button-red' }} cursor-pointer"
                     wire:click="filterEvents(1)">Meeting with an expert
                </div>
            </div>
            <div class="ml-2 p-2">
                <div class="{{ in_array(2, $selectedEventTypes) ? 'button-green-active' : 'button-green' }} cursor-pointer"
                     wire:click="filterEvents(2)">Question-answer
                </div>
            </div>
            <div class="ml-2 p-2">
                <div class="{{ in_array(3, $selectedEventTypes) ? 'button-yellow-active' : 'button-yellow' }} cursor-pointer"
                     wire:click="filterEvents(3)">Conference
                </div>
            </div>
            <div class="ml-2 p-2">
                <div class="{{ in_array(4, $selectedEventTypes) ? 'button-blue-active' : 'button-blue' }} cursor-pointer"
                     wire:click="filterEvents(4)">Webinar
                </div>
            </div>
        </div>
    </div>
    <div class="w-full p-[1px] bg-red1 opacity-10"></div>

    <div class="grid grid-cols-3 gap-4">
        @foreach ($months as $month)
            <div class="bg-dark1 text-white p-4 rounded-lg">
                <div class="text-month mb-4">{{ $month['name'] }}</div>
                <div class="flex justify-between text-day py-2">
                    <div>Sun</div>
                    <div>Mon</div>
                    <div>Tue</div>
                    <div>Wed</div>
                    <div>Thu</div>
                    <div>Fri</div>
                    <div>Sat</div>
                </div>
                <div class="grid grid-cols-7 gap-1 text-xs ">
                    @foreach ($month['days'] as $dayInfo)
                        @php
                            $dayClass = 'text-date hover:bg-gray-700 cursor-pointer rounded-full';
                            if ($dayInfo['month'] !== 'current') {
                                $dayClass .= ' text-outdate hover:bg-gray-700 cursor-pointer rounded-full';
                            }
                             $eventColors = $this->events[$dayInfo['date']] ?? collect();
                        @endphp
                        <div :class="{ 'text-date-red': selectedDate === '{{ $dayInfo['date'] }}' }"
                             class="{{ $dayClass }}"
                             wire:click="showDayEvents('{{ $dayInfo['date'] }}')"
                             x-on:click="selectedDate = '{{ $dayInfo['date'] }}'; setPosition($event)">
                            {{ $dayInfo['day'] }}
                            <div class="flex justify-center">
                                @foreach ($eventColors as $color)
                                    <span class="dot" style="background-color: {{ $color }};"></span>
                                @endforeach

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

    </div>
    <div x-data="{ showEventModal: false, addEventModal: false, editEventModal: false}">
        <!-- Event Show Modal -->
        <div x-show="showEventModal" @open-modal.window="showEventModal = true"
             @close-modal.window="showEventModal = false">
            <livewire:event-show/>
        </div>

        <!-- Event Create Modal -->
        <div x-show="addEventModal">
            <livewire:event-create/>

        </div>

    </div>
</div>
