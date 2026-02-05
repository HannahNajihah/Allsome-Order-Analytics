<?php

// JSON headers for API-readiness
header('Content-Type: application/json; charset=utf-8');
header('X-API-Version: v1');

/**
 * Load and parse orders from CSV file
 */
function loadOrders(string $filePath): array
{
    if (!file_exists($filePath)) {
        throw new Exception("CSV file not found: $filePath");
    }

    $handle = fopen($filePath, 'r');

    if ($handle === false) {
        throw new Exception("Unable to open CSV file: $filePath");
    }

    $orders = [];
    $skippedRows = [];
    $rowNumber = 1;

    // Read headers
    $headers = fgetcsv($handle);

    if (!$headers) {
        throw new Exception("CSV file is empty or invalid");
    }

    // Read rows
    while (($row = fgetcsv($handle)) !== false) {
        $rowNumber++;

        if (count($row) !== count($headers)) {
            $skippedRows[] = $rowNumber;
            error_log("Skipped row $rowNumber due to column mismatch");
            continue;
        }

        $orders[] = array_combine($headers, $row);
    }

    fclose($handle);
    return $orders;
}

/**
 * Calculate analytics
 */
function calculateAnalytics(array $orders): array
{
    $totalRevenue = 0.0;
    $skuQuantities = [];
    $skippedRows = [];

    foreach ($orders as $index => $order) {

        if (
            empty($order['sku']) ||
            !is_numeric($order['quantity']) ||
            !is_numeric($order['price'])
        ) {
            $skippedRows[] = $index + 2;
            continue;
        }

        $sku = trim($order['sku']);
        $quantity = (int)$order['quantity'];
        $price = (float)$order['price'];

        $totalRevenue += $quantity * $price;

        $skuQuantities[$sku] = ($skuQuantities[$sku] ?? 0) + $quantity;
    }

    arsort($skuQuantities);
    $bestSku = array_key_first($skuQuantities);

    return [
        "total_revenue" => round($totalRevenue, 2),
        "best_selling_sku" => $bestSku ? [
            "sku" => $bestSku,
            "total_quantity" => $skuQuantities[$bestSku]
        ] : null
    ];
}

/**
 * Main execution
 */
try {
    $csvFile = __DIR__ . "/allsome_interview_test_orders.csv";

    $orders = loadOrders($csvFile);
    $result = calculateAnalytics($orders);

    echo json_encode($result, JSON_PRETTY_PRINT);

} catch (Exception $e) {
    echo json_encode([
        "error" => $e->getMessage()
    ]);
}
