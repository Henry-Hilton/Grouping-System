<?php
session_start();
require_once 'classes/Database.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$idthread = $_GET['id'];
$currentUser = $_SESSION['username'];
$db = new Database();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['close_thread'])) {
    $sql_close = "UPDATE thread SET status = 'Closed' WHERE idthread = ? AND username_pembuat = ?";
    $stmt = $db->prepare($sql_close);
    $stmt->bind_param("is", $idthread, $currentUser);
    $stmt->execute();
    header("Location: group_chat.php?id=" . $idthread);
    exit();
}

$sql = "SELECT * FROM thread WHERE idthread = ?";
$stmt = $db->prepare($sql);
$stmt->bind_param("i", $idthread);
$stmt->execute();
$thread = $stmt->get_result()->fetch_assoc();

if (!$thread) {
    die("Thread not found.");
}

$isCreator = ($thread['username_pembuat'] === $currentUser);
$isClosed = ($thread['status'] === 'Closed');

$backLink = "group_threads.php?id=" . $thread['idgrup'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Room #<?php echo $idthread; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

    <div class="container">
        <div class="dashboard-header">
            <div style="display: flex; align-items: center; gap: 15px;">
                <a href="<?php echo $backLink; ?>" class="btn-cancel">← Back to Threads</a>
                <h1 style="margin: 0;">Chat Room #<?php echo $idthread; ?></h1>
                <span class="badge" style="background-color: <?php echo $isClosed ? '#6c757d' : '#28a745'; ?>">
                    <?php echo $thread['status']; ?>
                </span>
            </div>

            <?php if ($isCreator && !$isClosed) { ?>
                <div class="header-actions">
                    <form method="POST" onsubmit="return confirm('Are you sure? Once closed, no one can reply.');">
                        <input type="hidden" name="close_thread" value="1">
                        <button type="submit" class="btn-delete">Close Thread</button>
                    </form>
                </div>
            <?php } ?>
        </div>

        <div class="chat-window" id="chat-box">
            <p style="text-align:center; color:grey;">Loading messages...</p>
        </div>

        <?php if (!$isClosed) { ?>
            <div class="chat-input-area">
                <textarea id="chat-input" class="form-control" style="flex:1; padding:10px;" rows="2"
                    placeholder="Type a message..."></textarea>
                <button id="btn-send" class="btn-submit">Send</button>
            </div>
        <?php } else { ?>
            <div class="alert alert-warning" style="background:#fff3cd; color:#856404; padding:15px; border-radius:5px;">
                This thread is closed. You can view the history but cannot reply.
            </div>
        <?php } ?>

    </div>

    <script>
        $(document).ready(function () {
            console.log("Chat initialized");

            var currentThreadId = <?php echo $idthread; ?>;
            var userScrolled = false;

            // Detect Scroll
            $('#chat-box').scroll(function () {
                if ($('#chat-box').scrollTop() + $('#chat-box').innerHeight() >= $('#chat-box')[0].scrollHeight - 10) {
                    userScrolled = false;
                } else {
                    userScrolled = true;
                }
            });

            // LOAD CHAT (Uses PLURAL filename)
            function loadChat() {
                $.ajax({
                    // CHECK THIS: It must match your file name 'get_new_messages.php'
                    url: 'ajax/get_new_messages.php',
                    method: 'POST',
                    data: { idthread: currentThreadId },
                    dataType: 'json',
                    success: function (data) {
                        var html = '';
                        if (data.length === 0) {
                            html = '<p style="text-align:center; color:#999; margin-top:20px;">No messages yet.</p>';
                        } else {
                            $.each(data, function (index, chat) {
                                var bubbleClass = chat.is_me ? 'my-message' : 'other-message';
                                var nameDisplay = chat.is_me ? 'You' : chat.sender_name;
                                html += '<div class="chat-bubble ' + bubbleClass + '">';
                                html += '<strong>' + nameDisplay + '</strong><br>';
                                html += chat.isi;
                                html += '<span class="chat-meta">' + chat.formatted_time + '</span>';
                                html += '</div>';
                            });
                        }
                        $('#chat-box').html(html);
                        if (!userScrolled) {
                            $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
                        }
                    },
                    error: function (xhr, status, error) {
                        // This logs the 404 if the name is still wrong
                        console.error("Load Chat Error:", xhr.status, xhr.statusText);
                        console.error("Trying to find: ajax/get_new_messages.php");
                    }
                });
            }

            // SEND MESSAGE (Uses SINGULAR filename)
            function sendMessage() {
                var msg = $('#chat-input').val();
                if (msg.trim() !== '') {
                    // CHECK THIS: It must match your file name 'post_chat_message.php'
                    $.post('ajax/post_chat_message.php', {
                        message: msg,
                        idthread: currentThreadId
                    }, function (response) {
                        if (response.trim() === 'success') {
                            $('#chat-input').val('');
                            loadChat();
                            userScrolled = false;
                        } else {
                            alert('Error sending message: ' + response);
                        }
                    }).fail(function () {
                        alert("Error: Could not find ajax/post_chat_message.php");
                    });
                }
            }

            // Event Listeners
            $('#btn-send').click(function (e) {
                e.preventDefault();
                sendMessage();
            });

            $('#chat-input').keypress(function (e) {
                if (e.which == 13 && !e.shiftKey) {
                    e.preventDefault();
                    sendMessage();
                }
            });

            // Start
            loadChat();
            setInterval(loadChat, 2000);
        });
    </script>
</body>

</html>