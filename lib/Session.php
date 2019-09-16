<?php

class Session{

  protected $bag;

  public function __construct($namespace = 'app'){

    if(!session_id()){
      session_start();
    }

    //参照による代入 データのコピーはせず代入されたbagも同じセッションを見てるだけ
    $this->bag = &$_SESSION[$namespace];

    if(!isset($this->bag)){
      //$bag[app_data] = [];
      $this->bag[$this->getAppDataKey()] =[];
      if(!$this->getCsrfToken()){
        //$bag[csrf_token] = [sha1(uniqid(rand(), true)];
        $this->bag[$this->getCsrfTokenKey()] = $this->generateCsrfToken();
      }
    }
  }

  public function getAppDataKey(){

    return 'app_data';
  }

  public function getCsrfTokenKey(){

    return 'csrf_token';
  }

  public function getRequestCsrfTokenKey(){

    return '__csrf_token';
  }

  public function generateCsrfToken(){

    return sha1(uniqid(rand(), true));
  }

  public function getCsrfToken(){

    //$bag[csrf_token]の中身を取得する
    return array_get($this->bag,$this->getCsrfToken());
  }

  public function verifyCsrfToken(){

    //POSTされたcsrfTokenを取得 nameは__csrf_token
    $request_token = request_get($this->getRequestCsrfTokenKey());

    //bagの中のcsrf_tokenを取得
    $valid_token = $this->getCsrfToken();

    //合致してるか比較
    return $request_token === $valid_token;
  }

  public function get($key, $default = null){

    //同じcsrf_tokenのものの配列の中身を返す
    return array_get($this->bag[$this->getCsrfToken()],$key,$default);
  }


  public function set($key, $value){

    return $this->bag[$this->getAppDataKey()][$key] = $value;
  }

  public function unset($key){

    unset($this->bag[$this->getAppDataKey()][$key]);
  }

  public function unsetAll(){

    $this->bag[$this->getAppDataKey()] = [];
  }

  public function flash($key,$default){

    //keyの中身を取得
    $value = $this->get($key,$default);
     //$bag[app_data][errors]の中身を削除する
    $this->unset($key);

    return $value;
  }

}
