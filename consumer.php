<?php

# Build a server that accepts incoming TCP connections
# For each connection,
#   read URLs, delimited by a newline character "\n".       TC1
#   For each URL,
#       request it                                          TC2
#       write both the URL and the response status code (e.g. `200`) to a new line in a file on disk.
# Example
# ncat 127.0.0.1 6666 < <(echo -e  "https://www.google.com/search?ei=9vImXZvBEYzSa7DNqcAI&q=MessageBird&oq=MessageBird\nhttps://messagebird.com/en/#\nhttps://github.com/yandex/ClickHouse/blob/master/dbms/programs/server/users.xml\nhttp://www.google.com")

require_once(__DIR__ . "/vendor/autoload.php");
require_once(__DIR__ . "/config.php");


$kernel = new App\Consumer();
$kernel->main();
