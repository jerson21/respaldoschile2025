<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

$_SESSION['nombre_user'] = $_SESSION["s_usuario"];



if ($_SESSION["s_usuario"] === null) {

  header("Location: ../index.php");
}

function minify_css($css) {
  // Elimina comentarios
  $css = preg_replace('!/\*.*?\*/!s', '', $css);
  
  // Protege expresiones calc()
  preg_match_all('/calc\((.*?)\)/', $css, $matches);
  $calcExpressions = $matches[0];
  $placeholder = '___CALC___';
  $css = preg_replace('/calc\((.*?)\)/', $placeholder, $css);
  
  // Elimina saltos de línea y múltiples espacios
  $css = preg_replace('/\s+/', ' ', $css);
  
  // Elimina espacios innecesarios alrededor de símbolos
  $css = preg_replace('/\s*([\{\}\:\;\,])\s*/', '$1', $css);
  
  // Restaura las expresiones calc()
  foreach ($calcExpressions as $expr) {
      $css = preg_replace($placeholder, $expr, $css, 1);
  }
  
  return trim($css);
}

function getMinifiedHeaderEstilos() {
  ob_start();
  include 'css/header_estilos.php';
  $css = ob_get_clean();
  return minify_css($css);
}
?>