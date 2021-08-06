<?php

function validSession($id, $userId) {

  if($id == $userId) {
    return true;
  }
  return false;
}
