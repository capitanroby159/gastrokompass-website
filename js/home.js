/* gastrokompass — home.js
   Nur für die Startseite: Erfolgsmeldung nach Formular-Versand anzeigen */
document.addEventListener('DOMContentLoaded', function(){
  var params = new URLSearchParams(window.location.search);
  if (params.get('kontakt') === 'erfolg') {
    var form = document.getElementById('contactForm');
    var success = document.getElementById('formSuccess');
    if (form) form.style.display = 'none';
    if (success) success.style.display = 'block';
  }
});
