<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: /');
    exit;
}
require 'db.php'; 

$stmt = $pdo->prepare("SELECT user_name FROM users WHERE user_name != :username");
$stmt->execute([':username' => $_SESSION['user']['user_name']]);
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
    height: 60vh;
    margin: 0px;
    overflow-y: auto;
    padding: 10px;
    border: 1px solid #ccc;
    background: #f9f9f9;
    border-radius: 0px 0px 5px 5px;
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

            <!-- show user in mobile mode-->
            <button id="showUsersBtn" class="btn btn-warning d-block d-md-none" style="margin-left: 15px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
                <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5"/>
                </svg>
            </button>

            <!-- in Mobile -->
            <div id="usersModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; 
                background-color: rgba(0,0,0,0.6); z-index: 9999; justify-content: center; align-items: center;">

                <div style="background: white; padding: 20px; border-radius: 10px; width: 90%; max-width: 400px;">
                  <button id="closeUsersModal" class="btn btn-secondary" style="margin-bottom: 10px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 20">
                        <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                        </svg>
                  </button>
                    <ul class="list-group" id="usersListModal">
                        <?php foreach($users as $user): ?>
                            <li class="list-group-item user-item" data-username="<?php echo htmlspecialchars($user['user_name']); ?>">
                                <?php echo htmlspecialchars($user['user_name']); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <!-- in Desktop  -->
            <div class="col-md-4 d-none d-md-block">
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
            
                <!-- show message header -->
                <div style="display: flex; align-items: center; padding: 5px; margin-top:10px; background: #ccc; 
                border-radius: 5px 5px 0px 0px;">
                    <div id="chatWith" style=" padding-left: 3px; font-weight:bold; font-size:18px; margin-right:10px;"></div>
                    <div id="typing" style="font-size:14px; color: #ff8000;"></div>
                </div>

                <!-- show message main -->
                <div class="row">
                    <div class="col-md-12">
                        <ul class="msg-list chat-container">
                        </ul>
                    </div>
                </div>

                <!-- send messange form -->
                <form method="post" id="chatForm" style="margin-top: 10px;">
                    <div style="display: flex; align-items: center;">
                        <input 
                            type="text" 
                            name="message" 
                            placeholder="Message..." 
                            id="message" 
                            class="form-control" 
                            style="flex: 1; border-top-left-radius: 5px; border-bottom-left-radius: 5px; border-right: none;"
                        />
                        <input 
                            type="submit" 
                            id="subBtn" 
                            class="btn btn-info" 
                            value="Send"
                            style="border-top-left-radius: 0; border-bottom-left-radius: 0; border-top-right-radius: 5px; border-bottom-right-radius: 5px;"
                            disabled
                        >
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-light text-center text-lg-start mt-4">
        <div class="text-center p-3" style="background-color: #f1f1f1;">
            © <?php echo date('Y'); ?> ❤️ ساخته شده با 
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- modal script -->
    <script>
        document.getElementById('showUsersBtn').addEventListener('click', function() {
            document.getElementById('usersModal').style.display = 'flex';
        });

        document.getElementById('closeUsersModal').addEventListener('click', function() {
            document.getElementById('usersModal').style.display = 'none';
        });
    </script>

    <!-- web socket caht script -->
    <script>
        var username = "<?php echo $_SESSION['user']['user_name']; ?>"; 
        var conn = null;
        var selectedUser = null;
        var chatForm = $('#chatForm');
        var userMessage = $("#message");
        var msgList = $('.msg-list');

        // show typing
        userMessage.on('input', function() {
        if (conn && selectedUser) {
            conn.send(JSON.stringify({
                type: 'typing',
                user: username,
                target: selectedUser
            }));
        }
        });

        // وقتی روی یک کاربر کلیک می‌کنیم
        $(document).on('click', '.user-item', function() {
            selectedUser = $(this).data('username');
            msgList.html('');
            $('#chatWith').text(selectedUser); // show user_name

            // close old connection
            if (conn) {
                conn.close();  
            }

            // connect to WebSocket
            var host = window.location.hostname;
            conn = new WebSocket('ws://' + host + ':8080?username=' + username + '&target_user=' + selectedUser);

            conn.onopen = function(e) {
                console.log("Connected to chat with " + selectedUser);
            };

            conn.onmessage = function(e) {
                var data = JSON.parse(e.data);

                if (data.type === 'typing') {
                    if (data.user === selectedUser) {
                        $('#typing').text(" typing...");
                        
                        clearTimeout(window.typingTimeout);
                        window.typingTimeout = setTimeout(function() {
                            $('#typing').text("");
                        }, 2000);
                    }
                    return;
                }

                var isOwnMessage = (data.user === username);
                var alignmentStyle = isOwnMessage ? "justify-content: flex-end;" : "justify-content: flex-start;";
                var bgColor = isOwnMessage ? "#ffbf0078" : "#F1F0F0";

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


            // disabled and ensabled send button
            conn.onopen = function(e) {
                $('#subBtn').prop('disabled', false); // active send button
            };

            conn.onclose = function(e) {
                console.log("Disconnected from chat.");
                $('#subBtn').prop('disabled', true); // deactivate send button
            };

            conn.onerror = function(e) {
                console.log("Error: ", e);
                $('#subBtn').prop('disabled', true); // deactivate send button
            };


            // load last message
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
                        var bgColor = isOwnMessage ? "#ffbf0078" : "#F1F0F0";

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
                        setTimeout(() => {
                            scrollToBottom();
                        }, 1000); 
                    }
                }
            });

        });

        // send message
        chatForm.on('submit', function(e) {
            e.preventDefault();
            var message = userMessage.val();

            if (!selectedUser) {
                document.getElementById('usersModal').style.display = 'flex';
            }

            conn.send(JSON.stringify({
                type: 'private',
                user: username,
                target: selectedUser,
                message: message
            }));

            // شبیه سازی پیام خودت بدون نیاز به سرور
            var now = new Date();
            var currentTime = now.getFullYear() + '-' +
                            String(now.getMonth() + 1).padStart(2, '0') + '-' +
                            String(now.getDate()).padStart(2, '0') + ' ' +
                            String(now.getHours()).padStart(2, '0') + ':' +
                            String(now.getMinutes()).padStart(2, '0') + ':' +
                            String(now.getSeconds()).padStart(2, '0');

            var alignmentStyle = "justify-content: flex-end;";
            var bgColor = "#ffbf0078";

            msgList.append(
                "<li style='display: flex; " + alignmentStyle + " margin:5px 0;'>" +
                    "<div style='background:" + bgColor + "; padding:8px; border-radius:10px; max-width:70%;'>" +
                        "<strong>" + username + ":</strong> " + message + "<br><small>(" + currentTime + ")</small>" +
                    "</div>" +
                "</li>"
            );

            userMessage.val(''); // پاک کردن اینپوت
            scrollToBottom();
        });

        // scroll Down  
        function scrollToBottom() {
            $('.chat-container').scrollTop($('.chat-container')[0].scrollHeight);
        }
    </script>

</body>
</html>