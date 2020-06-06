var intro = document.getElementById('intro'),
  navbar = document.getElementById('main-navbar'),
  navbarTop = navbar.offsetTop,
  navbarBottom = navbar.offsetTop + navbar.offsetHeight,
  introTop = intro.offsetTop,
  sidebar = document.getElementById('mobile-sidebar'),
  OpenSidebarButton = document.getElementById('mobile-nav-button'),
  CloseSidebarButton = document.getElementById('mobile-nav-button-close'),
  barsIcon = document.getElementsByClassName('fa-bars'),
  overLay = document.getElementById('mobile-overlay'),
  achievement = document.getElementById('achievement');
let countTriggered;

function navbarShadow() {


  window.pageYOffset > introTop ?
    navbar.classList.remove('navbar--ontop') :
    navbar.classList.add('navbar--ontop');
}

document.addEventListener('scroll', function(t) {
  navbarShadow();
});

OpenSidebarButton.addEventListener('click', function(t) {
  sidebar.classList.add('mobile--active');
  overLay.classList.add('mobile--active');
});
CloseSidebarButton.addEventListener('click', function(t) {
  sidebar.classList.remove('mobile--active');
  overLay.classList.remove('mobile--active');
});
