<?php

  # NOT: https://wordsift.org/ sitesinden esinlenilmiştir.

  $Dosya = file_get_contents("konusma1.txt");

  // Noktalama işaretleri ve sayıları yok edelim.
  $arrSilinecekler = file("silinecekler.txt");
  foreach ($arrSilinecekler as $sil) {
    $sil = trim($sil);
    $Dosya = str_replace($sil, " ", $Dosya);
  }
  $Dosya = str_replace("\n", " ", $Dosya);

  // Konuşma dosyasının her  bir satırı için çalışalım
  $arrListe=array();
  $arrKelimeler=explode(" ", $Dosya);
  echo "Başlangıç Kelime Sayısı: " . count($arrKelimeler) . "<br>";
  foreach ($arrKelimeler as $Kelime) {
    $Kelime  = mb_strtoupper($Kelime);
    $Kelime  = trim($Kelime);
    if($Kelime != "") $arrListe[$Kelime]++;
    /*
    if(!isset($arrListe[$Kelime])) {
      $arrListe[$Kelime] = 1;
    } else {
      $arrListe[$Kelime]++;
    }
    */
  }

  // StopWords'leri sonuç dizisinden siliyoruz
  $arrStopWords = file("stopwords.txt");
  foreach ($arrStopWords as $word) {
    $word = mb_strtoupper($word);
    $word = trim($word);
    unset($arrListe[$word]);
  }

  echo "Bitiş Kelime Sayısı: " . count($arrListe) . "<br>";
  // Sonuç için sıralama yapalım...
  arsort($arrListe);
  $arrListe = array_slice($arrListe, 0, 20);

  $SonucDosyasi = "";
  foreach ($arrListe as $key => $value) {
    $SonucDosyasi .= "$key,$value\n";
  }
  echo $SonucDosyasi;
  file_put_contents("ozet.txt", $SonucDosyasi);

  echo "<h1>Analiz Sonucu</h1>";
  echo "<pre>";
  print_r($arrListe);
  echo "</pre>";












?>
