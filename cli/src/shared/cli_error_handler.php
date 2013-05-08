<?php

function cli_error_handler($err_code, $err_text, $err_file, $err_line) {
    global $parser;
    switch ($err_code) {
        case E_USER_ERROR:
            $parser->outputter->stderr(sprintf("Error: %s\n", $err_text));
            exit(1);
            break;

        case E_USER_WARNING:
            $parser->outputter->stderr(sprintf("Warning: %s\n", $err_text));
            break;

        case E_USER_NOTICE:
            $parser->outputter->stdout(sprintf("Notice: %s\n", $err_text));
            break;

        default:
            $parser->outputter->stderr(sprintf("Unknown Error: %s\n", $err_text));
            /* let php handle this error */
            return false;
            break;
    }
    /* don't let php handle this error */
    return true;
}

set_error_handler("cli_error_handler", E_ALL);
?>
