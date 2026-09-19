"use strict";

const button = document.getElementById('button');

// Set default theme if none exists
if (!localStorage.getItem('theme_mode')) {
  localStorage.setItem('theme_mode', 'default-theme');
}

button.addEventListener('click', () => {
  const currentTheme = localStorage.getItem('theme_mode');
  const newTheme = currentTheme === 'default-theme' ? 'dark-theme' : 'default-theme';

  document.body.classList.remove('default-theme', 'dark-theme');
  document.body.classList.add(newTheme);
  localStorage.setItem('theme_mode', newTheme);
  updateButtonText(newTheme);
});

// Apply theme on page load
const activeTheme = localStorage.getItem('theme_mode');
document.body.classList.remove('default-theme', 'dark-theme');
document.body.classList.add(activeTheme);
updateButtonText(activeTheme);

function updateButtonText(theme) {
  if (theme === 'default-theme') {
    button.innerHTML = '<i class="lar la-sun"></i>';
  } else if (theme === 'dark-theme') {
    button.innerHTML = '<i class="lar la-moon"></i>';
  }
}


