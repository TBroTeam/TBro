<?php

/**
 * @author Lorenz Weber <mail@phryneas.de>
 * @copyright (c) 2013, Lorenz Weber
 * @package loggedPDO
 * 
 * The MIT License (MIT)
 * 
 * @copyright (c) 2013, Lorenz Weber
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
// we're using the PEAR Log package

if (!@include_once 'Log.php')
    throw new \Exception("Failure including Log.php\nplease install PEAR::Log or check your include_path\n");
if (!@include_once 'Log/firebug.php')
    throw new \Exception("Failure including Log/firebug.php\nplease install PEAR::Log or check your include_path\n");

/**
 * @uses Log.php
 * extends normal Log_firebug: message will be passed & displayed as json encoded object
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
        }
        else {
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
