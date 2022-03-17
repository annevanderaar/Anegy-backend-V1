<?php
$API_KEY = "api_key=bcf92184fb403a95217a5f2d32a0a8df";
$BASE_URL = "https://api.themoviedb.org/3";

$API_URL_MOVIES_POPULAR = $BASE_URL . "/discover/movie?sort_by=popularity.desc&" . $API_KEY;
$API_URL_MOVIES_PLAYING = $BASE_URL . "/movie/now_playing?" . $API_KEY;

$API_URL_SERIES_POPULAR = $BASE_URL . "/discover/tv?sort_by=popularity.desc&" . $API_KEY;

$SEARCH_URL_MOVIES = $BASE_URL . "/search/movie?" . $API_KEY;
$SEARCH_URL_SERIES = $BASE_URL . "/search/tv?" . $API_KEY;