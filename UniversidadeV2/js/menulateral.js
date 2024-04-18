document.getElementById('openMenu').addEventListener('click', function() {
    document.getElementById('sideMenu').style.width = '700px';
  });
  
document.getElementById('closeMenu').addEventListener('click', function() {
    document.getElementById('sideMenu').style.width = '0';
  });
  
/*document.body.addEventListener('click', function(event) {
    if (event.target.id !== 'openMenu' && event.target.closest('#sideMenu') === null) {
      document.getElementById('sideMenu').style.width = '0';
    }
});*/