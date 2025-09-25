<?php

namespace App\Helpers;

use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class MainHelper
{
  public function doAlert(int $type = 0, $text = null, $toast = true)
  {
    $alert = LivewireAlert::position('bottom-end')
      ->timer(3000);

    switch ($type) {
      case 0:
        $alert = $alert->title('Terjadi Kesalahan !')->error();
        $text = $text == null ? 'Terjadi Kesalahan, Silahkan Hubungi Administrator !' : $text;
        break;
      case 1:
        $alert = $alert->title('Berhasil !')->success();
        break;
      case 2:
        $alert = $alert->title('Perhatian !')->warning();
        break;
      case 3:
        $alert = $alert->title('Informasi !')->info();
        break;
      default:
        $alert = $alert->title('Pemberitahuan !')->question();
        break;
    }

    $alert = $alert->text($text);

    if ($toast) $alert = $alert->toast();

    $alert = $alert->show();
  }
}
