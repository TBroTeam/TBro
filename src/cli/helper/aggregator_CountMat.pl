#!/usr/bin/perl

=head1 NAME

aggregator_CountMat - Produces a matrix of transcript expression counts combined for different experiments. Count values are allowed to come from different expression quantification programs.

=head1 SYNOPSIS

  aggragator_CountMat: Builds a count matrix for transcript quantification values. Different experiments' and/or programs' expression quantification outputs can be used.
  
  aggregator_CountMat.pl --in_RSEM <Rresult1 Rresult2> --labels_RSEM <Rlabel1 Rlabel2> --in_eXpress <eresult1 eresult2> --labels_eXpress <elabel1 elabel2> --out <filename> 

  --help     Show this scripts help information.
     

=head1 OPTIONS

=over 8

=item B<--help|?>

	Show the help information.

=item B<--in_RSEM|--input_RSEM>

	File or list of files (separated by "space") of RSEM's "sampleX.isoforms.results" or 
	"sampleX.genes.results". Do NOT mix genes and isoforms (will result in error "Transcript 
	"ID" doesn't exist in file "filename").

=item B<--label_RSEM>

	Name for each experiment given in --in_RSEM (must be in same order). If not given, labels will equal inputfile-names

=item B<--in_eXpress|--input_eXpress>

	File or list of files (separated by "space") of eXpress's output "results.xprs". 

=item B<--label_eXpress>

	Name for each experiment given in --in_eXpress (same order). If not given, labels equal inputfile-names

=item B<--out|--output>

	Name for Outputfile: Contains the count matrix of transcript expression values 
	from different experiments and/or programs.

=back

=cut

#################################################################################
use warnings;
use strict;
use Data::Dumper;
use Getopt::Long;
use Pod::Usage;

my $help = '';
my @in_RSEM;
my @label_RSEM;
my @in_sailfish;
my @label_sailfish;
my @in_eXpress;
my @label_eXpress;
my $out = '';


## Parse options and print usage if there is a syntax error,
## or if usage was explicitly requested.
GetOptions(	'help|?' 											=> \$help,
						'--in_RSEM|input_RSEM=s{,}' 	=> \@in_RSEM,
						'label_RSEM=s{,}' 						=> \@label_RSEM, 
						'--in_sailfish|input_sailfish=s{,}' 	=> \@in_sailfish,
						'label_sailfish=s{,}' 						=> \@label_sailfish, 
						'--in_eXpress|input_eXpress=s{,}' => \@in_eXpress,
						'label_eXpress=s{,}' 					=> \@label_eXpress,
						'--out|output=s' 							=> \$out 
					) or pod2usage(-verbose => 1 );
pod2usage(-verbose => 1) if $help;
$out or die "Outputname required\nUse --help for more information\n";

if (@label_RSEM){	#Die if label and input are of different length
	unless (@in_RSEM==@label_RSEM) {
		die "Different number of RSEM-inputfiles and RSEM-labels\n";
	}
} else {	#If no labels specified, set labels to inputfiles
	(@label_RSEM)=(@in_RSEM);
}
if (@label_sailfish){	#Die if label and input are of different length
	unless (@label_sailfish==@in_sailfish){
		die "Different number of eXpress-inputfiles and eXpress-labels\n";
	} 
} else {  #If no labels specified, set labels to inputfiles
	(@label_sailfish)=(@in_sailfish);
} 
if (@label_eXpress){	#Die if label and input are of different length
	unless (@label_eXpress==@in_eXpress){
		die "Different number of eXpress-inputfiles and eXpress-labels\n";
	} 
} else {  #If no labels specified, set labels to inputfiles
	(@label_eXpress)=(@in_eXpress);
} 


##Set connection between Files and Labels
my %data = ();
my $counter = 0;
foreach my $R_label(@label_RSEM){
	$data{$R_label}={"file"=>$in_RSEM[$counter],"type"=>"RSEM"};
	$counter++;
}
$counter = 0;
foreach my $s_label(@label_sailfish){
	$data{$s_label}={"file"=>$in_sailfish[$counter],"type"=>"sailfish"};
	$counter++;
}
$counter = 0;
foreach my $e_label(@label_eXpress){
	$data{$e_label}={"file"=>$in_eXpress[$counter],"type"=>"eXpress"};
	$counter++;
}
$counter = 0;



##Setting of ID->Counts relationship for each inputfile
my %seen;	#Hash for occuring IDs
foreach my $key(keys (%data)){
	open (my $fh,"<",$data{$key}{file}) or die "Cannot open input $data{$key}\n";
	<$fh>;
	if($data{$key}{type}eq"sailfish"){
	    # Remove sailfish header
	    <$fh>;<$fh>;<$fh>;<$fh>;
	}
	while (<$fh>){
	    chomp;
	    my @line=split (/\t/,$_);
	    if ($data{$key}{type}eq"RSEM"){
		$data{$key}{$line[0]}=$line[4];
		$seen{$line[0]}='';
	    } elsif($data{$key}{type}eq"sailfish") {
	        $data{$key}{$line[0]}=$line[6];
		$seen{$line[0]}='';
	    } else {
		$data{$key}{$line[1]}=$line[7];
		$seen{$line[1]}='';
	    }
	}
	close ($fh) or die "Cannot close input $data{$key}\n";
}


##Creation of count matrix
my @labels=((@label_RSEM),(@label_sailfish),(@label_eXpress));	#All labels
my @counts;
push (@counts,("ID",(@labels)));		#First thing in array for count matrix are labelnames
foreach my $ID(keys (%seen)){
	push (@counts,$ID);
	foreach my $label(@labels){
		if (defined $data{$label}{$ID}){
			push (@counts, $data{$label}{$ID})
		}	else {
			die "$ID doesn't exist in file $data{$label}{file}\n";
		}
	}
}


##Print count matrix to outputfile
open (OUT,">",$out) or die "Cannot open outputfile $out\n";
my $step=@labels+1;	#Number of experiments + Transcript_ID
for (my $x=0;$x<@counts;$x+=$step){
	print OUT join("\t",@counts[$x..$x+$step-1]),"\n";
}
close (OUT) or die "Cannot close outputfile $out\n";













