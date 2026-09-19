/* gastrokompass — base.js
   Mobiles Burger-Menü — wird auf jeder Seite mit Header eingebunden */
document.addEventListener('DOMContentLoaded', function(){
  var burger = document.getElementById('burgerBtn');
  var panel = document.getElementById('mobilePanel');
  if (!burger || !panel) return;

  burger.addEventListener('click', function(){
    panel.classList.toggle('open');
  });
  panel.querySelectorAll('a').forEach(function(a){
    a.addEventListener('click', function(){ panel.classList.remove('open'); });
  });
});
