<div class="mt-4">
    <p class="text-center">
        Previous Number: <span id="previousTicket">0000</span><br>
        Current Number: <span id="currentTicket">0001</span><br>
        Prepare Next Number: <span id="nextTicket">0002</span>
    </p>
</div>
<script>
    const queue = [];
    const liveMonitorElement = document.getElementById("liveMonitor");
    const currentTicketElement = document.getElementById("currentTicket");
    const previousTicketElement = document.getElementById("previousTicket");
    const nextTicketElement = document.getElementById("nextTicket");
    let ticketNumber;
    let counter = 0; // Initialize counter

    // Function to go back in history
    function goBack() {
        window.history.back();
    }

    // Function to reset ticket number to zero
    function resetTicketNumberToZero() {
        localStorage.removeItem("ticketNumber");
        ticketNumber = 1; // Change to 0
        updateCurrentTicket();
    }


    // Function to generate next ticket
    function generateNextTicket() {
        const nextTicket = (ticketNumber++).toString().padStart(4, "0"); // Add leading zeros
        updateLiveMonitor(`Prepare Next Ticket: ${nextTicket}`);
        updateCurrentTicket();
        // Store the updated ticket number in localStorage
        localStorage.setItem("ticketNumber", ticketNumber);
    }

    // Function to reset ticket number to zero
    function resetTicketNumber() {
        if (localStorage.getItem("ticketNumber")) {
            // If ticket number is already stored in localStorage, retrieve it
            ticketNumber = parseInt(localStorage.getItem("ticketNumber"));
        } else {
            // If ticket number is not stored, initialize it to 1
            ticketNumber = 1;
        }
        updateCurrentTicket();
    }

    // Call resetTicketNumber function on page load to reset the ticket number
    resetTicketNumber();

    // Function to generate next ticket
    function generateNextTicket() {
        const nextTicket = ticketNumber.toString().padStart(4, "0"); // Add leading zeros
        updateLiveMonitor(`Current Number: ${nextTicket}`);
        ticketNumber++;
        updateCurrentTicket();
        // Store the updated ticket number in localStorage
        localStorage.setItem("ticketNumber", ticketNumber);
    }

    // Function to update current ticket number
    function updateCurrentTicket() {
        const formattedTicketNumber = (ticketNumber - 1).toString().padStart(4, "0");
        currentTicketElement.textContent = formattedTicketNumber;

        // Update previous and next ticket numbers
        previousTicketElement.textContent = (ticketNumber - 1).toString().padStart(4, "0");
        nextTicketElement.textContent = (ticketNumber).toString().padStart(4, "0");
    }



    function renderQueue() {
        const queueElement = document.getElementById("queue");
        queueElement.innerHTML = queue
            .map(
                (customer, index) =>
                    `<li class="queue-item rounded-md bg-teal-300 w-80 h-24 mt-5" id="queue-item-${index + 1
                    }">${index + 1}. ${customer.name} </br>(Ticket ${customer.ticket
                    })</li>`
            )
            .join("");
    }

    function updateLiveMonitor(message) {
        liveMonitorElement.innerHTML =
            `<p>${message}</p>` + liveMonitorElement.innerHTML;
    }

    function announceCustomer(customerName) {
        // For simplicity, use an alert as a placeholder for announcing the customer
        alert(`Now serving Customer ${customerName}`);
    }

    function incrementCounter() {
        counter++;
        // If counterElement is defined, update its content
        const counterElement = document.getElementById("counter");
        if (counterElement) {
            counterElement.textContent = counter;
        }
    }

    function updateCurrentTicket() {
        const formattedTicketNumber = ticketNumber.toString().padStart(4, "0");
        currentTicketElement.textContent = formattedTicketNumber;

        // Update previous and next ticket numbers
        previousTicketElement.textContent = (ticketNumber - 1).toString().padStart(4, "0");
        nextTicketElement.textContent = (ticketNumber + 1).toString().padStart(4, "0");
    }
</script>

<!-- Bootstrap JS (optional, for certain components like modals, dropdowns, etc.) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>