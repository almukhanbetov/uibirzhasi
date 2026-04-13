<!DOCTYPE html>
<html>

<head>
    <title>Оплата...</title>
</head>

<body>

    <h3>Переход к оплате...</h3>

    <form id="freedompay" method="POST" action="https://api.freedompay.kz/init_payment.php">
        @foreach ($params as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
    </form>

    <script>
        document.getElementById('freedompay').submit();
    </script>

</body>

</html>
