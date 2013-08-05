<?php

require_once 'Console/CommandLine.php';

class CommandLineComplete {

    static function fromConsoleCommandLine($commandname, \Console_CommandLine $cli) {
        ob_start();

        echo <<<EOF
#!/bin/bash

complete -F _${commandname}_main $commandname

_${commandname}_main()
{
	COMPREPLY=()
	#argument 1 is command name
	_${commandname}_cmd 1
}
EOF;

        self::printCmd("_${commandname}_cmd", $cli);

        print str_replace("\r\n", "\n", ob_get_clean());
    }

    private static function printCmd($cmdname, \Console_CommandLine $cli) {
        $sub_string = implode(' ', array_map(function($value) {
                            return $value->name;
                        }, $cli->commands));
        $options = array();
        foreach ($cli->options as $option) {
            if (!empty($option->short_name))
                $options[] = $option->short_name;
            if (!empty($option->long_name))
                $options[] = $option->long_name;
        }

        $opt_string = implode(' ', $options);

        $subcommands = '';

        foreach ($cli->commands as $sub) {
            $subname = $sub->name;
            $subcommands.=<<<EOF

				"${subname}")
                                        ${cmdname}_sub_${subname} \$((\$1+1))
				;;
EOF;

            self::printCmd("${cmdname}_sub_${subname}", $sub);
        }

        if (count($cli->args) > 0)
            $f = '-f';
        else
            $f = '';

        echo <<<EOF

$cmdname()
{
    cur=\${COMP_WORDS[\$1]}
	opts="-h --help -v  --version $opt_string"
	subcom="$sub_string"
	
	if [[ \$1 == \$COMP_CWORD ]] ; then
		if [[ \${cur} == -* ]] ; then
			COMPREPLY=( \$(compgen -W "\${opts}" -- \${cur}) )
			return 0
		else
			COMPREPLY=( \$(compgen $f -W "\${subcom}" -- \${cur}) )
			return 0
		fi
	else
		if [[ \${cur} == -* ]] ; then
			$cmdname \$((\$1+1))
		else
			case \${cur} in
$subcommands
			
				*) #unknown.
					$cmdname \$((\$1+1))
				;;
			esac	
		fi
	fi
}
EOF;
    }

}

?>
