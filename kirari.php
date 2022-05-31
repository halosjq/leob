<?php require __DIR__ . '/vendor/autoload.php';

use App\Cli\Color;
use App\Config\Request;

\App\Config\ErrorLog::ActivateErrorLog('./src/logs/', 0);

if (php_sapi_name() !== 'cli') {
    die('This script must be run from the command line.');
}


$app = new App\Cli\App();
$printer = $app->GetPrinter();

// Start php dev server
$app->Register('server', function() use ($printer) {
    set_time_limit(0);
    $printer->Clear(); // Clear the screen
    $printer->Out(Color::Fg(82, 'Starting server on port 8000 (https://localhost:8000/) '));
    $printer->Out("\t Pres CTRL+C to stop.");
    $printer->NewLine();
    shell_exec('php -S localhost:8000 -t public/');
});

// Share
$app->Register('share', function ($argv) use ($printer) {
    $def = $argv[2] ?? 'ngrok'; // Default value
    switch ($def) {
        case 'ngrok': $cmd = 'ngrok http 8000'; break;
        default: $printer->Display(Color::Bg(150, Color::Fg(232, 'Invalid arg ' . $def))); die; break;
    }
    $printer->Out('Share your server with: ' . $def . "\t\t(Ctrl + C to kick)");
    $printer->Display(Color::Fg(82, "Web Interface: http://127.0.0.1:4040 \t\t"));
    shell_exec($cmd);
});

// Set webhook
$app->Register('setwebhook', function() use ($printer)
{
    $token = $printer->Read('Enter your bot token: ');
    $webhook = $printer->Read('Enter your webhook url: ');

    $url = 'https://api.telegram.org/bot' . $token . '/setWebhook?url=' . $webhook;
    $printer->Display(Color::Fg(82, "Setting webhook: " . $url));

    $res = Request::Get($url);
    $res = json_decode($res['response'], true);

    if ($res['ok']) {
        $printer->Display(Color::Fg(82, "Response: " . $res['description']));
    } else {
        $printer->Display(Color::Fg(196, "Response: " . $res['description']));
    }
});

$app->Register('req', function() use ($printer) {
    $url = $printer->Read('Enter your url: ');
    $method = $printer->Read('Enter your http method: ');
    $post = $printer->Read('Enter your post data: ');

    $res = Request::$method($url, null, $post);

    $printer->Clear();
    $printer->Out(Color::Fg(82, 'Target url: ') . Color::Fg(14, $url))->NewLine();
    $printer->Out(Color::Fg(82, 'Method: ') . Color::Fg(14, $method))->NewLine();
    $printer->Out(Color::Fg(82, 'Post data: ') . Color::Fg(14, $post))->NewLine();
    $printer->Out(Color::Fg(82, 'Http code: ') . Color::Fg(14, $res['code']))->NewLine();
    $printer->Out(Color::Fg(82, 'Response: ') . Color::Fg(14, $res['response']))->NewLine()->NewLine();

    $save = strtolower($printer->Read('Save response? (y/n): '));
    if ($save == 'y') {
        $file = $printer->Read('Enter your file name: ');
        file_put_contents($file, json_encode($res));
    }
});

$app->Register('help', function () use ($app, $printer) {
    $txt = Color::Fg(13, 'Usage: php kirari [command] [options]'). PHP_EOL;
    $txt .= 'Available commands:'. PHP_EOL;

    foreach ($app->GetAllCmds() as $i => $item) {
        $txt .= ' - ' . Color::Fg(9, $i) . PHP_EOL;
        unset($item);
    }
    $printer->Display(trim($txt));
});


$app->Run($argv);