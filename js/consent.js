/* gastrokompass — consent.js
   Cookie-Consent-Banner: lädt Google Analytics erst nach Zustimmung.
   Ohne Zustimmung wird kein gtag.js geladen und keine Anfrage an Google
   gesendet — das Setzen von "denied" oder das Nichtentscheiden verhindert
   das Nachladen zuverlässig. */
(function(){
  var CONSENT_KEY = 'gastrokompass-cookie-consent';
  var GA_ID = 'G-3F4C9137YF';
  var gaLoaded = false;

  function getConsent(){
    try { return localStorage.getItem(CONSENT_KEY); } catch (e) { return null; }
  }
  function setConsent(value){
    try { localStorage.setItem(CONSENT_KEY, value); } catch (e) { /* ignore */ }
  }

  function loadAnalytics(){
    if (gaLoaded) return;
    gaLoaded = true;
    window.dataLayer = window.dataLayer || [];
    window.gtag = window.gtag || function(){ window.dataLayer.push(arguments); };
    gtag('js', new Date());
    gtag('config', GA_ID);

    var script = document.createElement('script');
    script.async = true;
    script.src = 'https://www.googletagmanager.com/gtag/js?id=' + GA_ID;
    document.head.appendChild(script);
  }

  function hideBanner(banner){
    banner.classList.remove('visible');
    setTimeout(function(){ banner.remove(); }, 350);
  }

  function buildBanner(){
    var existing = document.getElementById('cookieConsent');
    if (existing) existing.remove();

    var banner = document.createElement('div');
    banner.id = 'cookieConsent';
    banner.className = 'cookie-consent';
    banner.setAttribute('role', 'dialog');
    banner.setAttribute('aria-label', 'Cookie-Einstellungen');

    var inner = document.createElement('div');
    inner.className = 'cookie-consent-inner';

    var text = document.createElement('p');
    text.className = 'cookie-consent-text';
    text.innerHTML = 'Wir verwenden Cookies, um unsere Website zu analysieren und zu verbessern (Google Analytics). Weitere Informationen finden Sie in unserer <a href="datenschutz.html">Datenschutzerklärung</a>.';

    var actions = document.createElement('div');
    actions.className = 'cookie-consent-actions';

    var declineBtn = document.createElement('button');
    declineBtn.type = 'button';
    declineBtn.className = 'btn btn-primary-outline';
    declineBtn.textContent = 'Ablehnen';
    declineBtn.addEventListener('click', function(){
      setConsent('denied');
      hideBanner(banner);
    });

    var acceptBtn = document.createElement('button');
    acceptBtn.type = 'button';
    acceptBtn.className = 'btn btn-accent';
    acceptBtn.textContent = 'Akzeptieren';
    acceptBtn.addEventListener('click', function(){
      setConsent('granted');
      loadAnalytics();
      hideBanner(banner);
    });

    actions.appendChild(declineBtn);
    actions.appendChild(acceptBtn);
    inner.appendChild(text);
    inner.appendChild(actions);
    banner.appendChild(inner);
    document.body.appendChild(banner);

    requestAnimationFrame(function(){ banner.classList.add('visible'); });
  }

  document.addEventListener('DOMContentLoaded', function(){
    var consent = getConsent();
    if (consent === 'granted') {
      loadAnalytics();
    } else if (consent !== 'denied') {
      buildBanner();
    }

    document.querySelectorAll('.cookie-settings-link').forEach(function(link){
      link.addEventListener('click', function(e){
        e.preventDefault();
        buildBanner();
      });
    });
  });
})();
