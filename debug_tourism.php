$data = \Modules\Tourism\Models\Tourism::all();
echo "Count: " . $data->count() . "\n";
foreach($data as $item) {
    $lat = $item->latitude ?? 'NULL';
    $lng = $item->longitude ?? 'NULL';
    echo "ID: {$item->id}, Name: {$item->name}, Status: {$item->status}, Lat: {$lat}, Lng: {$lng}\n";
}
