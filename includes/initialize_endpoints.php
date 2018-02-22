<?php 

function makeplugins_add_tabs_endpoint() {
    add_rewrite_endpoint( 'tabs', EP_ALL );
}

add_action( 'init', 'makeplugins_add_tabs_endpoint' );
