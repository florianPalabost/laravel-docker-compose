vcl 4.0;

backend default {
    .host = "web";
    .port = "8080";
}

sub vcl_recv {
    return(pass);
}