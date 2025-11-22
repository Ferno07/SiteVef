// Script pour le formulaire de candidature

document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById('joinForm');
  const typeParticipation = document.getElementById('typeParticipation');
  const autreTypeGroup = document.getElementById('autreTypeGroup');
  const autreTypeInput = document.getElementById('autreType');
  
  // Afficher/masquer le champ "Autre type" selon la sélection
  typeParticipation.addEventListener('change', function() {
    if (this.value === 'autre') {
      autreTypeGroup.style.display = 'block';
      autreTypeInput.setAttribute('required', 'required');
    } else {
      autreTypeGroup.style.display = 'none';
      autreTypeInput.removeAttribute('required');
      autreTypeInput.value = '';
    }
  });

  // Validation en temps réel
  const inputs = form.querySelectorAll('input, select, textarea');
  
  inputs.forEach(input => {
    // Marquer le champ comme "touched" quand l'utilisateur interagit
    input.addEventListener('blur', function() {
      this.classList.add('touched');
      validateField(this);
    });

    input.addEventListener('input', function() {
      // Retirer l'erreur quand l'utilisateur commence à taper
      if (this.classList.contains('error')) {
        this.classList.remove('error');
        const errorMsg = this.parentElement.querySelector('.error-message');
        if (errorMsg) {
          errorMsg.textContent = '';
        }
      }
    });
  });

  // Validation des champs radio
  const radioInputs = form.querySelectorAll('input[type="radio"][name="preferenceAction"]');
  radioInputs.forEach(radio => {
    radio.addEventListener('change', function() {
      const errorMsg = document.querySelector('input[name="preferenceAction"]').closest('.form-group').querySelector('.error-message');
      if (errorMsg) {
        errorMsg.textContent = '';
      }
    });
  });

  // Validation de la checkbox RGPD
  const rgpdCheckbox = document.getElementById('rgpd');
  rgpdCheckbox.addEventListener('change', function() {
    const errorMsg = this.closest('.form-group').querySelector('.error-message');
    if (errorMsg) {
      errorMsg.textContent = '';
    }
  });

  // Fonction de validation d'un champ
  function validateField(field) {
    const errorMsg = field.parentElement.querySelector('.error-message');
    
    // Réinitialiser l'erreur
    field.classList.remove('error');
    if (errorMsg) {
      errorMsg.textContent = '';
    }

    // Vérifier si le champ est requis et vide
    if (field.hasAttribute('required') && !field.value.trim()) {
      field.classList.add('error');
      if (errorMsg) {
        errorMsg.textContent = 'Ce champ est obligatoire';
      }
      return false;
    }

    // Validation spécifique selon le type de champ
    if (field.type === 'email' && field.value) {
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(field.value)) {
        field.classList.add('error');
        if (errorMsg) {
          errorMsg.textContent = 'Veuillez entrer une adresse e-mail valide';
        }
        return false;
      }
    }

    if (field.type === 'tel' && field.value) {
      const telRegex = /^[\d\s\+\-\(\)]+$/;
      if (!telRegex.test(field.value)) {
        field.classList.add('error');
        if (errorMsg) {
          errorMsg.textContent = 'Veuillez entrer un numéro de téléphone valide';
        }
        return false;
      }
    }

    if (field.type === 'date' && field.value) {
      const selectedDate = new Date(field.value);
      const today = new Date();
      if (selectedDate > today) {
        field.classList.add('error');
        if (errorMsg) {
          errorMsg.textContent = 'La date de naissance ne peut pas être dans le futur';
        }
        return false;
      }
    }

    // Validation pour le champ "autre type" si "autre" est sélectionné
    if (field.id === 'autreType' && typeParticipation.value === 'autre' && !field.value.trim()) {
      field.classList.add('error');
      if (errorMsg) {
        errorMsg.textContent = 'Veuillez préciser votre type de participation';
      }
      return false;
    }

    return true;
  }

  // Validation des champs radio
  function validateRadioGroup() {
    const radioGroup = form.querySelector('input[name="preferenceAction"]:checked');
    const firstRadio = form.querySelector('input[name="preferenceAction"]');
    if (!firstRadio) return true;
    
    const formGroup = firstRadio.closest('.form-group');
    const errorMsg = formGroup ? formGroup.querySelector('.error-message') : null;
    
    if (!radioGroup) {
      if (errorMsg) {
        errorMsg.textContent = 'Veuillez sélectionner une préférence d\'action';
      }
      return false;
    }
    
    if (errorMsg) {
      errorMsg.textContent = '';
    }
    return true;
  }

  // Validation de la checkbox RGPD
  function validateRGPD() {
    const formGroup = rgpdCheckbox.closest('.form-group');
    const errorMsg = formGroup ? formGroup.querySelector('.error-message') : null;
    
    if (!rgpdCheckbox.checked) {
      if (errorMsg) {
        errorMsg.textContent = 'Vous devez accepter les conditions RGPD pour continuer';
      }
      return false;
    }
    
    if (errorMsg) {
      errorMsg.textContent = '';
    }
    return true;
  }

  // Soumission du formulaire
  form.addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Marquer tous les champs comme "submitted" pour afficher les erreurs
    inputs.forEach(input => {
      input.classList.add('submitted', 'touched');
    });
    
    // Marquer aussi les champs radio et checkbox
    radioInputs.forEach(radio => {
      radio.classList.add('submitted', 'touched');
    });
    rgpdCheckbox.classList.add('submitted', 'touched');
    
    // Valider tous les champs
    let isValid = true;
    
    inputs.forEach(input => {
      if (!validateField(input)) {
        isValid = false;
      }
    });

    // Valider les champs radio
    if (!validateRadioGroup()) {
      isValid = false;
    }

    // Valider la checkbox RGPD
    if (!validateRGPD()) {
      isValid = false;
    }

    // Si le formulaire est valide, afficher les données en console
    if (isValid) {
      const formData = new FormData(form);
      const data = {};
      
      // Récupérer toutes les données du formulaire
      for (let [key, value] of formData.entries()) {
        data[key] = value;
      }

      // Récupérer la préférence d'action (radio)
      const preferenceAction = form.querySelector('input[name="preferenceAction"]:checked');
      if (preferenceAction) {
        data.preferenceAction = preferenceAction.value;
      }

      // Afficher les données en console
      console.log('=== Données du formulaire de candidature ===');
      console.log('Nom:', data.nom);
      console.log('Prénom:', data.prenom);
      console.log('Date de naissance:', data.dateNaissance);
      console.log('E-mail:', data.email);
      console.log('Téléphone:', data.telephone);
      console.log('Adresse:', data.adresse);
      console.log('Type de participation:', data.typeParticipation);
      if (data.typeParticipation === 'autre') {
        console.log('Autre type:', data.autreType);
      }
      console.log('Disponibilités:', data.disponibilites);
      console.log('Préférence d\'action:', data.preferenceAction);
      console.log('Lettre de motivation:', data.motivation);
      console.log('RGPD accepté:', data.rgpd ? 'Oui' : 'Non');
      console.log('==========================================');
      console.log('Données complètes (JSON):', JSON.stringify(data, null, 2));

      // Message de confirmation
      alert('Merci pour votre candidature !\n\nVos informations ont été enregistrées. Nous vous contacterons prochainement.\n\n(Consultez la console pour voir les données envoyées)');

      // Ici, vous pouvez ajouter l'envoi des données à un backend
      // Exemple avec fetch:
      /*
      fetch('/api/candidature', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(data)
      })
      .then(response => response.json())
      .then(result => {
        console.log('Succès:', result);
        alert('Votre candidature a été envoyée avec succès !');
        form.reset();
      })
      .catch(error => {
        console.error('Erreur:', error);
        alert('Une erreur est survenue. Veuillez réessayer.');
      });
      */

      // Réinitialiser le formulaire après envoi
      form.reset();
      autreTypeGroup.style.display = 'none';
      autreTypeInput.removeAttribute('required');
    } else {
      // Faire défiler jusqu'au premier champ en erreur
      const firstError = form.querySelector('.error, input:invalid, select:invalid, textarea:invalid');
      if (firstError) {
        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        firstError.focus();
      }
    }
  });

  // Réinitialisation du formulaire
  form.addEventListener('reset', function() {
    // Réinitialiser les messages d'erreur
    const errorMessages = form.querySelectorAll('.error-message');
    errorMessages.forEach(msg => {
      msg.textContent = '';
    });

    // Réinitialiser les classes d'erreur
    const errorFields = form.querySelectorAll('.error, .touched, .submitted');
    errorFields.forEach(field => {
      field.classList.remove('error', 'touched', 'submitted');
    });
    
    // Réinitialiser aussi les champs radio et checkbox
    radioInputs.forEach(radio => {
      radio.classList.remove('submitted', 'touched');
    });
    rgpdCheckbox.classList.remove('submitted', 'touched');

    // Masquer le champ "autre type"
    autreTypeGroup.style.display = 'none';
    autreTypeInput.removeAttribute('required');
  });
});

