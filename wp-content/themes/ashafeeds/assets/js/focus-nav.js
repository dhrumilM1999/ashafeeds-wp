( function( window, document ) {
  function ashafeeds_keepFocusInMenu() {
    document.addEventListener( 'keydown', function( e ) {
      const ashafeeds_nav = document.querySelector( '.sidenav' );
      if ( ! ashafeeds_nav || ! ashafeeds_nav.classList.contains( 'open' ) ) {
        return;
      }
      const elements = [...ashafeeds_nav.querySelectorAll( 'input, a, button' )],
        ashafeeds_lastEl = elements[ elements.length - 1 ],
        ashafeeds_firstEl = elements[0],
        ashafeeds_activeEl = document.activeElement,
        tabKey = e.keyCode === 9,
        shiftKey = e.shiftKey;
      if ( ! shiftKey && tabKey && ashafeeds_lastEl === ashafeeds_activeEl ) {
        e.preventDefault();
        ashafeeds_firstEl.focus();
      }
      if ( shiftKey && tabKey && ashafeeds_firstEl === ashafeeds_activeEl ) {
        e.preventDefault();
        ashafeeds_lastEl.focus();
      }
    } );
  }
  ashafeeds_keepFocusInMenu();
} )( window, document );