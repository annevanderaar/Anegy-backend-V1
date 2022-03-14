<?php
$API_KEY = "api_key=bcf92184fb403a95217a5f2d32a0a8df";
$BASE_URL = "https://api.themoviedb.org/3";
$API_URL = $BASE_URL . "/discover/movie?sort_by=popularity.desc&" . $API_KEY;
$SEARCH_UTL = $BASE_URL . "/search/movie?" . $API_KEY;