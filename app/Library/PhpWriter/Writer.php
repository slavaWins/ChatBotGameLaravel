<?php

namespace App\Library\PhpWriter;

class Writer
{

    public static function VaribleExist($f, $key)
    {
        $f = str_replace(" ", "", $f);
        if (substr_count($f, "public$" . $key . '=')) return true;
        if (substr_count($f, "private$" . $key . '=')) return true;

        return false;
    }

    public static function LineCommentator($line)
    {
        if (empty($line)) return null;
        $fragments = [
            'CreateShopRoomByCharacterType' => "Перейти в магазин предметов. Эта штука сама создает комноту, подгружает из бд товары, и создает чарактера",
            'this->scene->save' => "Это класс комнаты, наследованый от базовой комнаты. В базовой есть наборы функций. Кнопки, пагниаторы, всё для быстроботоводни",
            'extends BaseRoomPlus' => "Это класс комнаты, наследованый от базовой комнаты. В базовой есть наборы функций. Кнопки, пагниаторы, всё для быстроботоводни",
            '::LoadCharacterById' => "Загрузить чара такого типа. В ответ приходит Модель в виде этого чара",
            'response->AddWarning' => "Добавляет сверху сообщения иконку и текст. Типа алерт такой",
            'this->NextStep' => "Перейти к следующему шагу. Можно отдавать это в ретурн, оно сразу срендерит след шаг",
            '$this->scene->SetData' => "Записать с бд, в дату сцены такой-то ключ. Напрямую переменную нельзя модифицировать! После нужно вызвать save() для сцены",
            'his->DeleteRoo' => "Удалить сцену. Игрок перейдет к пред.открытой, либо веренется в Хоум",
            '$this->AddButton(' => "Эта штука проверяет, была ли нажата пользователем кнопка. И в то же время эту кнопку сам создает",
            'return $this->response' => "Возвращаем ответ, который удет пользователю. В нем кнопки и текст",
            'function Boot()' => "Эта функция вызывается при загрузки сцены",
            '$this->response->Reset' => "Очищаем овет от кнопок и текста",
            '$example =  new \App' => "Создаем класс с примером. Что бы достать из него переменные для отображения. Их не получить по другому   ",
            'user->GetAllCharacters' => "Получить все чарактеры принадлежащие игроку",
            '->PaginateSelector' => "Быстрый селектор данных. Возвращает выбранного из списка чарактера. Сам норм пагинирует всё, и вообще збс",
        ];

        foreach ($fragments as $sub => $coment) {
            if (strpos($line, $sub) > -1) {
                return $coment;
            }
        }

        return null;
    }

    public static function CodeCommentator($f)
    {
        $text = '';

        foreach (explode("\n", $f) as $V) {

            $comment = self::LineCommentator($V);
            if ($comment) $text .= "\n//" . $comment;
            $text .= "\n" . $V;


        }
        return $text;
    }

    public static function CodeFormater($f)
    {
        $text = "";
        $opens = 0;
        $emptyLines = 0;

        foreach (explode("\n", $f) as $V) {

            $V = trim($V);
            $opens = max(0, $opens);
            if (empty($V)) {
                $emptyLines++;
            } else {
                $emptyLines = 0;
            }
            if ($emptyLines > 2) continue;

            if (substr($V, -1) == "}") $opens -= 1;

            $text .= "\n";
            if ($opens > 0) $text .= str_repeat("    ", $opens);
            $text .= $V;

            if (substr($V, -1) == "{") $opens += 1;
        }
        $text = trim($text);
        return $text;
    }

    public static function DeleteLineIs($f, $lineStart = '////deleteme')
    {
        $text = "";
        foreach (explode("\n", $f) as $V) {
            if (substr_count($V, $lineStart)) continue;
            $text .= "\n" . $V;
        }
        $text = trim($text);
        return $text;
    }

    public static function AppendClassVarible($f, $key, $value)
    {

        if (is_string($value)) {
            $value = '"' . $value . '"';
        }
        $line = "public $" . $key . ' = ' . $value . ';';
        if (!self::VaribleExist($f, $key)) {
            return self::AppendClassLine($f, $line);
        }

        $list = [];
        $list[] = "public $" . $key;
        $list[] = "private $" . $key;
        $list[] = "private  $" . $key;
        foreach ($list as $V) {
            if (!substr_count($f, $V)) continue;
            $f = str_replace($V, $line . "\n" . '////deleteme', $f);
            $f = self::DeleteLineIs($f);
            return $f;
        }
        return null;
    }

    public static function AppendClassLine($f, $text)
    {
        $lines = explode("\n", $f);
        $classLine = null;
        $keyClass = -1;
        foreach ($lines as $K => $V) {
            // if (strpos($V, "{} ") === 0)  $keyClass = $K;
            if (strpos($V, "class ") === 0) {
                if (substr_count($V, "{")) {
                    $classLine = $K;
                    break;
                }
                $keyClass = $K;
            }

            if ($keyClass && substr_count($V, "{")) {
                $classLine = $K;
                break;
            }
        }

        if (!$classLine) return null;
        $res = "";
        foreach ($lines as $K => $V) {
            $res .= "\n" . $V;
            if ($K == $classLine) {
                $res .= "\n    " . $text;
            }
        }
        return $res;
    }

}
