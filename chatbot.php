<?php
/**
 * chatbot.php
 * HTML container & asset imports for the PSTL Gemini Chatbot.
 * This is included in footer.php to load site-wide.
 */
?>

<!-- Chatbot Stylesheet -->
<link rel="stylesheet" href="css/chatbot.css">

<!-- Chat Trigger Button -->
<button class="pstl-chat-btn" id="pstlChatBtn" aria-label="Open Chat Assistant">
    <i class="fa fa-commenting" aria-hidden="true"></i>
</button>

<!-- Hover Welcome Tooltip -->
<div class="pstl-chat-tooltip" id="pstlChatTooltip">
    Ask Gemini Assistant
</div>

<!-- Chat Window Panel -->
<div class="pstl-chat-window" id="pstlChatWindow">
    
    <!-- Header -->
    <div class="pstl-chat-header">
        <div class="pstl-chat-header-info">
            <div class="pstl-chat-header-logo">
                <i class="fa fa-graduation-cap" aria-hidden="true"></i>
            </div>
            <div>
                <h3 class="pstl-chat-header-title">PSTL AI Assistant</h3>
                <div class="pstl-chat-header-status">
                    <span class="pstl-chat-header-status-dot"></span>
                    <span>Powered by Gemini</span>
                </div>
            </div>
        </div>
        <div style="display: flex; align-items: center; gap: 8px;">
            <!-- Clear History Button -->
            <button class="pstl-chat-close-btn" id="pstlChatClearBtn" title="Clear Conversation" aria-label="Clear chat">
                <i class="fa fa-refresh" style="font-size: 15px;" aria-hidden="true"></i>
            </button>
            <!-- Close Button -->
            <button class="pstl-chat-close-btn" id="pstlChatCloseBtn" title="Close Window" aria-label="Close chat window">
                <i class="fa fa-times" aria-hidden="true"></i>
            </button>
        </div>
    </div>

    <!-- Message Logs -->
    <div class="pstl-chat-messages" id="pstlChatMessages">
        <!-- Welcome Card -->
        <div class="pstl-chat-welcome" id="pstlWelcomeBox">
            <h4>Welcome to PSTL! 👋</h4>
            <p>I am your Gemini-powered assistant. Ask me anything about our research, members, publications, or recent notices.</p>
        </div>
    </div>

    <!-- Suggestion Chips -->
    <div class="pstl-chat-chips-container">
        <div class="pstl-chat-chips">
            <button class="pstl-chip">What is PSTL?</button>
            <button class="pstl-chip">Research Activities</button>
            <button class="pstl-chip">Recent Notices</button>
            <button class="pstl-chip">Who are the members?</button>
        </div>
    </div>

    <!-- Input Footer -->
    <div class="pstl-chat-footer">
        <input type="text" id="pstlChatInput" class="pstl-chat-input" placeholder="Type your query here..." aria-label="Chat input">
        <button id="pstlChatSendBtn" class="pstl-chat-send-btn" aria-label="Send message">
            <i class="fa fa-paper-plane" aria-hidden="true"></i>
        </button>
    </div>

</div>

<!-- Chatbot Client-Side Logic -->
<script src="js/chatbot.js"></script>
