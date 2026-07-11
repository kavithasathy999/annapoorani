<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\EstimateController;

$controller = new EstimateController();
$response = $controller->index();

DB::enableQueryLog();
$view = $response->render();
$queries = DB::getQueryLog();

echo "Number of queries executed during rendering: " . count($queries) . "\n";
echo "First 10 queries details:\n";
for ($i = 0; $i < min(10, count($queries)); $i++) {
    echo ($i+1) . ": " . $queries[$i]['query'] . "\n";
}
