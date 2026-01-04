// Custom JS for Support Apps BKPSDM
$(function() {
  // Add any custom jQuery here

  const COLLAPSE_KEY = 'sidebarCollapsed';
  const $body = $('body');
  const $btn = $('#sidebarCollapseBtn');

  function setCollapsed(state){
    if(state){
      $body.addClass('sidebar-collapsed');
      $btn.attr('aria-pressed','true');
    } else {
      $body.removeClass('sidebar-collapsed');
      $btn.attr('aria-pressed','false');
    }
    try{ localStorage.setItem(COLLAPSE_KEY, state ? '1' : '0'); }catch(e){/* ignore */}
  }

  $btn.on('click', function(e){
    e.preventDefault();
    setCollapsed(!$body.hasClass('sidebar-collapsed'));
  });

  function updateNavTitles(){
    $('.sidebar .nav-link').each(function(){
      var label = $(this).find('.menu-label').text().trim();
      if(label) $(this).attr('title', label);
    });
  }

  // init from saved state
  try{
    if(localStorage.getItem(COLLAPSE_KEY) === '1') setCollapsed(true);
  }catch(e){/* ignore */}

  // set titles for accessibility when labels are hidden
  updateNavTitles();
});
