<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Region;
use App\Models\City;
use App\Models\District;

class ImportKazakhstanCommand extends Command
{
    protected $signature = 'kaz:import';
    protected $description = 'Импорт административного деления Казахстана из newkaz.txt';

    public function handle()
    {
        $file = base_path('newkaz.txt');

        if (!file_exists($file)) {
            $this->error("Файл newkaz.txt не найден!");
            return 1;
        }
        $lines = file($file, FILE_IGNORE_NEW_LINES);
        $specialMode = false;     // режим "Города республиканского значения"
        $currentRegion = null;
        $currentCity = null;
        foreach ($lines as $raw) {

            // Удаляем пробелы справа
            $raw = rtrim($raw);

            // Пропускаем пустые строки
            if (trim($raw) === '') continue;

            // Получаем строку без начальных пробелов
            $line = ltrim($raw);

            // Количество пробелов слева — уровень вложенности
            $indent = strlen($raw) - strlen($line);

            // ----------------------------------------------------------
            // 1) Обнаружили "Города республиканского значения"
            // ----------------------------------------------------------
            if ($indent == 2 && trim($line) == 'Города республиканского значения') {
                $specialMode = true;
                continue;
            }

            // ----------------------------------------------------------
            // 2) Спец-город (Астана, Алматы, Шымкент) — уровень 4 пробела
            // ----------------------------------------------------------
            if ($specialMode && $indent == 4) {

                $name = trim($line);

                // Создаём регион
                $currentRegion = Region::firstOrCreate([
                    'name' => $name
                ], [
                    'is_special' => 1
                ]);

                // Создаём город
                $currentCity = City::firstOrCreate([
                    'region_id' => $currentRegion->id,
                    'name'      => $name
                ], [
                    'is_region_center' => 1,
                    'is_city_of_region' => 1
                ]);

                continue;
            }

            // ----------------------------------------------------------
            // 3) Районы спец-городов — уровень 6 пробелов
            // ----------------------------------------------------------
            if ($specialMode && $indent == 6 && $currentCity) {

                District::firstOrCreate([
                    'city_id' => $currentCity->id,
                    'name'    => trim($line)
                ]);

                continue;
            }

            // ==========================================================
            // ПОСЛЕ спец-городов — отключаем specialMode,
            // когда встретили новую ОБЛАСТЬ
            // ==========================================================
            if ($indent == 2 && $specialMode && trim($line) != 'Города республиканского значения') {
                // Выходим из режима спец-городов
                $specialMode = false;
            }

            // ----------------------------------------------------------
            // 4) ОБЛАСТЬ — уровень 2 пробела
            // ----------------------------------------------------------
            if ($indent == 2 && !$specialMode) {

                $name = trim($line);

                // Если есть "(центр: ...)" — удаляем
                if (strpos($name, '(') !== false) {
                    $name = trim(explode('(', $name)[0]);
                }

                $currentRegion = Region::firstOrCreate([
                    'name' => $name
                ], [
                    'is_special' => 0
                ]);

                $currentCity = null;
                continue;
            }

            // ----------------------------------------------------------
            // 5) Город областного значения или райцентр — уровень 4 пробела
            // ----------------------------------------------------------
            if ($indent == 4 && !$specialMode) {

                // Пример строки: "Семей (город областного значения)"
                if (strpos($line, '(центр:') !== false) {
                    // район области с собственным центром
                    // строка вида: "Абайский район (центр: Караул)"
                    $parts = explode('(центр:', $line);
                    $cityName = trim(str_replace(')', '', $parts[1]));

                    // Создаём город — центр района
                    $currentCity = City::firstOrCreate([
                        'region_id' => $currentRegion->id,
                        'name'      => $cityName
                    ], [
                        'is_region_center' => 0,
                        'is_city_of_region' => 0
                    ]);

                } else {
                    // "Семей (город областного значения)" — удаляем скобки
                    $name = trim(explode('(', $line)[0]);

                    $currentCity = City::firstOrCreate([
                        'region_id' => $currentRegion->id,
                        'name'      => $name
                    ], [
                        'is_region_center' => 0,
                        'is_city_of_region' => 1 // важно!
                    ]);
                }

                continue;
            }

            // ----------------------------------------------------------
            // 6) Районы областей — уровень 6 пробелов
            // ----------------------------------------------------------
            if ($indent == 6 && !$specialMode && $currentCity) {

                District::firstOrCreate([
                    'city_id' => $currentCity->id,
                    'name'    => trim($line)
                ]);

                continue;
            }
        }

        $this->info("Импорт завершён успешно!");
        return 0;
    }
}
