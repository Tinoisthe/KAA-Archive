// Function to toggle the active state of tabs
function toggleTab(tabIndex) {
  // Hide all tab content items
  const allTabs = document.querySelectorAll('.tab-content-item');
  allTabs.forEach(tab => tab.classList.remove('show'));

  // Show the selected tab content
  const selectedTabContent = document.getElementById(`tab-${tabIndex}-content`);
  selectedTabContent.classList.add('show');

  // Remove active class from all tabs
  const allTabItems = document.querySelectorAll('.tab-item');
  allTabItems.forEach(tabItem => tabItem.classList.remove('show'));

  // Add active class to the selected tab
  const selectedTab = document.getElementById(`tab-${tabIndex}`);
  selectedTab.classList.add('show');
}

// Function to toggle the active state of a button
function toggleActiveState(button) {
  button.classList.toggle('active');
}
