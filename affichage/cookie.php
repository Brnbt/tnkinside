<div id="cookie-popup" class="cookie-popup">
        <p>Nous utilisons des cookies pour vous offrir la meilleure expérience possible sur notre site web. En acceptant ou en refusant, vous consentez ou non à l'utilisation de tous les cookies.</p>
        <button id="accept-cookie-btn">Accepter</button>
        <button id="reject-cookie-btn">Refuser</button>
    </div>

    <script>
 document.addEventListener("DOMContentLoaded", function() {
    var cookiePopup = document.getElementById("cookie-popup");
    var acceptBtn = document.getElementById("accept-cookie-btn");
    var rejectBtn = document.getElementById("reject-cookie-btn");

    acceptBtn.addEventListener("click", function() {
        // Set a cookie to remember user's choice
        document.cookie = "cookies_accepted=true; expires=Fri, 31 Dec 9999 23:59:59 GMT; path=/";

        // Hide the cookie popup
        cookiePopup.style.display = "none";
    });

    rejectBtn.addEventListener("click", function() {
        // Set a cookie to remember user's choice
        document.cookie = "cookies_rejected=true; expires=Fri, 31 Dec 9999 23:59:59 GMT; path=/";

        // Hide the cookie popup
        cookiePopup.style.display = "none";
    });

    // Check if the user has already accepted or rejected cookies
    var cookiesAccepted = document.cookie.includes("cookies_accepted=true");
    var cookiesRejected = document.cookie.includes("cookies_rejected=true");

    if (!cookiesAccepted && !cookiesRejected) {
        // If the user hasn't accepted or rejected cookies yet, display the popup
        cookiePopup.style.display = "block";
    } else {
        // If the user has already made a choice, hide the popup
        cookiePopup.style.display = "none";
    }
});

    </script>

    <style>
        .cookie-popup {
    position: fixed;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    background-color: #f0f0f0;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    max-width: 800px;
    text-align: center;
    z-index: 9999;
}

.cookie-popup p {
    margin-bottom: 10px;
}

#accept-cookie-btn {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
}

#reject-cookie-btn {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
}

    </style>