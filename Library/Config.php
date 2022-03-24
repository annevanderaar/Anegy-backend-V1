<?php
$API_KEY = "api_key=bcf92184fb403a95217a5f2d32a0a8df";
$BASE_URL = "https://api.themoviedb.org/3";

$API_URL_MOVIES_DISCOVER_POPULAR = $BASE_URL . "/discover/movie?sort_by=popularity.desc&" . $API_KEY;
$API_URL_MOVIES_POPULAR = $BASE_URL . "/movie/popular?" . $API_KEY;
$API_URL_MOVIES_PLAYING = $BASE_URL . "/movie/now_playing?" . $API_KEY;
$API_URL_MOVIES_TOP_RATED = $BASE_URL . "/movie/top_rated?" . $API_KEY;
$API_URL_MOVIES_UPCOMING = $BASE_URL . "/movie/upcoming?" . $API_KEY;

$API_URL_SERIES_DISCOVER_POPULAR = $BASE_URL . "/discover/tv?sort_by=popularity.desc&" . $API_KEY;
$API_URL_SERIES_POPULAR = $BASE_URL . "/tv/popular?" . $API_KEY;
$API_URL_SERIES_AIRING = $BASE_URL . "/tv/airing_today?" . $API_KEY;
$API_URL_SERIES_ON_AIR = $BASE_URL . "/tv/on_the_air?" . $API_KEY;
$API_URL_SERIES_TOP_RATED = $BASE_URL . "/tv/top_rated?" . $API_KEY;

$SEARCH_URL = $BASE_URL . "/search/multi?" . $API_KEY . "&query=";
$SEARCH_URL_MOVIES = $BASE_URL . "/search/movie?" . $API_KEY;
$SEARCH_URL_SERIES = $BASE_URL . "/search/tv?" . $API_KEY;
$SEARCH_URL_PERSON = $BASE_URL . "/search/person?" . $API_KEY;