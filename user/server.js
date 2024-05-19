const express = require('express');
const bodyParser = require('body-parser');
const twilio = require('twilio');
const app = express();

app.use(bodyParser.json());

const accountSid = ''; // Your Account SID from www.twilio.com/console
const authToken = '';   // Your Auth Token from www.twilio.com/console
const client = new twilio(accountSid, authToken);

app.post('/save-and-send-sms', (req, res) => {
    const data = req.body;

    // Save the data to your database (not implemented in this example)
    // ...

    // Send SMS using Twilio
    client.messages.create({
        body: 'Your registration is successful. Please bring the following requirements: -Zone Clearance.',
        to: '+63' + data.contact_no,  // the phone number from the form
        from: ' ' // your Twilio number
    })
    .then((message) => {
        res.json({ success: true, messageSid: message.sid });
    })
    .catch((error) => {
        console.error(error);
        res.json({ success: false, message: error.message });
    });
});

app.listen(80, () => {
    console.log('Server is running on port 80');
});


