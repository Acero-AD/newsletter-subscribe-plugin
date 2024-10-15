document.addEventListener("DOMContentLoaded", function() {
    const subscribeButton = document.getElementById("newsletterSubscribeButton");
    const emailInput = document.getElementById("newsletterSubscriptionEmail");
    const messageDiv = document.getElementById("newsletterSubscribeMessage");

    subscribeButton.addEventListener("click", function() {
        const email = emailInput.value.trim();

        if (email) {
            const data = {
                action: 'subscribe_newsletter',
                email: email,
                nonce: form_ajax_object.nonce
            };

            fetch(form_ajax_object.ajax_url, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(responseData => {
                if (responseData.success) {
                    messageDiv.textContent = responseData.message;
                } else {
                    messageDiv.textContent = responseData.message || "Hubo un error al suscribirse.";
                }
            })
            .catch(() => {
                messageDiv.textContent = "Error al suscribirse, por favor intenta nuevamente.";
            });
        } else {
            alert("Por favor, ingresa un email válido.");
        }
    });
});

