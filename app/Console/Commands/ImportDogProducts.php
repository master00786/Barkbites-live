<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use App\Models\Product;

class ImportDogProducts extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'import:dog-products';

    /**
     * The console command description.
     */
    protected $description = 'Import dog food products from CSV file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $path = storage_path('app/dog_products.csv');

        // 1. Check CSV exists
        if (!File::exists($path)) {
            $this->error('CSV file not found at: ' . $path);
            return Command::FAILURE;
        }

        // 2. Read file
        $content = file_get_contents($path);

        // Remove BOM if exists
        $content = preg_replace('/^\xEF\xBB\xBF/', '', $content);

        $lines = preg_split("/\r\n|\n|\r/", trim($content));

        if (count($lines) <= 1) {
            $this->error('CSV file has no data rows.');
            return Command::FAILURE;
        }

        // 3. Detect delimiter (, or ;)
        $headerLine = $lines[0];
        $delimiter = (substr_count($headerLine, ';') > substr_count($headerLine, ',')) ? ';' : ',';

        $this->info('Detected delimiter: ' . $delimiter);
        $this->info('Header: ' . $headerLine);

        // 4. Parse CSV
        $rows = array_map(function ($line) use ($delimiter) {
            return str_getcsv($line, $delimiter);
        }, $lines);

        // Remove header
        unset($rows[0]);

        $count = 0;

        // 5. Insert products
        foreach ($rows as $row) {

            $name  = trim($row[0] ?? '');
            $price = trim($row[1] ?? '');
            $image = trim($row[2] ?? '');

            if ($name === '') {
                continue;
            }

            Product::create([
				'name'           => $name,
				'cat_id'         => 2,
				'brand'          => 'BarkBites',
				'price'          => $price !== '' ? $price : 0,
				'discount_price' => 0,
				'image'          => $image,
				'description'    => 'Premium dog food by BarkBites', // ✅ REQUIRED
			]);



            $count++;
        }

        $this->info("Imported: {$count} products successfully!");
        return Command::SUCCESS;
    }
}
