document.addEventListener("DOMContentLoaded", function() {
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-pane');
  
    tabButtons.forEach(button => {
      button.addEventListener('click', () => {
        const tab = button.dataset.tab;
        
        tabButtons.forEach(btn => btn.classList.remove('active'));
        button.classList.add('active');
  
        tabContents.forEach(content => {
          if (content.id === tab + '-content') {
            content.classList.add('active');
          } else {
            content.classList.remove('active');
          }
        });
      });
    });
  });
  