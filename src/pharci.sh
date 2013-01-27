#!/bin/bash

# ENSURE PHP PROC KILLED WHEN SCRIPT EXITS
# ENSURE NO PROCESS RUNNING TARGETING SAME OUTFILE
# IMPLEMENT / USE ALL SETTINGS *
# ON ERROR REBUILD // THINK. HANDLE.
# FINALIZE / CLEANUP WATCH SCRIPT 

# TODO NEXT:
# REMOVE HC* - almost done » pharci-watch.php to go
#
# BASH APPROACH XXXcoprocXXX
#
# COPROC * COPROC * COPROC * COPROC * COPROC 
# COPROC * COPROC * COPROC * COPROC * COPROC 
# COPROC * COPROC * COPROC * COPROC * COPROC 
# LOOP THROUGH REDIS W/ PUB/SUB W/PREDIS ?! MORE EFFICIENT THAN FS, RIGHT?
# 
#

set +v

# initialize pharci
. ./pharci_init.sh

# filedescriptor>output
. ./pharci_stdout.sh

# filedescriptor>input
. ./pharci_stdin.sh

# start pubsub module
. ./pharci_pubsub.sh