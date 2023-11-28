import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


document.addEventListener('livewire:load', function () {
    window.addEventListener('positionModal', function (event) {
        setPosition(event);
    });
    window.addEventListener("unhandledrejection", function (event) {
        console.warn("Unhandled promise rejection:", event.reason);
    });
    // Listen for the dateSelected event and emit an event to Livewire
    window.addEventListener('dateSelected', event => {
        Livewire.emit('updateDate', event.detail);
    });
    // Ensure it's set to only allow time selection
    $('#timePicker').datetimepicker({
        format: 'HH:mm',
        useCurrent: false,
    });

    // Update the time picker when the start_datetime changes
    Livewire.on('updateStartDateTime', function (startDateTime) {
        $('#timePicker').datetimepicker('date', startDateTime);
    });
    function setPosition(event) {
        let modal = document.getElementById('event-modal');
        let rect = event.target.getBoundingClientRect();
        let top = rect.top + window.scrollY;
        let left = rect.left + window.scrollX;

        let modalWidth = modal.offsetWidth;
        let modalHeight = modal.offsetHeight;
        let newLeft = left + rect.width / 2 - modalWidth / 2;
        let newTop = top + rect.height;

        // Adjust if modal goes off-screen
        if (newLeft + modalWidth > window.innerWidth) {
            newLeft = window.innerWidth - modalWidth;
        }
        if (newTop + modalHeight > window.innerHeight) {
            newTop = top - modalHeight;
        }


        Alpine.store('modalPosition').modalTop = newTop;
        Alpine.store('modalPosition').modalLeft = newLeft;
    }
});
