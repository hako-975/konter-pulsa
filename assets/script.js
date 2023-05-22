window.onload = function() {
  document.getElementById('preloader').style.display = 'none';
};

const openBtn = document.querySelector('.open-btn');
const closeBtn = document.querySelector('.close-btn');
const sidebar = document.querySelector('.sidebar');

if (openBtn && closeBtn && sidebar) {
  openBtn.addEventListener('click', () => {
    sidebar.classList.remove('closed');
  });

  closeBtn.addEventListener('click', () => {
    sidebar.classList.add('closed');
  });
}