#!/bin/bash

# debug switch descriptor to use
export descriptor=3

# initialize
source initialize.sh

# start socket server
source socketserver.sh

# add file
command "~/Desktop/test.txt" "" "created" "file"
command "~/Desktop/test.txt" "" "created" "file2"
command "~/Desktop/test.txt" "" "created" "file3"
command "~/Desktop/test.txt" "" "created" "file4"
command "~/Desktop/test.txt" "" "created" "file5"

# shutdown socket server
shutdown