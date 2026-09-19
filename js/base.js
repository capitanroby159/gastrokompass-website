/* gastrokompass — base.js
   Mobiles Burger-Menü — wird auf jeder Seite mit Header eingebunden */
document.addEventListener('DOMContentLoaded', function(){
  var burger = document.getElementById('burgerBtn');
  var panel = document.getElementById('mobilePanel');
  if (burger && panel) {
    burger.addEventListener('click', function(){
      panel.classList.toggle('open');
    });
    panel.querySelectorAll('a').forEach(function(a){
      a.addEventListener('click', function(){ panel.classList.remove('open'); });
    });
  }

  var yearEl = document.getElementById('copyrightYear');
  if (yearEl) yearEl.textContent = new Date().getFullYear();
});
