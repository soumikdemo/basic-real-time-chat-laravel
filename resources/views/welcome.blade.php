<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Chat</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="app">
        <header>
            <h1>Let's Chat</h1>
            <input type="text" name="username" id="username" placeholder="Please enter username" />
        </header>

        <div id="messages"></div>

        <form id="message_form">
            <input type="text" name="message" id="message_input" placeholder="Write your message" />
            <button type="submit" id="message_send">Send Message</button>
        </form>
    </div>

    <script type="text/javascript">
        // listening to channel event after window is ready
        window.addEventListener('load', function() {
            window.Echo.channel('chat').listen('.message', (e) => {
                // handling event response
                messages_el.innerHTML += '<div class="message"><strong>' + e.username + ':</strong> ' + e.message + '</div>';
            });
        });

        const messages_el = document.getElementById('messages');
        const username_input = document.getElementById('username');
        const message_input = document.getElementById('message_input');
        const message_form = document.getElementById('message_form');

        message_form.addEventListener('submit', function(e) {
            e.preventDefault();
            let has_errors = false;

            if(username_input.value == '') {
                alert('Please enter a username');
                has_errors = true;
            }

            if(message_input.value == '') {
                alert('Please enter a message');
                has_errors = true;
            }

            if(has_errors) {
                return;
            }

            const options = {
                method: 'POST',
                url: '/send-message',
                data: {
                    username: username_input.value,
                    message: message_input.value
                }
            }

            axios(options);
        });

    </script>
</body>
</html>