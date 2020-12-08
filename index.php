<?php
require 'connection.php';

$sql = $conn->query("SELECT * FROM price");

$priceData = [];
if ($sql->num_rows > 0) {
  while($row = $sql->fetch_assoc()) {
    $prettyPrice = 'Rp ' . number_format($row['price'], 0, ',', '.');
    $discountPriceArr = explode('.', number_format($row['discount_price'], 0, ',', '.'));
    
    $discountPrice = [];
    foreach ($discountPriceArr as $col => $val) {
      if ($col === 0) {
        $discountPrice['big'] = $val;
      } else {
        $discountPrice['small'][] = $val;
      }
    }

    $service = $row['service'];
    $best = $row['best'];
    $user = number_format($row['user_count'], 0, ',', '.');
    $description = $row['description'];

    $priceData[] = [
      'price' => $prettyPrice,
      'best' => $best,
      'service' => $service,
      'user' => $user,
      'description' => $description,
      'discount' => [
        'big' => $discountPrice['big'],
        'small' => implode('.', $discountPrice['small'])
      ]
    ];
  }
}

require_once './vendor/autoload.php';
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(__DIR__ . '/template');
$twig = new Environment($loader);

echo $twig->render('layout.html', [
  'title' => 'Web Hosting Indonesia Unlimited & Terbaik - Niagahoster',
  'price' => $priceData
]);