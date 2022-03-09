var pageTitleChangingTimeout = null;

$(document).ready(function () {
  initPageTitleChanging();
});

function initPageTitleChanging() {
  window.omtOriginalPageTitle = document.title;
  document.addEventListener('visibilitychange', changePageTitle, false);
}

function changePageTitle() {
  if (document.visibilityState === 'hidden') {
    pageTitleChangingTimeout = setTimeout(() => {
      window.omtOriginalPageTitle = document.title;
      document.title = '🙁 Wir vermissen Dich!';
    }, 1500);
  } else {
    clearTimeout(pageTitleChangingTimeout);
    pageTitleChangingTimeout = null;
    document.title = window.omtOriginalPageTitle;
  }
}
