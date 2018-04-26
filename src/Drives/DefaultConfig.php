<?php

namespace CrCms\FileConfig\Drives;

use CrCms\FileConfig\Contracts\FormatConfig;
use Illuminate\Support\Arr;

/**
 * Class DefaultConfig
 * @package CrCms\FileConfig\Drives
 */
class DefaultConfig implements FormatConfig
{
    /**
     * @var string
     */
    protected $delimiter = "\n";

    /**
     * @param string $content
     * @return array
     */
    public function read(string $content): array
    {
        $content = explode($this->delimiter, $content);
        $array = [];
        foreach ($content as $value) {
            $value = trim($value);
            if (empty($value) || strpos($value, '#') === 0 || strpos($value, '=') === false) {
                continue;
            }
            $value = explode('=', $value);
            $this->array_merge_recursive_adv($array, $this->resolveDot(trim($value[0]), trim($value[1])));
        }

        return $array;
    }

    /**
     * @param array $content
     * @return string
     */
    public function write(array $content): string
    {
        $content = Arr::dot($content);
        $string = '';
        foreach ($content as $key => $value) {
            $string .= "{$key}={$value}\n";
        }

        return rtrim($string, "\n");
    }

    /**
     * @param string $key
     * @param string $value
     * @return array
     */
    protected function resolveDot(string $key, string $value): array
    {
        if (strpos($key, '.') === false) {
            return [$key => $value];
        }

        $keys = array_reverse(explode('.', $key));
        $result = [];
        $count = count($keys);
        for ($i = 0; $i < $count; $i++) {
            $result = [$keys[$i] => ($i === 0 ? $value : $result)];
        }

        return $result;
    }

    /**
     * 递归的合并数组，重新编号整数键并将新值添加到现有的值
     *
     * @param array $array1
     * @param $array2
     * @return array
     */
    protected function array_merge_recursive_adv(array &$array1, array $array2): array
    {
        foreach ($array2 as $key => $value) {
            if (array_key_exists($key, $array1)) {
                if (is_array($value)) {
                    $this->array_merge_recursive_adv($array1[$key], $value);
                } else {
                    if (!empty($array1[$key])) {
                        if (is_array($array1[$key])) {
                            array_push($array1[$key], $value);
                        } else {
                            $array1[$key] = [$array1[$key]];
                            $array1[$key][] = $value;
                        }
                    } else if (empty($array1[$key])) {
                        $array1[$key] = $value;
                    }
                }
            } else {
                $array1[$key] = $value;
            }
        }

        return $array1;
    }
}