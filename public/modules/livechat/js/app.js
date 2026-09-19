"use strict";

var chat_token = $('meta[name="csrf-token"]').attr("content");
if (!chat_token || chat_token == "" || chat_token == null || chat_token == undefined) {
    chat_token = $('meta[name="csrf_token"]').attr("content");
}
var chat_url = $("meta[name='baseurl']").attr("content");
if (!chat_url || chat_url == "" || chat_url == null || chat_url == undefined) {
    chat_url = $('#url').val();
}

function playSound() {
    var audio = document.getElementById("message_sound");
    if (audio.paused || audio.currentTime === 0) {
        // Play the audio
        audio.play().catch(function (error) {

        });
    }
}

$(document).ready(function () {
    var container = $(".chatShow");
    function scrollToBottom() {
        container.scrollTop(container.prop("scrollHeight"));
    }
    scrollToBottom();
    container.on("DOMNodeInserted", scrollToBottom);
});


function messageRead(msg) {
    $.ajax({
        type: "GET",
        dataType: "json",
        url: chat_url + "/live-chat/message-read/" + msg,
        success: function (res) {

        },
        error: function (data) {

        },
    });
}



function htmlShow(data, className) {
    let chatActiveUser = $('#chat_active_user').val();
    let html = `<div class="single-chat ${className}" id="message">
            <div class="chatText">
                <div class="chatImg">
                    <img src="${data.image}" alt="img" class="img-cover">
                </div>
                <div class="chatCaption">
                    <p class="chatPera"> ${data.message}</p>
                    <p class="time"> ${data.created_at}</p>
                </div>
            </div>
        </div>`;

    if (className == 'userMessage') {
        if (chatActiveUser == data.sender_id) {
            $(".chatShow").append(html);
        }
    } else {
        $(".chatShow").append(html);
    }

}

function updateLastMessage(data, messageFor) {
    let receiver_id = data.receiver_id;
    if (messageFor === 'userMessage') {
        receiver_id = data.sender_id
    }
    let receiverDiv = $(".chat-list #receiver_id_" + receiver_id);
    receiverDiv.addClass('has-unread-message');

    if (messageFor === 'adminMessage') {
        receiverDiv.removeClass('has-unread-message');
    }
    let chatParagraph = receiverDiv.find('p.chat');
    chatParagraph.text('');
    chatParagraph.text(data.message);
}

// function lastMessage(){
//     $.ajax({
//         type: "GET",
//         dataType: "json",
//         url: chat_url + "/live-chat/last-message/" + receiver,
//         success: function (res) {
//             if (res.result == true) {
//                 updateLastMessage(res.data, 'userMessage');
//             }
//         },
//         error: function (data) {
//         },
//     });
// }

$(document).on("click", "#message_sent", function () {
    let message = $("#chat_text").val();
    let formData = {
        message: message,
    };

    if (message != "" && message != null && message != undefined) {
        $.ajax({
            type: "POST",
            dataType: "json",
            data: formData,
            headers: {
                "X-CSRF-TOKEN": chat_token,
            },
            url: $(this).data("url"),
            success: function (res) {
                if (res.result == true) {
                    $("#chat_text").val("");
                    $("#chat_text").focus();
                    htmlShow(res.data, "adminMessage");
                    updateLastMessage(res.data, 'adminMessage');
                    chatList();
                }
            },
            error: function (data) {
            },
        });
    } else {
        toaster.fire({
            icon: "error",
            title: enter_field,
        });
    }
});

if ($("#app_key").length > 0) {
    let receiver = $("#receiver_id").val();

    var pusher = new Pusher($("#app_key").val(), {
        cluster: $("#cluster").val() ?? "ap1",
        encrypted: true,
    });

    var channel = pusher.subscribe("receiver_channel" + receiver);

    channel.bind("my-event", (data) => {
        // messageRead(data?.receiver_id)
        htmlShow(data, "userMessage");
        updateLastMessage(data, "userMessage");
        playSound();
    });
}

let chat_page = 1;
var total_chat_page = 1;
function chatList() {

    let formData = {
        key: $("#chat_search").val(),
        user_id: $("#current_user").data("id"),
    };

    $.ajax({
        type: "GET",
        dataType: "json",
        data: formData,
        url: $(".chat-list").data("url") + "?page=" + chat_page,
        success: function (res) {
            chat_page++;
            if (res.result == true) {
                total_chat_page = res?.data?.last_page;
                $(".chat-list").append(res.data?.html);
            }
        },
        error: function (data) {
        },
    });
}
chatList();



$('.chat-list').on('scroll', function () {
    var chatListElement = $(this);
    if (chatListElement.scrollTop() + chatListElement.innerHeight() >= chatListElement[0].scrollHeight) {
        if (chat_page <= total_chat_page) {
            chatList();
        }
    }
});

function searchChat() {
    let key = $("#chat_search").val();
    if (key != "" && key != null && key != undefined) {
        chat_page = 1;
        $(".chat-list").html("");
        let formData = {
            key,
            user_id: $("#current_user").data("id"),
        };
        $.ajax({
            type: "GET",
            dataType: "json",
            data: formData,
            url: $(".chat-list").data("url") + "?page=" + chat_page,
            success: function (res) {
                chat_page++;
                if (res.result == true) {
                    total_chat_page = res?.data?.last_page;
                    $(".chat-list").html(res.data?.html);
                }
            },
            error: function (data) {
            },
        });
    }
}



