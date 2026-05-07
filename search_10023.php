<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

$tables = DB::select('SHOW TABLES');
foreach($tables as $table) {
    $tableName = array_values((array)$table)[0];
    if($tableName == 'migrations') continue;
    
    $columns = Schema::getColumnListing($tableName);
    foreach($columns as $col) {
        try {
            $exists = DB::table($tableName)->where($col, '10023')->exists();
            if($exists) {
                echo "Found 10023 in $tableName.$col\n";
            }
        } catch(\Exception $e) {
            // Skip columns that can't be queried this way
        }
    }
}
