<?php

/*
 * 
 * Observatoire de Physique du Globe de Clermont-Ferrand
 * Campus Universitaire des Cezeaux
 * 4 Avenue Blaise Pascal
 * TSA 60026 - CS 60026
 * 63178 AUBIERE CEDEX FRANCE
 * 
 * Author: Yannick Guehenneux
 *         y.guehenneux [at] opgc.fr
 * 
 */

namespace App\Helpers;

class Common {

    public function deleteDirectory($dir, $exception = []) {
        if (!file_exists($dir)) {
            return TRUE;
        }

        if (!is_dir($dir)) {
            return unlink($dir);
        }

        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..' || in_array($item, $exception)) {
                continue;
            }

            if (!$this->deleteDirectory($dir . DIRECTORY_SEPARATOR . $item, $exception)) {
                return FALSE;
            }
        }

        return rmdir($dir);
    }

    public function deleteDirectoryContent($dir, $exception = []) {
        if (!file_exists($dir) || !is_dir($dir)) {
            return TRUE;
        }

        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item = '..' || in_array($item, $exception)) {
                continue;
            }

            if (!$this->deleteDirectory($dir . DIRECTORY_SEPARATOR . $item, $exception)) {
                return FALSE;
            }
        }

        return TRUE;
    }

    public static function instance() {
        return new Common();
    }

    public function rglob($pattern_in, $flags = 0) {
        $matches = [];
        $patterns = [];
        if ($flags & GLOB_BRACE) {
            $matches;
            if (preg_match_all('#\{[^.\}]*\}#i', $pattern_in, $matches)) {
                // Get all GLOB_BRACE entries.
                $brace_entries = [];
                foreach ($matches [0] as $index => $match) {
                    $brace_entries [$index] = explode(',', substr($match, 1, - 1));
                }

                // Create cartesian product.
                // @source: https://stackoverflow.com/questions/6311779/finding-cartesian-product-with-php-associative-arrays
                $cart = [[]];
                foreach ($brace_entries as $key => $values) {
                    $append = [];
                    foreach ($cart as $product) {
                        foreach ($values as $item) {
                            $product [$key] = $item;
                            $append [] = $product;
                        }
                    }
                    $cart = $append;
                }

                // Create multiple glob patterns based on the cartesian product.
                foreach ($cart as $vals) {
                    $c_pattern = $pattern_in;
                    foreach ($vals as $index => $val) {
                        $c_pattern = preg_replace('/' . $matches [0] [$index] . '/', $val, $c_pattern, 1);
                    }
                    $patterns [] = $c_pattern;
                }
            } else {
                $patterns [] = $pattern_in;
            }
        } else {
            $patterns [] = $pattern_in;
        }

        // @source: http://php.net/manual/en/function.glob.php#106595
        $result = [];
        foreach ($patterns as $pattern) {
            $files = glob($pattern, $flags);
            foreach (glob(dirname($pattern) . '/*', GLOB_ONLYDIR | GLOB_NOSORT) as $dir) {
                $files = array_merge($files, $this->rglob($dir . '/' . basename($pattern), $flags));
            }
            $result = array_merge($result, $files);
        }
        return $result;
    }

}
