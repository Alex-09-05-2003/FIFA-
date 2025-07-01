<?php
header('Content-Type: application/json');

// Poți înlocui asta cu date dintr-o bază de date dacă vrei
$data = [
  "titlu" => "EA Sports FC 25",
  "mesaj" => "Este noua generație a jocurilor FIFA, fără branding FIFA, dar cu inovații și licențe reale."
];

echo json_encode($data);
?>
