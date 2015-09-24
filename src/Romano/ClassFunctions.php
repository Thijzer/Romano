<?php



class ClassFunctions
{
    function getInternalFunctions()
    {
        $internalFunctions = get_defined_functions()["internal"];
        sort($internalFunctions);
        $array = array();
        foreach ($internalFunctions as $function) {
            $array[] =
            [
                "text" => $function,
                "type" => "function",
                "descriptionMoreURL" =>
                    "http://php.net/manual/en/function." .
                    str_replace('_', '-', $function) . ".php"
            ];
        }
        return $array;
    }

    // https://github.com/Azakur4/autocomplete-php/blob/master/lib/php/get_internal_functions.php
    // http://stackoverflow.com/questions/15369291/how-to-ignore-directories-using-recursiveiteratoriterator
    function getClassNames($path = __DIR__)
    {
        $fqcns = array();
        $files = new RecursiveDirectoryIterator($path);
        $allFiles = new RecursiveIteratorIterator($files);
        $phpFiles = new RegexIterator($allFiles, '/\.php$/');
        //$phpFiles = new RegexIterator($phpFiles, '/(!TwigTemplate)/');
        foreach ($phpFiles as $phpFile) {

            ## filter on cach files
            if (strpos($phpFile->getRealPath(), 'Cache') !== false) {
                continue;
            }
            ## filter on cach files
            if (strpos($phpFile->getRealPath(), '/vendor/') !== false) {
                continue;
            }
            ## filter on cach files
            if (strpos($phpFile->getRealPath(), '/.garbage/') !== false) {
                continue;
            }

            $content = @file_get_contents($phpFile->getRealPath());
            // next steps is to put a regex on the content in 3 fases
            // 1st face is functions
            // 2d face is arguments of that functions + return of void
            // 3d function is annotations
            $tokens = @token_get_all($content);
            $namespace = '';
            for ($index = 0; isset($tokens[$index]); $index++) {
                if (!isset($tokens[$index][0])) {
                    continue;
                }
                if (T_NAMESPACE === $tokens[$index][0]) {
                    $index += 2; // Skip namespace keyword and whitespace
                    while (isset($tokens[$index]) && is_array($tokens[$index])) {
                        $namespace .= $tokens[$index++][1];
                    }
                }
                if (T_CLASS === $tokens[$index][0]) {
                    $index += 2; // Skip class keyword and whitespace
                    $tmp['class_name'] = $namespace.'\\'.$tokens[$index][1];
                    $tmp['real_path'] = $phpFile->getRealPath();
                    $tmp['functions'] = array();

                    // instanciating classes makes it implossible
                    // to handle php classes with multiple locations
                    // We also have no annotations and its already Quiet
                    // heavely on load.
                    if(!class_exists($tmp['class_name'])) {
                        require($tmp['real_path']);
                        $class = new ReflectionClass($tmp['class_name']);
                        $meth = $class->getMethods();
                        unset($class);
                        $tmp['functions'] = $meth;
                    }

                    $fqcns[] = $tmp;
                    unset($tmp);
                }
            }
        }
        var_dump($fqcns);exit;
        exit;
    }
}
