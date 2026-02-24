export function contactForm() {
    const contactFormElement = document.querySelector('#contactForm');
  
    const successBox = document.querySelector('#successBox');
    const successText = document.querySelector('#successText');
  
    const errorBox = document.querySelector('#errorBox');
    const errorList = document.querySelector('#errorList');
  
    function handleContactFormSubmit(event) {
      event.preventDefault();
  
      console.log('Contact form submitted');
  
      const currentForm = event.currentTarget;
      const url = 'includes/send.php';
  
      hideMessages();
      clearFieldErrors();
  
      const formData = new URLSearchParams({
        name: currentForm.elements.name.value,
        email: currentForm.elements.email.value,
        message: currentForm.elements.message.value,
      });
  
      console.log('Form data prepared');
  
      fetch(url, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: formData,
      })
        .then(response => response.json())
        .then(responseData => {
          console.log('Server response:', responseData);
  
          if (responseData.errors) {
            showErrors(responseData.errors);
            return;
          }
  
          currentForm.reset();
          showSuccess(responseData.message);
        })
        .catch(error => {
          console.log('Fetch error:', error);
          showErrors(['Sorry, something went wrong. Please try again later.']);
        });
    }
  
    function hideMessages() {
      successBox.hidden = true;
      errorBox.hidden = true;
      successText.textContent = '';
      errorList.innerHTML = '';
    }
  
    function showSuccess(message) {
      successText.textContent = message;
      successBox.hidden = false;
      successBox.scrollIntoView({ behavior: 'smooth', block: 'end' });
    }
  
    function showErrors(errors) {
      errors.forEach(function (errorMessage) {
        const li = document.createElement('li');
  
        const icon = document.createElement('i');
        icon.classList.add('fa-solid', 'fa-triangle-exclamation');
  
        const text = document.createTextNode(' ' + errorMessage);
  
        li.appendChild(icon);
        li.appendChild(text);
        errorList.appendChild(li);
  
        highlightFieldFromMessage(errorMessage);
      });
  
      errorBox.hidden = false;
      errorBox.scrollIntoView({ behavior: 'smooth', block: 'end' });
    }
  
    function clearFieldErrors() {
      const errorFields = contactFormElement.querySelectorAll('.error-field');
      errorFields.forEach(function (field) {
        field.classList.remove('error-field');
      });
    }
  
    function highlightFieldFromMessage(errorText) {
      const lower = errorText.toLowerCase();
  
      if (lower.includes('name')) {
        document.querySelector('#name').classList.add('error-field');
      }
  
      if (lower.includes('email')) {
        document.querySelector('#email').classList.add('error-field');
      }
  
      if (lower.includes('message')) {
        document.querySelector('#message').classList.add('error-field');
      }
    }
  
    contactFormElement.addEventListener('submit', handleContactFormSubmit);
  }