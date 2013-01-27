#!/bin/bash

# start redis server
~/.redis/src/redis-server &

coproc cli {
    ~/.redis/src/redis-cli >&2
}

exec 3<&${cli[0]}

while IFS= read -ru 3 x; do printf '%s\n' "$x"; done &

# attention performance w/ watchmedo when executing recursively > deep trees = no good.

# launch watchdog and redirect it's output to redis
watchmedo shell-command \
    --patterns="*.txt" \
    --command='echo "SELECT 8";' "/Users/bazinga/" >&${cli[1]};