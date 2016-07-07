<?php

namespace Chiquitto\Soul\Util;

/**
 * @package Chiquitto\Soul\Util
 */
abstract class AbstractCpfCnpj
{
    protected static $size;

    protected static $modifiers;

    private static function calcDigit($modifier, $value)
    {
        $result = 0; // Resultado Inicial
        $size = count($modifier); // Tamanho dos Modificadores
        for ($i = 0; $i < $size; $i++) {
            $result += $value[$i] * $modifier[$i]; // Somatório
        }
        $result = $result % 11;
        return ($result < 2 ? 0 : 11 - $result); // Dígito
    }

    private static function completeDigits($value)
    {
        foreach (static::$modifiers as $modifier) {
            $value .= static::calcDigit($modifier, $value);
        }
        return $value;
    }

    public static function generate()
    {
        $generated = '';

        $countModifiers = count(static::$modifiers);
        $size = static::$size - $countModifiers;
        for ($i = 0; $i < $size; $i++) {
            $generated .= mt_rand(0, 9);
        }

        return self::completeDigits($generated);
    }

    public static function getSize()
    {
        return static::$size;
    }

    public static function isValid($value)
    {
        foreach (static::$modifiers as $modifier) {
            if ($value[count($modifier)] != static::calcDigit($modifier, $value)) {
                return false;
            }
        }
        return true;
    }

}