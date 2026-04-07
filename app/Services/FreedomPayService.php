<?php
namespace App\Services;
class FreedomPayService{  
    public function buildInitPaymentUrl(array $params): string
    {
        $params['pg_sig'] = $this->makeSignature('init_payment.php', $params);
        return 'https://api.freedompay.kz/init_payment.php?' . http_build_query($params);
    }
    /**
     * Генерация подписи
     */
    public function makeSignature(string $scriptName, array $params): string
    {
        ksort($params); // сортируем по ключам

        $values = array_values($params); // берем только значения

        array_unshift($values, $scriptName); // добавляем имя скрипта в начало
        array_push($values, config('services.freedom.secret_key')); // добавляем секрет

        return md5(implode(';', $values));
    }
    /**
     * Проверка подписи (для callback)
     */
    public function checkSignature(string $scriptName, array $params): bool
    {
        if (!isset($params['pg_sig'])) {
            return false;
        }

        $receivedSignature = $params['pg_sig'];
        unset($params['pg_sig']);

        $generatedSignature = $this->makeSignature($scriptName, $params);

        return $receivedSignature === $generatedSignature;
    }
}