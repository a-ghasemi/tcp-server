### Question
* Builds a server that accepts incoming TCP connections
* For each connection,
    * reads URLs, delimited by a newline character "\n"
    * For each URL,
        * request it
        * writes both the URL and the response status code (e.g. `200`) to a new line in a file on disk.

### Sample
> ncat 127.0.0.1 6666 < <(echo -e  "https://www.google.com/search?ei=9vImXZvBEYzSa7DNqcAI&q=Zarkharid.com\nhttps://zarkharid.com/en/#\nhttps://github.com\nhttp://www.google.com/foo")
