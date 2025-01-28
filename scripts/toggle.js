// Tab Switching Script
const tabs = document.querySelectorAll('.tab-item');
const tabContents = document.querySelectorAll('.tab-content-item');

tabs.forEach(tab => {
  tab.addEventListener('click', () => {
    const target = tab.id.split('-')[1]; // Get tab number (1, 2, 3, or 4)
    
    // Hide all tab content
    tabContents.forEach(content => {
      content.classList.remove('show');
    });
    
    // Show the clicked tab content
    document.getElementById(`tab-${target}-content`).classList.add('show');
    
    // Remove 'show' class from all tabs
    tabs.forEach(tab => tab.classList.remove('show'));
    
    // Add 'show' class to the clicked tab
    tab.classList.add('show');
  });
});
