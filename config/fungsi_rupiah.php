<?php
function format_hits($hits){
  $hits=number_format($hits,0,',',',');
  return $hits;
}
?> 