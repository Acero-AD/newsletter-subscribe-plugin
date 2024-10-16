document.addEventListener("DOMContentLoaded", function() {
    const subscribeButton = document.getElementById("newsletterSubscribeButton");
    const emailInput = document.getElementById("newsletterSubscriptionEmail");
    const messageDiv = document.getElementById("newsletterSubscribeMessage");

    subscribeButton.addEventListener("click", function() {
        const email = emailInput.value.trim();
        
        var formData = new FormData();
        formData.append('email', email);
        formData.append('nonce', form_ajax_object.nonce);
        formData.append('action', 'subscribe_newsletter');

        if (email) {
          var formData = new FormData();
          formData.append('email', email);
          formData.append('nonce', form_ajax_object.nonce);
          formData.append('action', 'subscribe_newsletter');


          fetch(form_ajax_object.ajax_url, {
            method: "POST",
            body: formData
          })
          .then(response => response.json())
          .then(responseData => {
            if (responseData.success) {
                messageDiv.textContent = responseData.data.message;
            } else {
                messageDiv.textContent = responseData.data.message || "Hubo un error al suscribirse.";
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

