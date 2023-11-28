<div x-show="addEventModal" x-data="{ open: false }" @show-add-event-modal.window="open = true" x-cloak @click.away="addEventModal = false;">
    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">

            {{-- Overlay --}}
            <div class="fixed inset-0 transition-opacity" x-on:click="open = false">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            {{-- Modal content --}}
            <div class="inline-block text-left align-bottom transition-all transform rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                 role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                <div class="px-4 pt-5 pb-4 bg-modal sm:p-6 sm:pb-4 flex flex-col">
                    <div class="flex flex-row justify-self-start mb-4">
                        <h3 class="text-month" id="modal-headline">
                            Add event
                        </h3>
                    </div>
                    <span class="w-full p-[1px] bg-red1 opacity-10"></span>

                    <form>
                        <div class="flex flex-col mt-4">


                            <div class="mt-4">
                                <input class="input-modal w-full" type="text" wire:model="name"
                                       placeholder="Name"/>
                                @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
                            </div>
                            <div class="mt-4">
                                <input class="input-modal w-full" type="text" wire:model="description"
                                       placeholder="Description"/>
                                @error('description') <span class="text-red-500">{{ $message }}</span> @enderror
                            </div>
                            <div class="mt-4">
                                <input class="input-modal w-full" type="text" wire:model="location"
                                       placeholder="Location"/>
                                @error('location') <span class="text-red-500">{{ $message }}</span> @enderror
                            </div>
                                <div class="mt-4">
                                    <div class="flex flex-row items-center">
                                        <span class="ml-2 date">{{ Carbon\Carbon::parse($selectedDate)->format('j F') }}</span>
                                        <div class="ml-2 w-full relative">
                                        <input class="w-full input-modal" type="time" wire:model="start_time" placeholder="Event Start Time"/>
                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                                <!-- SVG arrow icon -->
                                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                    <path d="M5.516 7.548c0.436-0.446 1.043-0.481 1.576 0l3.908 3.747 3.908-3.747c0.533-0.481 1.141-0.446 1.576 0 0.436 0.445 0.408 1.197 0 1.615l-4.695 4.502c-0.408 0.392-1.064 0.392-1.472 0l-4.695-4.502c-0.408-0.418-0.436-1.17 0-1.615z"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <div class="w-full relative mt-4">
                                <div x-data="{ open: false, selected: '', currentType: null }"  @click.away="open = false">


                                    <div class="relative">
                                        <input x-model="selected" @click="open = true" class="input-modal w-full" placeholder="{{ __('Select event type') }}">
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                            <!-- SVG arrow icon -->
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path d="M5.516 7.548c0.436-0.446 1.043-0.481 1.576 0l3.908 3.747 3.908-3.747c0.533-0.481 1.141-0.446 1.576 0 0.436 0.445 0.408 1.197 0 1.615l-4.695 4.502c-0.408 0.392-1.064 0.392-1.472 0l-4.695-4.502c-0.408-0.418-0.436-1.17 0-1.615z"/>
                                            </svg>
                                        </div>
                                        <div x-show="open" class="absolute z-40 bg-dark1 dropdown-text divide-y divide-gray-100 rounded-lg w-full">
                                            <div class="p-1" wire:click.stop style="max-height: 200px; overflow-y: auto;">
                                                @foreach ($eventTypes as $type)
                                                    <p @click="selected = '{{ $type->event_type }}'; selectedTypeId = '{{ $type->id }}'; open = false; $wire.type_id = '{{ $type->id }}'"
                                                       class="p-2 hover:bg-blue-500 hover:text-white">
                                                        {{ $type->event_type }}
                                                    </p>
                                                @endforeach
                                            </div>
                                        </div>
                                        @error('type_id') <span class="text-red-500">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-row-reverse w-full p-2 mt-4">
                            <button class="add-button" wire:click="saveEvent()">Add</button>
                            <button x-on:click="open = false; addEventModal = false" type="button"
                                    class="button-no-bg mr-2">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

