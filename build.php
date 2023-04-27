<?php
/**
 * Writes autocomplete attributes to the Sprig Support JSON file in `/src`.
 *
 * @see https://github.com/microsoft/vscode-html-languageservice/blob/main/docs/customData.md
 *
 * @copyright Copyright (c) PutYourLightsOn
 */

$path = 'https://raw.githubusercontent.com/putyourlightson/craft-sprig/develop/src/autocompletes/sprig-attributes.json';
$attributes = json_decode(file_get_contents($path), true);

$globalAttributes = [];
$valueSets = [];
foreach ($attributes as $attribute) {
    $name = $attribute['name'];
    $globalAttributes[] = [
        'name' => $attribute['name'],
        'description' => $attribute['description'],
        'valueSet' => $attribute['name'],
        'references' => $attribute['links'] ?? [],
    ];
    $valueSets[] = [
        'name' => $name,
        'values' => $attribute['values'] ?? [],
    ];
}

$json = json_encode([
    'version' => '1.1',
    'globalAttributes' => $globalAttributes,
    'valueSets' => $valueSets,
]);

$path = './src/sprig-support.json';
if (file_put_contents($path, $json)) {
    echo 'JSON successfully written to `' . $path . '`.';
} else {
    echo 'Error writing JSON to `' . $path . '`.';
}
