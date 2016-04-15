<?php

namespace webservices\listing;

/**
 * Override session_start() in webservices\listing namespace for testing
 *
 * @return void
 */
function session_start()
{
    # do nothing
}
