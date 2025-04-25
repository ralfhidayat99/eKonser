document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('ticket-types-container');
    const addButton = document.getElementById('add-ticket-type');

    function updateRemoveButtons() {
        const removeButtons = container.querySelectorAll('.btn-remove-ticket');
        removeButtons.forEach(button => {
            button.removeEventListener('click', removeTicket);
            button.addEventListener('click', removeTicket);
        });
    }

    function removeTicket(event) {
        event.target.closest('.ticket-type').remove();
        updateIndexes();
    }

    function updateIndexes() {
        const ticketTypes = container.querySelectorAll('.ticket-type');
        ticketTypes.forEach((ticketType, index) => {
            ticketType.querySelectorAll('input, select').forEach(input => {
                const name = input.getAttribute('name');
                const newName = name.replace(/tickets\[\d+\]/, `tickets[${index}]`);
                input.setAttribute('name', newName);
            });
        });
    }

    addButton.addEventListener('click', () => {
        const index = container.querySelectorAll('.ticket-type').length;
        const newTicketType = document.createElement('div');
        newTicketType.classList.add('ticket-type', 'row', 'mb-2');
        newTicketType.innerHTML = `
            <div class="col-3">
                <input type="text" name="tickets[${index}][name]" class="form-control" placeholder="Name" required>
            </div>
            <div class="col-2">
                <input type="number" name="tickets[${index}][price]" class="form-control" placeholder="Price" min="0" step="0.01" required>
            </div>
            <div class="col-2">
                <input type="number" name="tickets[${index}][quota]" class="form-control" placeholder="Quota" min="1" required>
            </div>
            <div class="col-3">
                <select name="tickets[${index}][type]" class="form-control" required>
                    <option value="">Select Type</option>
                    <option value="standing">Standing</option>
                    <option value="seated">Seated</option>
                </select>
            </div>
            <div class="col-2">
                <button type="button" class="btn btn-danger btn-remove-ticket">Remove</button>
            </div>
        `;
        container.appendChild(newTicketType);
        updateRemoveButtons();
    });

    updateRemoveButtons();
});
