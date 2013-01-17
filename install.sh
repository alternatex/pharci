#!/bin/bash
npm install
bower install
shinst install alternatex/bazinga # TODO: silent abort if already installed or check first ;-)
printf "pharci is installed (TODO: add pre/post checks).\n"