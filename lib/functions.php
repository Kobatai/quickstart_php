<?php

//配列の中身をvardumpする
function dd(){

  echo '<pre>';

  //関数に渡された引数を配列で取得
  $args = func_get_args();

  foreach ($args as $arg){
    var_dump($arg);
  }

  echo '</pre>';
  exit;
}

//配列の中身を取得 なければnullを返す
function array_get($array, $key, $default = null){
  if (is_array($array) && isset($array[$key])){
    return $array[$key];
  }

  return $default;
}


function request_get($key, $default = null){
  if(isset($_POST[$key])){
    return array_get($_POST, $key ,$default);
  }

  if(isset($_GET[$key])){
    return array_get($_GET, $key ,$default);
  }

  return $default;
}

//csrf(クロスサイトリクエストフォージェリ)対策
function h($string){
  return htmlspecialchars($string, ENT_QUOTES);
}

//文字列をsql用に変換する
function quote_sql($string){
  $quote_str = '`';
  return $quote_str.str_replace($quote_str,'', $string).$quote_str;
}

//受け取った文字列に' ', '-' , '_'があれば消し文字列の先頭を大文字にして返す
function camelize(string $s){
  return str_replace([' ', '-' , '_'], '', ucwords($s, ' -_'));
}

function redirect($url){
  header('Location: '.$url);
  exit();
}



























