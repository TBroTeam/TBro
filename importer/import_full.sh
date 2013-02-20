 #!env bash

./import.php --type map --file map/*
./import.php --type sequence --file sequences/*.fasta
./import.php --type quantification --file counts/quant.coronatin_L1.*.results
#./import.php --type quantification --file counts/*
./import.php --type annotation --subtype blast2go --file annotations/DM_tra_qt1.01.blast2go.test.annot
