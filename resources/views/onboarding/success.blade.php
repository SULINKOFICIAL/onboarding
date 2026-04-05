<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Onboarding concluído</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f6f8fb; margin: 0; padding: 24px; color: #182230; }
        .container { max-width: 680px; margin: 0 auto; background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 24px; }
        h1 { margin-top: 0; }
        .box { background: #f8fafc; border: 1px solid #e5e7eb; border-radius: 8px; padding: 12px; margin-top: 10px; }
        .btn { display: inline-block; margin-top: 16px; border-radius: 8px; padding: 10px 16px; background: #1f6feb; color: #fff; text-decoration: none; font-weight: 700; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Onboarding enviado com sucesso</h1>
        <p>Resumo dos dados enviados:</p>
        <div class="box">
            <pre>{{ json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
        </div>
        <a class="btn" href="{{ route('onboarding.step', ['step' => 1]) }}">Novo onboarding</a>
    </div>
</body>
</html>

