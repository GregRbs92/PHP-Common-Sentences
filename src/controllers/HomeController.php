<?php

declare(strict_types=1);

namespace Controllers;

class HomeController
{
    public function compute($request)
    {
        if (empty($request['firstFile']) || empty($request['secondFile'])) {
            throw new \Exception("At least one file path is missing");
        }
        
        $sentences = [];

        $firstFile = file_get_contents($request['firstFile']);
        $this->splitText($firstFile, $sentences, false);
        unset($firstFile);

        $secondFile = file_get_contents($request['secondFile']);
        $this->splitText($secondFile, $sentences, true);
        unset($secondFile);

        $result = [];
        foreach ($sentences as $sentence => $occurences) {
            if ($occurences > 1) {
                $result[] = $sentence;
            }
        }

        return json_encode($result);
    }

    private function splitText($file, &$sentences, $isSecondFile)
    {
        $buffer = '';
        $fileLength = strlen($file);

        for ($i = 0; $i < $fileLength; $i++) {
            $buffer = $buffer . $file[$i];
            $isEOF = $i === $fileLength - 1;
            if ($isEOF) {
                $this->addKey($buffer, $sentences, $isSecondFile);
                $buffer = '';
            }
            else if (in_array($file[$i], ['?', '.', '!']) && $file[$i + 1] === ' ' && preg_match('/[A-Z]+/', $file[$i + 2])) {
                $this->addKey($buffer, $sentences, $isSecondFile);
                $buffer = '';
                $i++;
            }
        }
    }

    private function addKey($key, &$array, $isSecondFile)
    {
        if (isset($array[$key]) && $isSecondFile) {
            $array[$key]++;
        }
        else if (!$isSecondFile) {
            $array[$key] = 1;
        }
    }
}