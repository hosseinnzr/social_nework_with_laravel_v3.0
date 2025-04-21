<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: /');
    exit;
}
require 'db.php'; 

$stmt = $pdo->query('SELECT user_name FROM users');
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <!-- CSS only -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>

<style>
html, body {
    height: 100%;
}
body {
    display: flex;
    flex-direction: column;
}
.container {
    flex: 1;
}
.msg-list {
    max-height: 90vh;
    overflow-y: scroll;
    list-style: none;
    padding: 0;
}

.msg-list {
    max-height: 400px;
    overflow-y: scroll;
    list-style: none;
    padding: 10px;
}
.msg-list li {
    word-wrap: break-word;
}
.text-right {
    text-align: right;
    margin-left: auto;
}
.text-left {
    text-align: left;
    margin-right: auto;
}

.chat-container {
    height: 55vh;
    margin: 0px;
    overflow-y: auto;
    padding: 10px;
    border: 1px solid #ccc;
    background: #f9f9f9;
}
</style>

<body>

    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
            <a class="navbar-brand" href="user/<?php echo htmlspecialchars($_SESSION['user']['user_name']); ?>">
                <?php echo htmlspecialchars($_SESSION['user']['user_name']); ?>
            </a>
        <div class="ml-auto">
            
            <span class="navbar navbar-expand-lg navbar-dark bg-warning">
                <a style="color: #000000;" href="/">thezoom</a>
            </span>
        </div>
    </nav>

<!-- <link rel="stylesheet" href="assets/style.css"> -->

    <!-- Main -->
    <div class="container">
        <br>
        <div class="row">
            <div class="col-md-4">
                <br>
                <ul class="list-group" id="usersList">
                    <?php foreach($users as $user): ?>
                        <li class="list-group-item user-item" data-username="<?php echo htmlspecialchars($user['user_name']); ?>">
                            <?php echo htmlspecialchars($user['user_name']); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="col-md-8">
            
                <div id="chatWith" style="font-weight:bold; font-size:18px; margin-bottom:10px;"></div>

                <div class="row">

                    <div class="col-md-12">
                        <ul class="msg-list chat-container">
                        </ul>
                    </div>

                </div>

                <form method="post" id="chatForm">
                    <div class="form-group">
                        <label for="message"></label>
                        <input type="text" name="message" id="message" class="form-control" />
                    </div>
                    <div>
                        <input type="submit" id="subBtn" class="btn btn-info" value="send">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-light text-center text-lg-start mt-4">
        <div class="text-center p-3" style="background-color: #f1f1f1;">
            © <?php echo date('Y'); ?> ساخته شده با ❤️
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    var username = "<?php echo $_SESSION['user']['user_name']; ?>"; 
    var conn = null;
    var selectedUser = null;
    var chatForm = $('#chatForm');
    var userMessage = $("#message");
    var msgList = $('.msg-list');

    // وقتی روی یک کاربر کلیک می‌کنیم
    $(document).on('click', '.user-item', function() {
        selectedUser = $(this).data('username');
        msgList.html('');
        $('#chatWith').text(selectedUser); // نمایش بالای صفحه

        if (conn) {
            conn.close(); // بستن اتصال قبلی
        }

        // اتصال جدید به WebSocket
        var host = window.location.hostname;
        conn = new WebSocket('ws://' + host + ':8080?username=' + username + '&target_user=' + selectedUser);

        conn.onopen = function(e) {
            console.log("Connected to chat with " + selectedUser);
        };

        conn.onmessage = function(e) {
            var data = JSON.parse(e.data);
            var isOwnMessage = (data.user === username);

            var alignmentStyle = isOwnMessage ? "justify-content: flex-end;" : "justify-content: flex-start;";
            var bgColor = isOwnMessage ? "#DCF8C6" : "#F1F0F0";

            msgList.append(
                "<li style='display: flex; " + alignmentStyle + " margin:5px 0;'>" +
                    "<div style='background:" + bgColor + "; padding:8px; border-radius:10px; max-width:70%;'>" +
                        "<strong>" + data.user + ":</strong> " + data.message + "<br><small>(" + data.created_at + ")</small>" +
                    "</div>" +
                "</li>"
            );
            
            if (!isOwnMessage) {
                scrollToBottom();
            }
        };

        conn.onclose = function(e) {
            console.log("Disconnected from chat.");
        };

        conn.onerror = function(e) {
            console.log("Error: ", e);
        };

        // لود پیام‌های قبلی
        $.ajax({
            url: 'load_messages.php',
            method: 'POST',
            data: {
                target_user: selectedUser
            },
            success: async function(response) {
                var messages = JSON.parse(response);

                for (const msg of messages) {
                    var isOwnMessage = (msg.sender_id === username);
                    var alignmentStyle = isOwnMessage ? "justify-content: flex-end;" : "justify-content: flex-start;";
                    var bgColor = isOwnMessage ? "#DCF8C6" : "#F1F0F0";

                    await new Promise((resolve) => {
                        msgList.append(
                            "<li style='display: flex; " + alignmentStyle + " margin:5px 0;'>" +
                                "<div style='background:" + bgColor + "; padding:8px; border-radius:10px; max-width:70%;'>" +
                                    "<strong>" + msg.sender_id + ":</strong> " + msg.body + "<br><small>(" + msg.created_at + ")</small>" +
                                "</div>" +
                            "</li>"
                        );
                        resolve(); // حل کردن پرامیس بعد از append
                    });
                    scrollToBottom();
                }
            }
        });

    });

    // ارسال پیام
    chatForm.on('submit', function(e) {
        e.preventDefault();
        var message = userMessage.val();

        if (!selectedUser) {
            alert('لطفا ابتدا کاربری را انتخاب کنید');
            return;
        }

        conn.send(JSON.stringify({
            type: 'private',
            user: username,
            target: selectedUser,
            message: message
        }));

        // اینجا مثل مثال خودت:
        var alignmentStyle = "justify-content: flex-end;";
        var bgColor = "#DCF8C6"; // رنگ سبز پیام‌های خود کاربر

        msgList.append(
            "<li style='display: flex; " + alignmentStyle + " margin:5px 0;'>" +
                "<div style='background:" + bgColor + "; padding:8px; border-radius:10px; max-width:70%;'>" +
                    "<strong>" + username + ":</strong> " + message + 
                "</div>" +
            "</li>"
        );

        userMessage.val(''); // پاک کردن اینپوت بعد ارسال

        scrollToBottom(); // بعد از ارسال پیام، اسکرول بره پایین
    });


    // اسکرول خودکار پایین
    function scrollToBottom() {
        $('.chat-container').scrollTop($('.chat-container')[0].scrollHeight);
    }

    </script>

</body>
</html>