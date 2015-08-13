#!/usr/bin/perl
use strict;
use warnings;
use JSON;

my $release = '14_1.03';
my $cartname = 'cooler_cart_von_markus';
my $json = {'carts' => {$release  => {$cartname => {'items'=>[],'notes'=>'','created'=>1439475292,'modified'=>1439475292}}}, 'metadata' => {$release  => {} } };
# "3633838":{"alias":"my","annotations":"Anno"}
# {"14_1.03":{"Group1":{"items":[3556407],"notes":"","created":1439475292,"modified":1439475292}}}

open IN, "<$ARGV[0]" or die $!;
while(<IN>){
    next unless(/^\d/);
    chomp;
    my @line = split(/\t/);
    $json->{'metadata'}{$release}{$line[0]} = {'alias' => $line[5], 'annotations' => $line[6]};
    push($json->{'carts'}{$release}{$cartname}{'items'}, $line[0]);
}
close IN or die $!;

print encode_json $json;
