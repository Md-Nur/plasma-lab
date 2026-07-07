/**
 * chatbot.js
 * Frontend logic for the PSTL Gemini Chatbot.
 * Handles toggle state, message rendering, markdown parsing, API requests, and history persistence.
 */

$(document).ready(function() {
    const $chatBtn = $('#pstlChatBtn');
    const $chatWindow = $('#pstlChatWindow');
    const $closeBtn = $('#pstlChatCloseBtn');
    const $clearBtn = $('#pstlChatClearBtn');
    const $messagesContainer = $('#pstlChatMessages');
    const $chatInput = $('#pstlChatInput');
    const $sendBtn = $('#pstlChatSendBtn');
    const $chips = $('.pstl-chip');

    let conversationHistory = [];
    const STORAGE_KEY = 'pstl_chat_history';
    const STATE_KEY = 'pstl_chat_open';

    // Basic markdown-to-HTML parser for rich responses
    function formatMarkdown(text) {
        if (!text) return '';
        
        // Escape HTML tags to prevent XSS
        let html = text
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;");

        // Convert bold (**text**) to <strong>text</strong>
        html = html.replace(/\*\*([\s\S]*?)\*\*/g, '<strong>$1</strong>');

        // Convert bullet lists (lines starting with - or *)
        const lines = html.split('\n');
        let inList = false;
        let listType = ''; // 'ul' or 'ol'
        let formattedLines = [];

        for (let i = 0; i < lines.length; i++) {
            let line = lines[i].trim();
            
            // Check for unordered list items starting with - or *
            if (line.startsWith('- ') || line.startsWith('* ')) {
                if (!inList) {
                    formattedLines.push('<ul style="margin: 6px 0; padding-left: 20px;">');
                    inList = true;
                    listType = 'ul';
                }
                formattedLines.push('<li>' + line.substring(2) + '</li>');
            } 
            // Check for numbered list items (e.g. 1. )
            else if (/^\d+\.\s/.test(line)) {
                if (!inList) {
                    formattedLines.push('<ol style="margin: 6px 0; padding-left: 20px;">');
                    inList = true;
                    listType = 'ol';
                }
                const content = line.replace(/^\d+\.\s/, '');
                formattedLines.push('<li>' + content + '</li>');
            }
            else {
                if (inList) {
                    formattedLines.push('</' + listType + '>');
                    inList = false;
                }
                formattedLines.push(line);
            }
        }
        
        if (inList) {
            formattedLines.push('</' + listType + '>');
        }

        html = formattedLines.join('\n');

        // Convert remaining single newlines to <br>
        html = html.replace(/\n/g, '<br>');

        return html;
    }

    // Scroll chat messages to the bottom
    function scrollToBottom() {
        $messagesContainer.animate({
            scrollTop: $messagesContainer[0].scrollHeight
        }, 300);
    }

    // Render a single message bubble
    function appendMessage(role, text, animate = true) {
        const bubbleClass = role === 'user' ? 'user' : 'bot';
        const formattedText = role === 'user' ? formatMarkdown(text) : formatMarkdown(text);
        
        const $msgElement = $(`
            <div class="pstl-msg ${bubbleClass}" style="${animate ? 'opacity: 0; transform: translateY(10px);' : ''}">
                ${formattedText}
            </div>
        `);

        $messagesContainer.append($msgElement);

        if (animate) {
            $msgElement.animate({
                opacity: 1,
                transform: 'translateY(0)'
            }, 250);
        }

        scrollToBottom();
    }

    // Show typing indicator
    function showTypingIndicator() {
        if ($('#pstlTypingIndicator').length === 0) {
            const $indicator = $(`
                <div id="pstlTypingIndicator" class="pstl-msg bot" style="padding: 10px 16px; width: 60px;">
                    <div class="pstl-typing">
                        <span class="pstl-typing-dot"></span>
                        <span class="pstl-typing-dot"></span>
                        <span class="pstl-typing-dot"></span>
                    </div>
                </div>
            `);
            $messagesContainer.append($indicator);
            scrollToBottom();
        }
    }

    // Hide typing indicator
    function hideTypingIndicator() {
        $('#pstlTypingIndicator').remove();
    }

    // Save history to localStorage
    function saveHistory() {
        localStorage.setItem(STORAGE_KEY, JSON.stringify(conversationHistory));
    }

    // Load history from localStorage
    function loadHistory() {
        const storedHistory = localStorage.getItem(STORAGE_KEY);
        if (storedHistory) {
            try {
                conversationHistory = jsonDecodeSafe(storedHistory);
                if (conversationHistory.length > 0) {
                    // Remove welcome box if we have active chat history
                    $('#pstlWelcomeBox').hide();
                    
                    // Render all messages in history
                    conversationHistory.forEach(msg => {
                        const role = msg.role === 'user' ? 'user' : 'bot';
                        const text = msg.parts[0].text;
                        appendMessage(role, text, false);
                    });
                }
            } catch (e) {
                console.error("Error parsing chat history:", e);
                conversationHistory = [];
            }
        }
    }

    // Helper for safe JSON parsing
    function jsonDecodeSafe(str) {
        return JSON.parse(str);
    }

    // Clear chat conversation
    function clearChat() {
        conversationHistory = [];
        localStorage.removeItem(STORAGE_KEY);
        $messagesContainer.find('.pstl-msg').remove();
        $('#pstlWelcomeBox').show();
        scrollToBottom();
    }

    // Toggle Chat Window
    function toggleChat(forceState = null) {
        let isOpen = $chatWindow.hasClass('active');
        if (forceState !== null) {
            isOpen = !forceState;
        }

        if (isOpen) {
            // Close it
            $chatWindow.removeClass('active');
            localStorage.setItem(STATE_KEY, 'false');
        } else {
            // Open it
            $chatWindow.addClass('active');
            localStorage.setItem(STATE_KEY, 'true');
            $chatInput.focus();
            scrollToBottom();
        }
    }

    // Send message to backend API
    function sendMessage() {
        const text = $chatInput.val().trim();
        if (text === '') return;

        // Hide welcome block
        $('#pstlWelcomeBox').fadeOut(200);

        // Append user message to UI and history
        appendMessage('user', text);
        $chatInput.val('');
        
        conversationHistory.push({
            role: "user",
            parts: [
                { text: text }
            ]
        });
        saveHistory();

        // Show loading state
        showTypingIndicator();

        // Send POST request to chat_api.php
        $.ajax({
            url: 'chat_api.php',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ contents: conversationHistory }),
            success: function(res) {
                hideTypingIndicator();
                if (res && res.status === 'success') {
                    const botResponse = res.response;
                    appendMessage('bot', botResponse);
                    
                    conversationHistory.push({
                        role: "model",
                        parts: [
                            { text: botResponse }
                        ]
                    });
                    saveHistory();
                } else {
                    const errorMsg = res && res.message ? res.message : 'An error occurred. Please try again.';
                    appendMessage('bot', `⚠️ *System Note:* ${errorMsg}`);
                }
            },
            error: function(xhr, status, error) {
                hideTypingIndicator();
                appendMessage('bot', '⚠️ *System Note:* Could not reach the chat helper. Please check your network connection.');
                console.error("Chat API failure:", error);
            }
        });
    }

    // Event Bindings
    $chatBtn.on('click', () => toggleChat());
    $closeBtn.on('click', () => toggleChat(false));
    $clearBtn.on('click', clearChat);

    $sendBtn.on('click', sendMessage);
    $chatInput.on('keypress', function(e) {
        if (e.which === 13) {
            sendMessage();
            e.preventDefault();
        }
    });

    // Suggestion chips handler
    $chips.on('click', function() {
        const queryText = $(this).text().trim();
        $chatInput.val(queryText);
        sendMessage();
    });

    // Initialize state
    loadHistory();

    // Check if chat window was left open
    const chatWasOpen = localStorage.getItem(STATE_KEY);
    if (chatWasOpen === 'true') {
        toggleChat(true);
    }
});
