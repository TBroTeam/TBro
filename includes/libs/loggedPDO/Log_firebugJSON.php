<?php

// we're using the PEAR Log package
require_once 'Log.php';
require_once 'Log/firebug.php';

/**
 * overrides normal Log_firebug: message will be passed & displayed as json encoded object
 */
class Log_firebugJSON extends Log_firebug {
    function log($message, $priority = null) {
        /* If a priority hasn't been specified, use the default value. */
        if ($priority === null) {
            $priority = $this->_priority;
        }

        /* Abort early if the priority is above the maximum logging level. */
        if (!$this->_isMasked($priority)) {
            return false;
        }

        /* Extract the string representation of the message. */
        $method = $this->_methods[$priority];
        /* prepare object to apss to firebug */
        $object = json_encode($message);
        /* continue preparing message for _announce */
        $message_announce = preg_replace("/\r?\n/", "\\n", addslashes($this->_extractMessage($message)));

        /* Build the string containing the log line prefix. */
        $prefix = $this->_format($this->_lineFormat, strftime($this->_timeFormat), $priority, '');


        if ($this->_buffering) {
            $this->_buffer[] = sprintf('console.%s("%s", %s);', $method, $prefix, $object);
        } else {
            print '<script type="text/javascript">';
            print "\nif ('console' in window) {\n";
            /* Build and output the complete log line. */
            printf('  console.%s("%s", %s);', $method, $prefix, $object);
            print "\n}\n";
            print "</script>\n";
        }
        /* Notify observers about this log message. */
        $this->_announce(array('priority' => $priority, 'message' => $message_announce));

        return true;
    }

}

?>
