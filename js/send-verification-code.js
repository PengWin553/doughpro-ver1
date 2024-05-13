function sendMail() {
    (function () {
        emailjs.init("y5AFZ7mJn8V7XSsJa"); //Account Public Key
    })();

    var params = {
        sendername: document.querySelector("#sendername").value,
        to: document.querySelector("#to").value,
        subject: document.querySelector("#subject").value,
        replyto: document.querySelector("#replyto").value,
        message: document.querySelector("#message").value,
    };

    var serviceID = "service_figrw0d"; // Email Service ID
    var templateID = "template_apfpqqg"; //Email Template ID

    emailjs.send(serviceID, templateID, params)
        .then(res => {
            alert("Email Sent Successfully.")
        }).catch();
}