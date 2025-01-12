// modalin sulkeminen
//modal closing
function closeReservationWindow() {
    const modal = document.getElementById('reservation-modal');
    if (modal) {
        modal.remove();
    }
}

//uuden auton lisäyksen form
//Add new car form
function toggleNewCarField() {
    const carSelect = document.getElementById('car-select');
    const newCarField = document.getElementById('new-car-field');

    if (carSelect.value === 'add_new') {
        newCarField.classList.remove('hidden');
    } else {
        newCarField.classList.add('hidden');
    }
}
