<?php

require_once SHARED . 'classes/CLI_Command.php';

class transdecoderToProteinTable implements \CLI_Command {

    public static function CLI_checkRequiredOpts(\Console_CommandLine_Result $command) {
        
    }

    public static function CLI_commandDescription() {
        return "converts transdecoder output to a protein table";
    }

    public static function CLI_commandName() {
        return "transToProt";
    }

    public static function CLI_getCommand(\Console_CommandLine $parser) {
        $command = $parser->addCommand(self::CLI_commandName(), array(
            'description' => self::CLI_commandDescription()
                ));

        $command->addOption('outfile', array(
            'short_name' => '-o',
            'long_name' => '--outfile',
            'description' => 'output file, if ommited will output to stdout'
        ));

        $command->addArgument('input_files', array('multiple' => true));

        return $command;
    }

    public static function CLI_longHelp() {
        
    }

    public static function CLI_execute(\Console_CommandLine_Result $command, \Console_CommandLine $parser) {

        if (isset($command->options['outfile'])) {
            $out = fopen($command->options['outfile'], 'w');
        } else {
            $out = STDOUT;
        }

        foreach ($command->args['input_files'] as $infilename) {
            $infile = fopen($infilename, 'r');
            while (!feof($infile)) {
                $line = fgets($infile);
                $matches = array();
                if (preg_match('/^>(?<id>[^\s]+) .* (?<parent>[^\s]+):(?<from>\d+)-(?<to>\d+)\((?<dir>[+-])\)$/', $line, $matches)) {
                    fputcsv($out, array($matches['id'], $matches['parent'], $matches['from'], $matches['to'], $matches['dir']), "\t");
                } else if ($line[0] == '>') {
                    trigger_error(sprintf('line does not match: %s', $line), E_USER_ERROR);
                } else
                    continue; //fasta content here, no header
            }
            fclose($infile);
        }
        fclose($out);
    }

}

?>
