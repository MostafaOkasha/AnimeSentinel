<?php

namespace App\AnimeSentinel;

class MyAnimeList
{
  /**
   * Does a search on MAL with the requested query.
   * Returns all results.
   *
   * @return SimpleXMLElement
   */
  private static function searchApi($query) {
    // Preform curl request
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'http://myanimelist.net/api/anime/search.xml?q='.str_replace(' ', '+', $query));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_USERNAME, config('animesentinel.mal_username'));
    curl_setopt($curl, CURLOPT_PASSWORD, config('animesentinel.mal_password'));
    $response = curl_exec($curl);
    curl_close($curl);
    // Convert to and return xml
    $xml = simplexml_load_string($response);
    // TODO: filter hentai ...
    return $xml;
  }

  /**
   * Does a search on MAL with the requested query.
   * Converts the results to an array of stdClass.
   *
   * @return array
   */
  public static function search($query) {
    $xml = Self::searchApi($query);
    if (!$xml) {
      return [];
    }
    foreach ($xml as $entry) {
      $result = json_decode(json_encode($entry));
      // Ensure synonyms is an array
      $result->synonyms = explode('; ', json_encode($result->synonyms));
      $result->mal = true;
      $results[] = $result;
    }
    return $results;
  }

  /**
   * Does a search on MAL with the requested query.
   * Returns only the first result where the query matches one of the titles
   *
   * @return stdClass
   */
  public static function searchStrict($query) {
    $results = Self::search($query);

    foreach ($results as $result) {
      // Create alts list
      $alts[] = $result->title;
      $alts[] = $result->english;
      $alts = array_merge($alts, $result->synonyms);
      // Check for a match
      foreach ($alts as $alt) {
        if (Helpers::match_titles($alt, $query)) {
          return $result;
        }
      }
    }

    return false;
  }

  /**
   * Grabs all important data from MAL for the anime with the requested id.
   *
   * @return array
   */
  public static function getAnimeData($mal_id) {
    // TODO
    return [];
  }
}