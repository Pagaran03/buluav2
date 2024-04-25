<div class="container-fluid">
    <button type="button" class="btn btn-primary" onclick="goBack()" style="margin: 10px;">
        <i class="fa fa-arrow-circle-left"></i> Back
    </button>
    <button class="btn btn-success" onclick="generateNextTicket()">Next</button>
    <button class="btn btn-danger" onclick="resetTicketNumberToZero()">Reset Ticket Number to Zero</button>
    <button id="printButton">Print</button>

</div>

<div class="container-fluid">


</div>

<div class="row">
    <div class="d-flex ">
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="mt-4">
                        <div class="queue-container">
                            <h2 class="text-center text-black display-4 mb-4">
                                Now Serving
                            </h2>
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="">
                            Previous Number: <span id="previousTickets">0000</span><br>
                            Previous Number: <span id="previousTicket">0000</span><br>
                            Current Number: <span id="currentTicket">0001</span><br>
                            Prepare Next Number: <span id="nextTicket">0002</span><br>
                            Prepare Next Number: <span id="nextTickets">0003</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<br><br>



<script>
    let ticketNumber;
    const currentTicketElement = document.getElementById("currentTicket");
    const previousTicketElement = document.getElementById("previousTicket");
    const previousTicketsElement = document.getElementById("previousTickets");
    const nextTicketElement = document.getElementById("nextTicket");
    const nextTicketsElement = document.getElementById("nextTickets");

    // Function to go back in history
    function goBack() {
        window.history.back();
    }

    // Function to reset ticket number to zero
    function resetTicketNumberToZero() {
        localStorage.removeItem("ticketNumber");
        ticketNumber = 1; // Reset ticket number to 1
        updateCurrentTicket();
    }

    // Function to generate next ticket
    function generateNextTicket() {
        const nextTicket = ticketNumber.toString().padStart(4, "0"); // Add leading zeros
        ticketNumber++;
        updateCurrentTicket();
        // Store the updated ticket number in localStorage
        localStorage.setItem("ticketNumber", ticketNumber);
    }

    // Function to reset ticket number
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

    // Function to update current ticket number
    function updateCurrentTicket() {
        const formattedTicketNumber = ticketNumber.toString().padStart(4, "0");
        currentTicketElement.textContent = formattedTicketNumber;

        // Update previous and next ticket numbers
        previousTicketsElement.textContent = (ticketNumber - 2).toString().padStart(4, "0");
        previousTicketElement.textContent = (ticketNumber - 1).toString().padStart(4, "0");
        nextTicketElement.textContent = (ticketNumber + 1).toString().padStart(4, "0");
        nextTicketsElement.textContent = (ticketNumber + 2).toString().padStart(4, "0");
    }

    // Function to generate and print numbers from 1 to 150
    function printNumberQueue() {
        let queueNumbers = '';
        for (let i = 1; i <= 150; i++) {
            queueNumbers += i + '\n';
        }
        window.print(queueNumbers);
    }

    // Attach event listener to the "Print" button
    document.getElementById("printButton").addEventListener("click", printNumberQueue);

</script>

<!-- Bootstrap JS (optional, for certain components like modals, dropdowns, etc.) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>